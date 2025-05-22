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
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .profile-header {
        background-color: #4a148c;
        color: white;
        padding: 20px;
        text-align: center;
    }
    
    .profile-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        margin: 0 auto 15px;
        object-fit: cover;
        background-color: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        overflow: hidden;
        position: relative;
    }
    
    .profile-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .profile-img-small {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 8px;
        border: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .user-dropdown {
        display: flex;
        align-items: center;
        color: white;
    }
    
    .user-dropdown i {
        font-size: 24px;
        margin-right: 8px;
    }
    
    .profile-body {
        padding: 30px;
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
    
    .navbar-custom {
        background-color: #4a148c;
        padding: 10px 0;
    }
    
    .navbar-brand {
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
    }
    
    .navbar-nav .nav-link {
        color: white;
        margin-left: 15px;
    }
    
    .profile-img-small {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 5px;
    }
    
    .user-dropdown {
        display: flex;
        align-items: center;
    }
</style>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom">
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-dropdown active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->profile_image)
                            <img src="{{ asset('profile_images/'.Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="profile-img-small">
                        @else
                            <i class="fas fa-user-circle me-1"></i>
                        @endif
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item active" href="{{ route('student.profile') }}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="profile-section">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="profile-card">
                    <!-- Update the profile header section -->
                    <div class="profile-header">
                        <div class="profile-img">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('profile_images/'.Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}">
                            @else
                                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <h4>{{ Auth::user()->name }}</h4>
                        <p class="mb-0">Student</p>
                    </div>
                    <div class="profile-body">
                        <form action="{{ route('profile.update-image') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="profile_image" class="form-label">Profile Image</label>
                                <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                                <small class="form-text text-muted">Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Update Profile Image</button>
                                @if(Auth::user()->profile_image)
                                    <a href="{{ route('student.profile.delete-image') }}" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to remove your profile image?')">Remove Image</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card profile-card mb-4">
                    <div class="card-body">
                        <ul class="nav nav-pills mb-4" id="profileTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="personal-tab" data-bs-toggle="pill" data-bs-target="#personal" type="button" role="tab">Personal Information</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="security-tab" data-bs-toggle="pill" data-bs-target="#security" type="button" role="tab">Security</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="profileTabContent">
                            <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                <form action="{{ route('student.profile.update') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" disabled>
                                        <small class="form-text text-muted">Email cannot be changed.</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </form>
                            </div>
                            
                            <div class="tab-pane fade" id="security" role="tabpanel">
                                <form action="{{ route('student.password.update') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        @error('current_password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
    // Activate tab based on session data
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('active_tab'))
            const tabToActivate = document.getElementById('{{ session('active_tab') }}-tab');
            if (tabToActivate) {
                const tab = new bootstrap.Tab(tabToActivate);
                tab.show();
            }
        @endif
    });
</script>
@endpush
@endsection