@extends('ui.layout')

@section('title', 'Student Dashboard')

@section('content')
<style>
    .hero-section {
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/images/uthm-bg.jpg');
        background-size: cover;
        background-position: center;
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }

    .search-box {
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        width: 80%;
        max-width: 600px;
    }

    .location-tags {
        margin-top: 20px;
    }

    .location-tag {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        margin: 0 5px;
        text-decoration: none;
        border: 1px solid white;
    }

    .location-tag:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }
</style>

<div class="hero-section">
    <div class="container">
        <h1 class="display-4 mb-4">Find Your Perfect Student Housing</h1>
        
        <div class="search-box">
            <div class="input-group">
                <input type="text" class="form-control form-control-lg" 
                       placeholder="Search by location (e.g., Parit Raja, Batu Pahat)">
                <button class="btn btn-primary btn-lg">Search</button>
            </div>
        </div>

        <div class="location-tags">
            <a href="#" class="location-tag">Parit Raja</a>
            <a href="#" class="location-tag">Batu Pahat</a>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="/images/placeholder.jpg" class="card-img-top" alt="Property Image">
                <div class="card-body">
                    <h5 class="card-title">Student Apartment</h5>
                    <p class="card-text">
                        <i class="fas fa-map-marker-alt"></i> Parit Raja
                        <br>
                        <i class="fas fa-bed"></i> 3 Bedrooms
                        <br>
                        <i class="fas fa-bath"></i> 2 Bathrooms
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">RM 500/month</h6>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Repeat similar cards for more properties -->
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection