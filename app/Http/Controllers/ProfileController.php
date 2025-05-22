<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function updateImage(Request $request)
    {
        // Validate the request
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = Auth::user();
        
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
        $user->save();
        
        // Redirect back with success message
        return redirect()->back()->with('success', 'Profile image updated successfully!');
    }
}