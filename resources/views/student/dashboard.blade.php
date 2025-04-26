@extends('ui.layout')

@section('title', 'Student Dashboard')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
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
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .search-title {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 30px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .location-tags {
        margin-top: 20px;
    }

    .location-tag {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 8px 20px;
        border-radius: 30px;
        margin: 0 8px;
        text-decoration: none;
        border: 1px solid white;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .location-tag:hover {
        background: rgba(255, 255, 255, 0.4);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-search {
        background-color: #4a148c;
        border-color: #4a148c;
    }
    
    .btn-search:hover {
        background-color: #6a1b9a;
        border-color: #6a1b9a;
    }
    
    .property-section {
        padding: 60px 0;
        background-color: #f8f9fa;
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 30px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    .card-img-top {
        height: 200px;
        object-fit: cover;
    }
</style>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">UTHM Housing Search</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.dashboard') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.profile') }}">Profile</a>
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

<!-- Hero Section with Search -->
<div class="hero-section">
    <div class="search-container">
        <h1 class="search-title">Find Your Perfect Student Housing</h1>
        
        <div class="search-box">
            <form action="{{ route('student.search') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" 
                           name="location"
                           placeholder="Search by location (e.g., Parit Raja, Parit Jelutong)">
                    <button type="submit" class="btn btn-primary btn-lg btn-search">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>

        <div class="location-tags mt-4">
            <a href="{{ route('student.search', ['location' => 'Parit Raja']) }}" class="location-tag">Parit Raja</a>
            <a href="{{ route('student.search', ['location' => 'Batu Pahat']) }}" class="location-tag">Batu Pahat</a>
        </div>
    </div>
</div>

<!-- Property Listings -->
<div class="property-section">
    <div class="container">
        <h2 class="text-center mb-5">Featured Properties</h2>
        <div class="row">
            @forelse($featuredProperties as $property)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ $property->images->first() ? asset($property->images->first()->image_url) : asset('images/placeholder.jpg') }}" class="card-img-top" alt="Property Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $property->title }}</h5>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt text-primary"></i> {{ $property->address }}
                            <br>
                            <i class="fas fa-bed text-primary"></i> {{ $property->bedrooms }} Bedrooms
                            <br>
                            <i class="fas fa-bath text-primary"></i> {{ $property->bathrooms }} Bathrooms
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-primary fw-bold">RM {{ number_format($property->monthly_rent, 2) }}/month</h6>
                            <a href="{{ route('student.property.details', $property->property_id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <!-- Fallback content if no properties are found -->
            <div class="col-md-4">
                <div class="card">
                    <img src="/images/placeholder.jpg" class="card-img-top" alt="Property Image">
                    <div class="card-body">
                        <h5 class="card-title">Student Apartment</h5>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt text-primary"></i> Parit Raja
                            <br>
                            <i class="fas fa-bed text-primary"></i> 3 Bedrooms
                            <br>
                            <i class="fas fa-bath text-primary"></i> 2 Bathrooms
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-primary fw-bold">RM 500/month</h6>
                            <a href="#" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add this after your featured properties section -->
<div class="container mt-5">
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
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection