<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Review;
use App\Models\Student;
use App\Models\RentalApplication; // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class StudentViewController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:student');
    }

    public function dashboard()
    {
        // Get featured properties for the dashboard
        $featuredProperties = Property::with('images')
            ->where('status', 'available')
            ->orderBy('listed_date', 'desc')
            ->take(3)
            ->get();
            
        // Get student's rental applications
        $student = Auth::user()->student;
        $rentalApplications = RentalApplication::with(['property', 'property.landlord.user'])
            ->where('student_id', $student->student_id)
            ->orderBy('application_date', 'desc')
            ->get();
            
        return view('student.dashboard', compact('featuredProperties', 'rentalApplications'));
    }

    public function searchProperties(Request $request)
    {
        $query = Property::with(['images', 'landlord.user'])
            ->where('status', 'available');
            
        // Apply location filter
        if ($request->has('location') && !empty($request->location)) {
            $query->where('address', 'like', '%' . $request->location . '%');
        }
        
        // Apply price range filter
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('monthly_rent', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('monthly_rent', '<=', $request->max_price);
        }
        
        // Apply bedrooms filter
        if ($request->has('bedrooms') && !empty($request->bedrooms) && $request->bedrooms != 'Any') {
            $query->where('bedrooms', '=', $request->bedrooms);
        }
        
        // Apply property type filter
        if ($request->has('property_type') && !empty($request->property_type) && $request->property_type != 'Any Type') {
            $query->where('property_type', '=', $request->property_type);
        }
        
        // Apply gender preference filter
        if ($request->has('gender') && !empty($request->gender) && $request->gender != 'Any') {
            $query->where(function($q) use ($request) {
                $q->where('preferred_gender', '=', $request->gender)
                  ->orWhere('preferred_gender', '=', 'any');
            });
        }
        
        $properties = $query->orderBy('listed_date', 'desc')->paginate(6);
        $searchTerm = $request->location ?? '';
        $count = $properties->total();
        
        return view('student.search-results', compact('properties', 'searchTerm', 'count'));
    }
    
    public function propertyDetails($id)
    {
        $property = Property::with(['images', 'landlord.user', 'reviews.student.user'])
            ->findOrFail($id);
            
        // Get similar properties
        $similarProperties = Property::with('images')
            ->where('property_id', '!=', $id)
            ->where('status', 'available')
            ->where(function($query) use ($property) {
                $query->where('address', 'like', '%' . explode(' ', $property->address)[0] . '%')
                      ->orWhere('property_type', '=', $property->property_type);
            })
            ->take(3)
            ->get();
            
        // Check if the current student has already reviewed this property
        $hasReviewed = false;
        if (Auth::check() && Auth::user()->hasRole('student')) {
            $studentId = Auth::user()->student->student_id;
            $hasReviewed = Review::where('property_id', $id)
                ->where('student_id', $studentId)
                ->exists();
        }
            
        return view('student.property-details', compact('property', 'similarProperties', 'hasReviewed'));
    }
    
    public function newSearch()
    {
        // Get all available property types for the filter
        $propertyTypes = Property::select('property_type')
            ->distinct()
            ->pluck('property_type');
            
        return view('student.search', compact('propertyTypes'));
    }
    
    public function submitReview(Request $request, $propertyId)
    {
        // Validate the request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);
        
        // Get the student ID from the authenticated user
        $studentId = Auth::user()->student->student_id;
        
        // Check if the student has already reviewed this property
        $existingReview = Review::where('property_id', $propertyId)
            ->where('student_id', $studentId)
            ->first();
            
        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'review_date' => now(),
            ]);
            
            return redirect()->back()->with('success', 'Your review has been updated successfully!');
        } else {
            // Create new review
            Review::create([
                'property_id' => $propertyId,
                'student_id' => $studentId,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'review_date' => now(),
            ]);
            
            return redirect()->back()->with('success', 'Your review has been submitted successfully!');
        }
    }
    
    // Add these methods to your StudentViewController class
    
    public function showProfile()
    {
        $user = auth()->user();
        // Get student details with join to user table
        $student = Student::join('users', 'students.user_id', '=', 'users.user_id')
            ->where('students.user_id', $user->user_id)
            ->select('students.*', 'users.name', 'users.email', 'users.phone')
            ->first();
      
        if (!$student) {
            return redirect()->route('student.dashboard')->with('error', 'Student profile not found.');
        }
        
        return view('student.profile', compact('student', 'user'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Create directory if it doesn't exist
            $profileImagesPath = public_path('profile_images');
            if (!File::exists($profileImagesPath)) {
                File::makeDirectory($profileImagesPath, 0755, true);
            }
            
            // Delete old image if exists
            if ($user->profile_image && File::exists(public_path('profile_images/' . $user->profile_image))) {
                File::delete(public_path('profile_images/' . $user->profile_image));
            }
            
            // Generate unique filename
            $imageName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
            
            // Move the uploaded file
            $request->file('profile_image')->move($profileImagesPath, $imageName);
            
            // Update user's profile image field
            $user->profile_image = $imageName;
        }
        
        // Update other user information
        $user->name = $validated['name'];
        if (isset($validated['phone'])) {
            $user->phone = $validated['phone'];
        }
        $user->save();
        
        return redirect()->route('student.profile')
                         ->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = Auth::user();
    
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    
        $user->password = Hash::make($request->password);
        $user->save();
    
        return redirect()->route('student.profile')
                       ->with('success', 'Password updated successfully!');
    }

    public function applyForRental(Request $request, $propertyId)
    {
        $property = Property::findOrFail($propertyId);
        
        // Check if property is available
        if ($property->status !== 'available') {
            return back()->with('error', 'Sorry, this property is no longer available.');
        }
        
        // Check if student has already applied
        $existingApplication = RentalApplication::where('property_id', $propertyId)
            ->where('student_id', Auth::user()->student->student_id)
            ->where('status', 'pending')
            ->first();
        
        if ($existingApplication) {
            return back()->with('error', 'You have already applied for this property.');
        }
        
        // Create new application
        $application = new RentalApplication([
            'property_id' => $propertyId,
            'student_id' => Auth::user()->student->student_id,
            'application_date' => now(),
            'status' => 'pending',
            'message' => $request->message
        ]);
        
        $application->save();
        
        return back()->with('success', 'Your rental application has been submitted successfully!');
    }
    
    public function deleteProfileImage()
    {
        $user = Auth::user();
        
        // Check if user has a profile image
        if ($user->profile_image) {
            // Delete the image file
            $imagePath = public_path('profile_images/' . $user->profile_image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            
            // Remove the profile image reference from the user
            $user->profile_image = null;
            $user->save();
            
            return redirect()->route('student.profile')->with('success', 'Profile image removed successfully!');
        }
        
        return redirect()->route('student.profile')->with('error', 'No profile image to remove.');
    }
}