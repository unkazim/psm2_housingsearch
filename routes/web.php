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
        
        // Add this new route for rental applications
        Route::post('/properties/{id}/apply', [StudentViewController::class, 'applyForRental'])->name('student.apply.rental');
    });

    // Landlord routes
    Route::middleware('role:landlord')->group(function () {
        Route::get('/landlord-area', [LandlordViewController::class, 'dashboard'])->name('landlord.dashboard');
        
        // Property management
        Route::get('/landlord/properties', [LandlordViewController::class, 'properties'])->name('landlord.properties');
        Route::get('/landlord/properties/create', [LandlordViewController::class, 'createProperty'])->name('landlord.properties.create');
        Route::post('/landlord/properties', [LandlordViewController::class, 'storeProperty'])->name('landlord.properties.store');
        Route::get('/landlord/properties/{id}/edit', [LandlordViewController::class, 'editProperty'])->name('landlord.properties.edit');
        Route::put('/landlord/properties/{id}', [LandlordViewController::class, 'updateProperty'])->name('landlord.properties.update');
        Route::delete('/landlord/properties/{id}', [LandlordViewController::class, 'deleteProperty'])->name('landlord.properties.delete');
        
        // Rental applications
        Route::get('/landlord/applications', [LandlordViewController::class, 'applications'])->name('landlord.applications');
        Route::put('/landlord/applications/{id}/update-status', [LandlordViewController::class, 'updateApplicationStatus'])
            ->name('landlord.applications.updateStatus');
        
        // Profile
        Route::get('/landlord/profile', [LandlordViewController::class, 'profile'])->name('landlord.profile');
        Route::post('/landlord/profile/update', [LandlordViewController::class, 'updateProfile'])->name('landlord.profile.update');
    });
    
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin-area', [AdminViewController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/pending-landlords', [AdminViewController::class, 'pendingLandlords'])->name('admin.pending-landlords');
        Route::post('/admin/landlords/{id}/approve', [AdminViewController::class, 'approveLandlord'])->name('admin.landlords.approve');
        Route::post('/admin/landlords/{id}/reject', [AdminViewController::class, 'rejectLandlord'])->name('admin.landlords.reject');
        Route::get('/admin/landlords', [AdminViewController::class, 'allLandlords'])->name('admin.landlords');
        Route::get('/admin/students', [AdminViewController::class, 'allStudents'])->name('admin.students');
        
        // Add these new routes for deleting accounts
        Route::delete('/admin/students/{id}/delete', [AdminViewController::class, 'deleteStudent'])->name('admin.students.delete');
        Route::delete('/admin/landlords/{id}/delete', [AdminViewController::class, 'deleteLandlord'])->name('admin.landlords.delete');
        
        // Add these new routes for property management
        Route::get('/admin/properties', [AdminViewController::class, 'allProperties'])->name('admin.properties');
        Route::get('/admin/properties/{id}', [AdminViewController::class, 'propertyDetails'])->name('admin.property.details');
        Route::delete('/admin/properties/{id}/delete', [AdminViewController::class, 'deleteProperty'])->name('admin.property.delete');
        Route::delete('/admin/reviews/{id}/delete', [AdminViewController::class, 'deleteReview'])->name('admin.review.delete');
    });
});