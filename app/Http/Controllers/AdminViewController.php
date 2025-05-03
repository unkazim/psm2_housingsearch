<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Landlord;
use App\Models\Property;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminViewController extends Controller
{
    // Remove the constructor with middleware
    // public function __construct()
    // {
    //     $this->middleware('role:admin');
    // }

    public function dashboard()
    {
        // Get counts for dashboard statistics
        $studentCount = Student::count();
        $landlordCount = Landlord::count();
        $pendingLandlordCount = Landlord::where('approval_status', 'pending')->count();
        $propertyCount = Property::count();
        
        return view('admin.dashboard', compact(
            'studentCount', 
            'landlordCount', 
            'pendingLandlordCount',
            'propertyCount'
        ));
    }
    
    public function pendingLandlords()
    {
        $pendingLandlords = Landlord::where('approval_status', 'pending')
            ->with('user')
            ->get();
            
        return view('admin.pending-landlords', compact('pendingLandlords'));
    }
    
    public function approveLandlord(Request $request, $id)
    {
        $landlord = Landlord::findOrFail($id);
        $landlord->approval_status = 'approved';
        $landlord->save();
        
        return redirect()->route('admin.pending-landlords')
            ->with('success', 'Landlord account has been approved successfully.');
    }
    
    public function rejectLandlord(Request $request, $id)
    {
        $landlord = Landlord::findOrFail($id);
        $landlord->approval_status = 'rejected';
        $landlord->save();
        
        return redirect()->route('admin.pending-landlords')
            ->with('success', 'Landlord account has been rejected.');
    }
    
    public function allLandlords()
    {
        $landlords = Landlord::with('user')->get();
        return view('admin.landlords', compact('landlords'));
    }
    
    public function allStudents()
    {
        $students = Student::with('user')->get();
        return view('admin.students', compact('students'));
    }
    
    /**
     * Delete a student account and associated user
     */
    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $userId = $student->user_id;
        
        // Delete student record
        $student->delete();
        
        // Delete associated user
        User::where('id', $userId)->delete();
        
        return redirect()->route('admin.students')
            ->with('success', 'Student account has been deleted successfully.');
    }
    
    /**
     * Display all properties
     */
    public function allProperties()
    {
        $properties = Property::with(['landlord.user', 'images'])->get();
        return view('admin.properties', compact('properties'));
    }
    
    /**
     * Display property details
     */
    public function propertyDetails($id)
    {
        $property = Property::with(['landlord.user', 'images', 'reviews.student.user'])->findOrFail($id);
        return view('admin.property-details', compact('property'));
    }
    
    /**
     * Delete a property
     */
    public function deleteProperty($id)
    {
        $property = Property::findOrFail($id);
        
        // Delete associated images
        foreach ($property->images as $image) {
            // Delete the image file if it exists
            if (file_exists(public_path($image->image_url))) {
                unlink(public_path($image->image_url));
            }
            $image->delete();
        }
        
        // Delete the property
        $property->delete();
        
        return redirect()->route('admin.properties')
            ->with('success', 'Property has been deleted successfully.');
    }
    
    /**
     * Delete a review
     */
    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $propertyId = $review->property_id;
        
        // Delete the review
        $review->delete();
        
        return redirect()->route('admin.property.details', $propertyId)
            ->with('success', 'Review has been deleted successfully.');
    }
    
    /**
     * Delete a landlord account and associated user
     */
    public function deleteLandlord($id)
    {
        $landlord = Landlord::findOrFail($id);
        $userId = $landlord->user_id;
        
        // Delete landlord record
        $landlord->delete();
        
        // Delete associated user
        User::where('id', $userId)->delete();
        
        return redirect()->route('admin.landlords')
            ->with('success', 'Landlord account has been deleted successfully.');
    }
}