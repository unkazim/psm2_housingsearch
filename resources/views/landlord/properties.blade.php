@extends('ui.layout')

@section('title', 'Manage Properties')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Manage Properties</h1>
        <div>
            <a href="{{ route('landlord.properties.create') }}" class="btn btn-primary me-2 shadow-sm">
                <i class="fas fa-plus"></i> Add New Property
            </a>
            <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-primary shadow-sm">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($properties->isEmpty())
        <div class="alert alert-info shadow-sm border-0" style="background: linear-gradient(45deg, #e3f2fd, #bbdefb);">
            <p class="mb-0"><i class="fas fa-info-circle me-2"></i>You haven't listed any properties yet. Click the "Add New Property" button to get started.</p>
        </div>
    @else
        <div class="row">
            @foreach($properties as $property)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <div class="position-relative">
                            @if($property->images->isNotEmpty())
                                <img src="{{ asset($property->images->first()->image_url) }}" class="card-img-top" alt="{{ $property->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light text-center py-5">
                                    <i class="fas fa-home fa-3x text-muted"></i>
                                    <p class="mt-2 text-muted">No images</p>
                                </div>
                            @endif
                            <div class="position-absolute top-0 end-0 p-2">
                                @if($property->status == 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif($property->status == 'rented')
                                    <span class="badge bg-primary">Rented</span>
                                @else
                                    <span class="badge bg-secondary">Unavailable</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $property->title }}</h5>
                            <p class="card-text text-muted">{{ $property->address }}</p>
                            <div class="d-flex justify-content-between mb-3">
                                <span><strong>RM {{ number_format($property->monthly_rent, 2) }}</strong>/month</span>
                                <span>{{ $property->bedrooms }} bed, {{ $property->bathrooms }} bath</span>
                            </div>
                            
                            @if($property->rental_applications_count > 0)
                                <div class="alert alert-warning py-1 px-2 mb-3">
                                    <small><i class="fas fa-bell me-1"></i> {{ $property->rental_applications_count }} pending application(s)</small>
                                </div>
                            @endif
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('landlord.properties.edit', $property->property_id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('landlord.properties.delete', $property->property_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection