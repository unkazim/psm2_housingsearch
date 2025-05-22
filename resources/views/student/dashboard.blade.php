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
        position: relative;
        z-index: 1;
    }

    .search-box {
        background: rgba(255, 255, 255, 0.1);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        position: relative;
        overflow: hidden;
    }

    .search-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
        pointer-events: none;
    }

    .form-control-lg {
        background: rgba(255, 255, 255, 0.08);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 18px 25px;
        font-size: 1.1rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        color: white;
        letter-spacing: 0.5px;
    }

    .form-control-lg::placeholder {
        color: rgba(255, 255, 255, 0.7);
        font-weight: 300;
    }

    .form-control-lg:focus {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.25);
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .btn-search {
        background: rgba(26, 35, 126, 0.9);
        border: none;
        border-radius: 15px;
        padding: 18px 35px;
        font-weight: 600;
        letter-spacing: 0.8px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
    }
    
    .btn-search i {
        color: rgba(255, 255, 255, 0.7);
        transition: color 0.3s ease;
    }
    
    .btn-search:hover i {
        color: rgba(255, 255, 255, 1);
    }
    
    .btn-search:hover {
        background: rgba(48, 63, 159, 0.95);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(26, 35, 126, 0.3);
    }

    .btn-search::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: rotate(45deg);
        transition: 0.6s;
        opacity: 0;
    }

    .btn-search:hover::after {
        opacity: 1;
        transform: rotate(45deg) translate(50%, 50%);
    }

    .location-tags {
        margin-top: 30px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .location-tag {
        background: rgba(26, 35, 126, 0.6);
        color: white;
        padding: 12px 28px;
        border-radius: 30px;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        backdrop-filter: blur(8px);
        position: relative;
        overflow: hidden;
        min-width: 120px;
    }

    .location-tag:hover {
        background: rgba(48, 63, 159, 0.8);
        border-color: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 20px rgba(26, 35, 126, 0.25);
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
            <form action="{{ route('student.search') }}" method="GET" onsubmit="return validateSearch()">
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg" name="location" id="searchInput" placeholder="Search by location, area, or property name...">
                    <button class="btn btn-search btn-lg" type="submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
            <div class="location-tags">
                <p class="text-dark mb-2">Popular locations:</p>
                <a href="{{ route('student.search', ['location' => 'Parit Raja']) }}" class="location-tag">Parit Raja</a>
                <a href="{{ route('student.search', ['location' => 'Parit Yani']) }}" class="location-tag">Parit Yani</a>
                <a href="{{ route('student.search', ['location' => 'Taman Maju']) }}" class="location-tag">Taman Maju</a>
                <a href="{{ route('student.search', ['location' => 'Taman Maju Baru']) }}" class="location-tag">Taman Maju Baru</a>
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

<!-- Featured Properties Section -->
<section class="property-section">
    <div class="container">
        <h2 class="mb-4">Featured Properties</h2>
        <div class="row">
            @forelse($featuredProperties as $property)
                <div class="col-md-4">
                    <div class="card">
                        @if($property->images->isNotEmpty())
                            <img src="{{ asset($property->images->first()->image_url) }}" 
                                 class="card-img-top" alt="{{ $property->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $property->title }}</h5>
                            <p class="card-text">{{ Str::limit($property->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">RM {{ number_format($property->monthly_rent, 2) }}/month</span>
                                <a href="{{ route('student.property.details', $property->property_id) }}" 
                                   class="btn btn-outline-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No featured properties available at the moment.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
function validateSearch() {
    var searchInput = document.getElementById('searchInput').value.trim();
    if (searchInput === '') {
        alert('Please enter a location, area, or property name to search');
        return false;
    }
    return true;
}
</script>
@endpush
@endsection