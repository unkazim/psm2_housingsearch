@extends('ui.layout')

@section('title', $property->title)

@section('content')
<style>
    .property-header {
        background-color: #f8f9fa;
        padding: 30px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .property-image {
        border-radius: 8px;
        overflow: hidden;
        height: 400px;
    }
    
    .property-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .property-thumbnails {
        margin-top: 15px;
    }
    
    .property-thumbnail {
        width: 100px;
        height: 70px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        opacity: 0.7;
    }
    
    .property-thumbnail:hover, .property-thumbnail.active {
        opacity: 1;
        transform: scale(1.05);
    }
    
    .property-details {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 25px;
    }
    
    .property-features {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin: 20px 0;
    }
    
    .property-feature {
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        padding: 10px 15px;
        border-radius: 50px;
    }
    
    .property-feature i {
        margin-right: 8px;
        color: #4a148c;
    }
    
    .back-button {
        display: inline-flex;
        align-items: center;
        color: #4a148c;
        text-decoration: none;
        font-weight: 500;
    }
    
    .back-button:hover {
        text-decoration: underline;
    }
    
    .similar-properties {
        padding: 40px 0;
    }
    
    .similar-property-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .similar-property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="property-header">
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ url()->previous() }}" class="back-button">
                <i class="fas fa-arrow-left me-2"></i> Back to Search Results
            </a>
            <a href="{{ route('student.dashboard') }}" class="back-button">
                <i class="fas fa-home me-2"></i> Back to Home
            </a>
        </div>
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">{{ $property->title }}</h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-map-marker-alt"></i> {{ $property->address }}
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <h2 class="h3 text-primary mb-0">RM {{ number_format($property->monthly_rent, 2) }}/month</h2>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Property Images -->
            <div class="property-image mb-4">
                <img id="mainImage" src="{{ $property->images->first() ? asset($property->images->first()->image_url) : asset('images/placeholder.jpg') }}" 
                     alt="{{ $property->title }}">
            </div>
            
            @if($property->images->count() > 1)
                <div class="property-thumbnails d-flex gap-2 mb-4 overflow-auto">
                    @foreach($property->images as $image)
                        <img src="{{ asset($image->image_url) }}" 
                             class="property-thumbnail {{ $loop->first ? 'active' : '' }}"
                             alt="Property Image {{ $loop->iteration }}"
                             onclick="changeMainImage('{{ asset($image->image_url) }}', this)">
                    @endforeach
                </div>
            @endif
            
            <!-- Property Description -->
            <div class="property-details mb-4">
                <h3>Description</h3>
                <p>{{ $property->description }}</p>
                
                <div class="property-features">
                    <div class="property-feature">
                        <i class="fas fa-bed"></i> {{ $property->bedrooms }} Bedroom(s)
                    </div>
                    <div class="property-feature">
                        <i class="fas fa-bath"></i> {{ $property->bathrooms }} Bathroom(s)
                    </div>
                    <div class="property-feature">
                        <i class="fas fa-building"></i> {{ $property->property_type }}
                    </div>
                    <div class="property-feature">
                        <i class="fas fa-venus-mars"></i> 
                        @if($property->preferred_gender == 'any')
                            Any Gender
                        @elseif($property->preferred_gender == 'male')
                            Male Only
                        @elseif($property->preferred_gender == 'female')
                            Female Only
                        @endif
                    </div>
                    <div class="property-feature">
                        <i class="fas fa-map-marked-alt"></i> {{ $property->distance_from_uthm }} km from UTHM
                    </div>
                </div>
                
                <h3 class="mt-4">Location</h3>
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q={{ urlencode($property->address) }}" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            
            <!-- Reviews Section -->
         <div class="property-details mb-4">
                    <h3>Reviews</h3>
                    
                    @if(Auth::check() && Auth::user()->hasRole('student'))
                        @if(!$hasReviewed)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                <i class="fas fa-star me-2"></i> Write a Review
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                <i class="fas fa-edit me-2"></i> Edit Your Review
                            </button>
                        @endif
                    @endif
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if($property->reviews->count() > 0)
                    @foreach($property->reviews as $review)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">{{ $review->student->user->name }}</h5>
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $review->review_date->format('M d, Y') }}</h6>
                                <p class="card-text">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No reviews yet for this property.</p>
                @endif
            </div>
            
            <!-- Review Modal -->
            @if(Auth::check() && Auth::user()->hasRole('student'))
            <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('student.submit.review', $property->property_id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Rating</label>
                                    <div class="rating-stars mb-3">
                                        <div class="d-flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <div class="star-rating me-2">
                                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                                                    <label for="star{{ $i }}" class="star-label">
                                                        <i class="far fa-star"></i>
                                                    </label>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Your Review</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                                        <div class="form-text">Share your experience with this property.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <!-- Contact Landlord -->
            <div class="property-details mb-4">
                <h3>Contact Landlord</h3>
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                         style="width: 50px; height: 50px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $property->landlord->user->name }}</h5>
                        <p class="text-muted mb-0">Property Owner</p>
                    </div>
                </div>
                
                <div class="mb-3">
                    <a href="tel:{{ $property->landlord->user->phone }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-phone me-2"></i> {{ $property->landlord->user->phone }}
                    </a>
                    <a href="mailto:{{ $property->landlord->user->email }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-envelope me-2"></i> Email Landlord
                    </a>
                </div>
                
                <a href="#" class="btn btn-primary w-100">Apply for Rental</a>
            </div>
            
            <!-- Property Status -->
            <div class="property-details mb-4">
                <h3>Property Status</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Status
                        <span class="badge bg-success rounded-pill">{{ ucfirst($property->status) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Listed Date
                        <span>{{ $property->listed_date->format('M d, Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Property ID
                        <span>{{ $property->property_id }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Similar Properties -->
@if($similarProperties->count() > 0)
<div class="similar-properties bg-light">
    <div class="container">
        <h2 class="mb-4">Similar Properties</h2>
        <div class="row">
            @foreach($similarProperties as $similar)
                <div class="col-md-4 mb-4">
                    <div class="card similar-property-card">
                        <img src="{{ $similar->images->first() ? asset($similar->images->first()->image_url) : asset('images/placeholder.jpg') }}" 
                             class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $similar->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $similar->title }}</h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt text-primary"></i> {{ $similar->address }}
                                <br>
                                <i class="fas fa-bed text-primary"></i> {{ $similar->bedrooms }} Bedroom(s)
                                <br>
                                <i class="fas fa-bath text-primary"></i> {{ $similar->bathrooms }} Bathroom(s)
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 text-primary fw-bold">RM {{ number_format($similar->monthly_rent, 2) }}/month</h6>
                                <a href="{{ route('student.property.details', ['id' => $similar->property_id]) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
    function changeMainImage(src, thumbnail) {
        document.getElementById('mainImage').src = src;
        
        // Remove active class from all thumbnails
        document.querySelectorAll('.property-thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        
        // Add active class to clicked thumbnail
        thumbnail.classList.add('active');
    }
</script>
@endpush
@endsection