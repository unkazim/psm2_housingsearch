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
        // Common validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:student,landlord',
        ];

        // Add student-specific validation rules
        if ($request->user_type === 'student') {
            $rules = array_merge($rules, [
                'matric_number' => 'required|string|max:20|unique:students',
                'faculty' => 'required|string|max:255',
                'course' => 'required|string|max:255',
                'semester' => 'required|integer|min:1|max:8',
            ]);
        }

        // Validate the request
        $validated = $request->validate($rules);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
            'status' => 'active'
        ]);

        // Create role-specific record
        if ($validated['user_type'] === 'student') {
            Student::create([
                'user_id' => $user->user_id,
                'matric_number' => $validated['matric_number'],
                'faculty' => $validated['faculty'],
                'course' => $validated['course'],
                'semester' => $validated['semester']
            ]);
        } else {
            // Create landlord record
            Landlord::create([
                'user_id' => $user->user_id,
                'bank_account' => null, // These can be updated later in profile
                'ic_number' => null
            ]);
        }

        // Log the user in
        Auth::login($user);

        // Redirect based on user type
        if ($user->user_type === 'student') {
            return redirect()->route('student.dashboard')
                ->with('success', 'Registration successful! Welcome to your student dashboard.');
        } else {
            return redirect()->route('landlord.dashboard')
                ->with('success', 'Registration successful! Welcome to your landlord dashboard.');
        }
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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->user_type === 'student') {
                return redirect()->route('student.dashboard');
            } else {
                return redirect()->route('landlord.dashboard');
            }
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