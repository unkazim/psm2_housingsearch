@extends('ui.layout')

@section('title', 'Property Details')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Property Details</h1>
        <div>
            <a href="{{ route('admin.properties') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-list"></i> All Properties
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Property Details Card -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-home me-2"></i>{{ $property->title }}</h5>
                </div>
                <div class="card-body">
                    <!-- Property Images Carousel -->
                    @if($property->images->count() > 0)
                        <div id="propertyCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach($property->images as $key => $image)
                                    <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner rounded">
                                @foreach($property->images as $key => $image)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset($image->image_url) }}" class="d-block w-100" alt="Property Image" style="height: 400px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    @else
                        <div class="alert alert-info mb-4">
                            <p class="mb-0"><i class="fas fa-info-circle me-2"></i>No images available for this property.</p>
                        </div>
                    @endif

                    <!-- Property Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Property Information</h5>
                            <p><strong>Address:</strong> {{ $property->address }}</p>
                            <p><strong>Monthly Rent:</strong> RM {{ number_format($property->monthly_rent, 2) }}</p>
                            <p><strong>Distance from UTHM:</strong> {{ $property->distance_from_uthm }} km</p>
                            <p><strong>Status:</strong> 
                                @if($property->status == 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif($property->status == 'rented')
                                    <span class="badge bg-warning">Rented</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($property->status) }}</span>
                                @endif
                            </p>
                            <p><strong>Listed Date:</strong> {{ $property->listed_date->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Property Features</h5>
                            <p><strong>Property Type:</strong> {{ ucfirst($property->property_type) }}</p>
                            <p><strong>Bedrooms:</strong> {{ $property->bedrooms }}</p>
                            <p><strong>Bathrooms:</strong> {{ $property->bathrooms }}</p>
                            <p><strong>Preferred Gender:</strong> {{ ucfirst($property->preferred_gender) }}</p>
                        </div>
                    </div>

                    <h5 class="border-bottom pb-2 mb-3">Description</h5>
                    <p>{{ $property->description }}</p>

                    <div class="d-flex justify-content-end mt-4">
                        <form action="{{ route('admin.property.delete', $property->property_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Property
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Landlord Info and Reviews -->
        <div class="col-md-4">
            <!-- Landlord Info Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Landlord Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $property->landlord->user->name }}</p>
                    <p><strong>Email:</strong> {{ $property->landlord->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $property->landlord->user->phone }}</p>
                    <p><strong>Status:</strong> 
                        @if($property->landlord->approval_status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($property->landlord->approval_status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Reviews Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-star me-2"></i>Reviews ({{ $property->reviews->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($property->reviews->isEmpty())
                        <div class="alert alert-info">
                            <p class="mb-0"><i class="fas fa-info-circle me-2"></i>No reviews for this property yet.</p>
                        </div>
                    @else
                        @foreach($property->reviews as $review)
                            <div class="border-bottom mb-3 pb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ $review->student->user->name }}</h6>
                                    <div>
                                        <span class="badge bg-primary">{{ $review->rating }}/5</span>
                                        <small class="text-muted ms-2">{{ $review->review_date->format('d M Y') }}</small>
                                    </div>
                                </div>
                                <p class="mb-2">{{ $review->comment }}</p>
                                <div class="d-flex justify-content-end">
                                    <form action="{{ route('admin.review.delete', $review->review_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete Review
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection