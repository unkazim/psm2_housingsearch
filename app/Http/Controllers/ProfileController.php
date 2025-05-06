<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = Auth::user();
        
        // Delete old image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete('profile_images/' . $user->profile_image);
        }
        
        // Generate a unique filename
        $fileName = 'profile_' . $user->id . '_' . uniqid() . '.' . $request->file('profile_image')->extension();
        
        // Store the image
        $request->file('profile_image')->storeAs('profile_images', $fileName, 'public');
        
        // Update user record
        $user->profile_image = $fileName;
        $user->save();
        
        // Redirect back with success message
        $redirectRoute = Auth::user()->role === 'landlord' ? 'landlord.profile' : 'student.profile';
        return redirect()->route($redirectRoute)->with('profile_success', 'Profile image updated successfully!');
    }
}