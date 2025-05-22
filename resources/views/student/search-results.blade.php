@extends('ui.layout')

@section('title', 'Search Results')

@section('content')
<style>
    .search-header {
        background-color: #f8f9fa;
        padding: 20px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .filter-sidebar {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }
    
    .property-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }
    
    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    .property-img {
        height: 200px;
        object-fit: cover;
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
    
    /* Pagination Styles */
    .pagination {
        margin-bottom: 0;
    }
    
    .page-item.active .page-link {
        background-color: #4a148c;
        border-color: #4a148c;
    }
    
    .page-link {
        color: #4a148c;
    }
    
    .page-link:hover {
        color: #6a1b9a;
    }
    
    .page-item.disabled .page-link {
        color: #6c757d;
    }
</style>

<div class="search-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0">Search results for "{{ $searchTerm }}"</h1>
                <p class="text-muted">{{ $count }} properties found</p>
            </div>
            <a href="{{ route('student.dashboard') }}" class="back-button">
                <i class="fas fa-home me-2"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="filter-sidebar">
                <h5 class="mb-3">Filter Results</h5>
                <form action="{{ route('student.search') }}" method="GET">
                    @if($searchTerm)
                        <input type="hidden" name="location" value="{{ $searchTerm }}">
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label">Price Range</label>
                        <div class="row g-2">
                            <div class="col">
                                <input type="number" class="form-control" name="min_price" placeholder="Min price" value="{{ request('min_price') }}">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="max_price" placeholder="Max price" value="{{ request('max_price') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Bedrooms</label>
                        <select class="form-select" name="bedrooms">
                            <option value="Any" {{ request('bedrooms') == 'Any' ? 'selected' : '' }}>Any</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                            <option value="6" {{ request('bedrooms') == '6' ? 'selected' : '' }}>6+</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Property Type</label>
                        <select class="form-select" name="property_type">
                            <option value="Any Type" {{ request('property_type') == 'Any Type' ? 'selected' : '' }}>Any Type</option>
                            <option value="Apartment" {{ request('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="House" {{ request('property_type') == 'House' ? 'selected' : '' }}>House</option>
                            <option value="Room" {{ request('property_type') == 'Room' ? 'selected' : '' }}>Room</option>
                            <option value="Studio" {{ request('property_type') == 'Studio' ? 'selected' : '' }}>Studio</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Gender Preference</label>
                        <select class="form-select" name="gender">
                            <option value="Any" {{ request('gender') == 'Any' ? 'selected' : '' }}>Any</option>
                            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Property Listings -->
        <div class="col-lg-9">
            <div class="row">
                @forelse($properties as $property)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card property-card h-100">
                            <img src="{{ $property->images->first() ? asset($property->images->first()->image_url) : asset('images/placeholder.jpg') }}" 
                                 class="card-img-top property-img" alt="{{ $property->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $property->title }}</h5>
                                <p class="card-text">
                                    <i class="fas fa-map-marker-alt text-primary"></i> {{ $property->address }}
                                    <br>
                                    <i class="fas fa-bed text-primary"></i> {{ $property->bedrooms }} Bedroom(s)
                                    <br>
                                    <i class="fas fa-bath text-primary"></i> {{ $property->bathrooms }} Bathroom(s)
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-primary fw-bold">RM {{ number_format($property->monthly_rent, 2) }}/month</h6>
                                    <a href="{{ route('student.property.details', ['id' => $property->property_id]) }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No properties found matching your criteria. Try adjusting your filters.
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                @if ($properties->hasPages())
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($properties->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo; Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $properties->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($properties->getUrlRange(1, $properties->lastPage()) as $page => $url)
                                @if ($page == $properties->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($properties->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $properties->nextPageUrl() }}" rel="next">Next &raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next &raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
                <div class="text-muted mt-2">
                    Showing {{ $properties->firstItem() ?? 0 }} to {{ $properties->lastItem() ?? 0 }} of {{ $properties->total() }} results
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection