<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Landlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:student,landlord',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type, // Changed from 'role' to 'user_type'
        ]);

        // Create the role-specific record
        if ($request->user_type === 'student') {
            // Validate student-specific fields
            $request->validate([
                'matric_number' => 'required|string|max:20|unique:students',
                'faculty' => 'required|string|max:255',
                'course' => 'required|string|max:255',
                'semester' => 'required|integer|min:1|max:8',
            ]);

            // Create student record
            Student::create([
                'user_id' => $user->user_id,
                'matric_number' => $request->matric_number,
                'faculty' => $request->faculty,
                'course' => $request->course,
                'semester' => $request->semester,
            ]);
        } else if ($request->user_type === 'landlord') {
            // Validate landlord-specific fields
            $request->validate([
                'ic_number' => 'required|string|max:20',
                'bank_account' => 'required|string|max:255',
            ]);

            // Create landlord record with pending approval status
            Landlord::create([
                'user_id' => $user->user_id,
                'ic_number' => $request->ic_number,
                'bank_account' => $request->bank_account,
                'approval_status' => 'pending', // Set initial status as pending
            ]);
        }

        // Redirect to login with success message
        return redirect()->route('login')->with('status', 'Registration successful! ' .
            ($request->user_type === 'landlord' ? 'Your account is pending approval by an administrator.' : 'You can now log in.') .
            ($request->user_type === 'landlord' ? 'Your account is pending approval by an administrator.' : 'You can now log in.'));
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Determine if username is email or username
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        // Attempt to authenticate
        if (Auth::attempt([$loginType => $request->username, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();
            
            // Check if user is a landlord and if they're approved
            if ($user->user_type === 'landlord') { // Changed from 'role' to 'user_type'
                $landlord = Landlord::where('user_id', $user->user_id)->first();
                
                if ($landlord && $landlord->approval_status !== 'approved') {
                    Auth::logout();
                    return back()->withErrors([
                        'username' => 'Your landlord account is pending approval by an administrator.',
                    ]);
                }
            }
            
            $request->session()->regenerate();
            
            // Redirect based on role
            if ($user->user_type === 'student') { // Changed from 'role' to 'user_type'
                return redirect()->route('student.dashboard');
            } else if ($user->user_type === 'landlord') { // Changed from 'role' to 'user_type'
                return redirect()->route('landlord.dashboard');
            } else if ($user->user_type === 'admin') { // Changed from 'role' to 'user_type'
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}