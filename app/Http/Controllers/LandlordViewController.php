<?php

namespace App\Http\Controllers;

use App\Models\Landlord;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\RentalApplication; // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandlordViewController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:landlord');
    }

    public function dashboard()
    {
        $landlord = Auth::user()->landlord;
        $properties = Property::where('landlord_id', $landlord->landlord_id)
            ->withCount(['rentalApplications' => function($query) {
                $query->where('status', 'pending');
            }])
            ->get();
            
        $pendingApplicationsCount = RentalApplication::whereIn('property_id', $properties->pluck('property_id'))
            ->where('status', 'pending')
            ->count();
            
        // Get recent applications
        $recentApplications = RentalApplication::with(['property', 'student.user'])
            ->whereIn('property_id', $properties->pluck('property_id'))
            ->orderBy('application_date', 'desc')
            ->take(5)
            ->get();
            
        return view('landlord.dashboard', compact('properties', 'pendingApplicationsCount', 'recentApplications'));
    }
    
    public function properties()
    {
        $landlord = Auth::user()->landlord;
        $properties = Property::where('landlord_id', $landlord->landlord_id)
            ->withCount('rentalApplications')
            ->get();
            
        return view('landlord.properties', compact('properties'));
    }
    
    public function createProperty()
    {
        return view('landlord.property-form');
    }
    
    public function storeProperty(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'monthly_rent' => 'required|numeric|min:0',
            'distance_from_uthm' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'preferred_gender' => 'required|in:any,male,female',
            'property_type' => 'required|string|max:255',
            'map_link' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $landlord = Auth::user()->landlord;
        
        $property = Property::create([
            'landlord_id' => $landlord->landlord_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'monthly_rent' => $validated['monthly_rent'],
            'distance_from_uthm' => $validated['distance_from_uthm'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'listed_date' => now(),
            'status' => 'available',
            'preferred_gender' => $validated['preferred_gender'],
            'property_type' => $validated['property_type'],
            'map_link' => $validated['map_link'],
        ]);
        
        // In the storeProperty method
        if ($request->hasFile('images')) {
            $displayOrder = 1;
            foreach ($request->file('images') as $image) {
                $filename = 'property_' . $property->property_id . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                
                // Store directly in public path instead of storage
                $image->move(public_path('property_images'), $filename);
                $publicPath = 'property_images/' . $filename;
                
                PropertyImage::create([
                    'property_id' => $property->property_id,
                    'image_url' => $publicPath,
                    'display_order' => $displayOrder++
                ]);
            }
        }
        
        return redirect()->route('landlord.properties')->with('success', 'Property created successfully!');
    }
    
    public function editProperty($id)
    {
        $landlord = Auth::user()->landlord;
        $property = Property::where('landlord_id', $landlord->landlord_id)
            ->findOrFail($id);
            
        return view('landlord.property-form', compact('property'));
    }
    
    public function updateProperty(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'monthly_rent' => 'required|numeric|min:0',
            'distance_from_uthm' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'preferred_gender' => 'required|in:any,male,female',
            'property_type' => 'required|string|max:255',
            'status' => 'required|in:available,rented,unavailable',
            'map_link' => 'nullable|url',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $landlord = Auth::user()->landlord;
        $property = Property::where('landlord_id', $landlord->landlord_id)
            ->findOrFail($id);
            
        $property->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'monthly_rent' => $validated['monthly_rent'],
            'distance_from_uthm' => $validated['distance_from_uthm'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'status' => $validated['status'],
            'preferred_gender' => $validated['preferred_gender'],
            'property_type' => $validated['property_type'],
            'map_link' => $validated['map_link'],
        ]);
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            $maxOrder = $property->images()->max('display_order') ?? 0;
            $displayOrder = $maxOrder + 1;
            
            foreach ($request->file('images') as $image) {
                $filename = 'property_' . $property->property_id . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                
                // Store directly in public path instead of storage
                $image->move(public_path('property_images'), $filename);
                $publicPath = 'property_images/' . $filename;
                
                PropertyImage::create([
                    'property_id' => $property->property_id,
                    'image_url' => $publicPath,
                    'display_order' => $displayOrder++
                ]);
            }
        }
        
        // Handle image deletions
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = PropertyImage::where('property_id', $property->property_id)
                    ->where('image_id', $imageId)
                    ->first();
                    
                if ($image) {
                    // Delete file from public directory
                    if (file_exists(public_path($image->image_url))) {
                        unlink(public_path($image->image_url));
                    }
                    
                    // Delete the database record
                    $image->delete();
                }
            }
        }
        
        return redirect()->route('landlord.properties')->with('success', 'Property updated successfully!');
    }
    
    public function deleteProperty($id)
    {
        $landlord = Auth::user()->landlord;
        $property = Property::where('landlord_id', $landlord->landlord_id)
            ->findOrFail($id);
            
        // Check if there are active rental applications
        $hasActiveApplications = $property->rentalApplications()
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
            
        if ($hasActiveApplications) {
            return redirect()->route('landlord.properties')
                ->with('error', 'Cannot delete property with active rental applications.');
        }
        
        // In the deleteProperty method, update the image deletion logic
        // Delete all images
        foreach ($property->images as $image) {
        // Delete file from public directory
        if (file_exists(public_path($image->image_url))) {
            unlink(public_path($image->image_url));
        }
        
        // Delete the database record
        $image->delete();
        }
        
        // Delete the property
        $property->delete();
        
        return redirect()->route('landlord.properties')
            ->with('success', 'Property deleted successfully!');
    }
    
    public function applications()
    {
        $landlord = Auth::user()->landlord;
        $properties = Property::where('landlord_id', $landlord->landlord_id)->pluck('property_id');
        
        $applications = RentalApplication::with(['property', 'student.user'])
            ->whereIn('property_id', $properties)
            ->orderBy('application_date', 'desc')
            ->get();
            
        return view('landlord.applications', compact('applications'));
    }
    
    public function updateApplicationStatus(Request $request, $id)
    {
        $application = RentalApplication::findOrFail($id);
        $property = Property::findOrFail($application->property_id);
        
        if ($request->status === 'approved') {
            // Mark the property as rented
            $property->update(['status' => 'rented']);
            
            // Reject all other pending applications for this property
            RentalApplication::where('property_id', $property->property_id)
                ->where('application_id', '!=', $id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        }
        
        // Update the application status
        $application->update([
            'status' => $request->status
        ]);
        
        return redirect()->back()->with('success', 'Application ' . ucfirst($request->status));
    }
}