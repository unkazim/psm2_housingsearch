<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentViewController;
use App\Http\Controllers\LandlordViewController;
use App\Http\Controllers\AdminViewController;
use Illuminate\Support\Facades\Route;

// Guest routes
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');


// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Student routes
    Route::middleware('role:student')->group(function () {
        Route::get('/student-area', [StudentViewController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/properties/search', [StudentViewController::class, 'searchProperties'])->name('student.search');
        Route::get('/properties/new-search', [StudentViewController::class, 'newSearch'])->name('student.new-search');
        
        // Review submission route
        Route::post('/properties/{id}/review', [StudentViewController::class, 'submitReview'])->name('student.submit.review');
        
        // Move the wildcard route to the end so it doesn't catch other routes
        Route::get('/properties/{id}', [StudentViewController::class, 'propertyDetails'])->name('student.property.details');
        
        // Add these routes to the student routes group
        Route::get('/profile', [StudentViewController::class, 'showProfile'])->name('student.profile');
        Route::post('/profile/update', [StudentViewController::class, 'updateProfile'])->name('student.profile.update');
    });

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin-area', [AdminViewController::class, 'dashboard'])->name('admin.dashboard');
    });

    // Landlord routes
    Route::middleware('role:landlord')->group(function () {
        Route::get('/landlord-area', [LandlordViewController::class, 'dashboard'])->name('landlord.dashboard');
    });
});