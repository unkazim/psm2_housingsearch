@extends('ui.layout')

@section('title', 'Student Dashboard')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
    }
    
    .navbar-custom {
        background-color: #1a237e;
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
    
    .hero-section {
        background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/uthm-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        position: relative;
    }

    .search-container {
        width: 100%;
        max-width: 800px;
        padding: 0 20px;
    }

    .search-box {
        background: rgba(255, 255, 255, 0.15);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(8px);
    }

    .search-title {
        font-size: 3.2rem;
        font-weight: 800;
        margin-bottom: 35px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
        letter-spacing: 1px;
    }

    .form-control-lg {
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        color: white;
    }

    .form-control-lg::placeholder {
        color: rgba(255, 255, 255, 0.8);
    }

    .form-control-lg:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
        color: white;
    }

    .location-tags {
        margin-top: 25px;
    }

    .location-tag {
        background: rgba(26, 35, 126, 0.8);
        color: white;
        padding: 10px 25px;
        border-radius: 30px;
        margin: 5px 8px;
        text-decoration: none;
        border: 2px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        display: inline-block;
        font-weight: 500;
        backdrop-filter: blur(4px);
    }

    .text-dark {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .location-tag:hover {
        background: #303f9f;
        border-color: #303f9f;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(26, 35, 126, 0.2);
    }

    .table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .table thead {
        background: linear-gradient(45deg, #1a237e, #303f9f);
        color: white;
    }

    .table th {
        font-weight: 600;
        padding: 15px;
        border: none;
    }

    .table td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .badge {
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 500;
    }

    .badge.bg-warning {
        background-color: #ff9800 !important;
        color: white;
    }

    .badge.bg-success {
        background-color: #4caf50 !important;
    }

    .badge.bg-danger {
        background-color: #f44336 !important;
    }

    .property-section {
        padding: 60px 0;
        background-color: #f8f9fa;
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 30px;
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    
    .applications-section {
        padding: 60px 0;
        background-color: #f5f7fa;
        background-image: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
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
                    <a class="nav-link active" href="{{ route('student.dashboard') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-dropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->profile_image)
                            <img src="{{ asset('profile_images/'.Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="profile-img-small">
                        @else
                            <i class="fas fa-user-circle me-1"></i>
                        @endif
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}">Profile</a></li>
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

<!-- Hero Section with Search -->
<section class="hero-section">
    <div class="search-container">
        <h1 class="search-title">Find Your Perfect Student Housing</h1>
        <div class="search-box">
            <form action="{{ route('student.search') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg" name="location" placeholder="Search by location, area, or property name...">
                    <button class="btn btn-search btn-lg" type="submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
            <div class="location-tags">
                <p class="text-dark mb-2">Popular locations:</p>
                <a href="{{ route('student.search', ['location' => 'Parit Raja']) }}" class="location-tag">Parit Raja</a>
                <a href="{{ route('student.search', ['location' => 'Batu Pahat']) }}" class="location-tag">Batu Pahat</a>
            </div>
        </div>
    </div>
</section>

<!-- Rental Applications Section -->
<section class="applications-section">
    <div class="container">
        <h2 class="mb-4">My Rental Applications</h2>
        
        @if($rentalApplications->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                You haven't submitted any rental applications yet.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Property</th>
                            <th>Landlord</th>
                            <th>Application Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rentalApplications as $application)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($application->property->images->isNotEmpty())
                                            <img src="{{ asset($application->property->images->first()->image_url) }}" 
                                                 alt="Property" class="me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        @endif
                                        <div>
                                            <strong>{{ $application->property->title }}</strong>
                                            <div class="small text-muted">{{ $application->property->address }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $application->property->landlord->user->name }}</td>
                                <td>{{ $application->application_date->format('d M Y') }}</td>
                                <td>
                                    @if($application->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($application->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('student.property.details', $application->property->property_id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View Property
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection