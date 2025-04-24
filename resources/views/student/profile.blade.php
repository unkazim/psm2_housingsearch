@extends('ui.layout')

@section('title', 'Student Profile')

@section('content')
<style>
    .profile-section {
        padding: 120px 0 60px;
        background-color: #f8f9fa;
        min-height: 100vh;
    }
    
    .profile-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 30px;
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        background-color: #4a148c;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 40px;
        margin-right: 20px;
    }
    
    .nav-pills .nav-link.active {
        background-color: #4a148c;
    }
    
    .nav-pills .nav-link {
        color: #4a148c;
    }
    
    .btn-primary {
        background-color: #4a148c;
        border-color: #4a148c;
    }
    
    .btn-primary:hover {
        background-color: #6a1b9a;
        border-color: #6a1b9a;
    }
    
    /* Add styles for the top bar logo/text */
    .navbar-brand {
        font-weight: 600;
        cursor: pointer;
    }
</style>

<!-- Add a navigation bar at the top -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('student.dashboard') }}">UTHM Student Housing</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.dashboard') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('student.profile') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn nav-link border-0 bg-transparent">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $user->name }}</h3>
                            <p class="text-muted mb-0">Student</p>
                        </div>
                    </div>
                    
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link {{ session('active_tab') != 'security' ? 'active' : '' }}" id="profile-info-tab" data-bs-toggle="pill" data-bs-target="#profile-info" type="button" role="tab">
                            <i class="fas fa-user-circle me-2"></i> Profile Information
                        </button>
                        <button class="nav-link {{ session('active_tab') == 'security' ? 'active' : '' }}" id="security-tab" data-bs-toggle="pill" data-bs-target="#security" type="button" role="tab">
                            <i class="fas fa-shield-alt me-2"></i> Security
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="profile-card">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- Profile Information Tab -->
                        <div class="tab-pane fade {{ session('active_tab') != 'security' ? 'show active' : '' }}" id="profile-info" role="tabpanel" aria-labelledby="profile-info-tab">
                            <h4 class="mb-4">Profile Information</h4>
                            
                            <form action="{{ route('student.profile.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="update_type" value="profile">
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="matric_number" class="form-label">Matric Number</label>
                                        <input type="text" class="form-control" id="matric_number" value="{{ $student->matric_number }}" disabled>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="faculty" class="form-label">Faculty</label>
                                        <input type="text" class="form-control" id="faculty" value="{{ $student->faculty }}" disabled>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="course" class="form-label">Course</label>
                                        <input type="text" class="form-control" id="course" value="{{ $student->course }}" disabled>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="semester" class="form-label">Semester</label>
                                        <input type="text" class="form-control" id="semester" value="{{ $student->semester }}" disabled>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Security Tab -->
                        <div class="tab-pane fade {{ session('active_tab') == 'security' ? 'show active' : '' }}" id="security" role="tabpanel" aria-labelledby="security-tab">
                            <h4 class="mb-4">Change Password</h4>
                            
                            <form action="{{ route('student.profile.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="update_type" value="password">
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key me-2"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection