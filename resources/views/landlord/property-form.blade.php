@extends('ui.layout')

@section('title', isset($property) ? 'Edit Property' : 'Add New Property')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header text-white" style="background: linear-gradient(45deg, #4e73df, #224abe);">
                    <h4 class="mb-0">
                        <i class="fas {{ isset($property) ? 'fa-edit' : 'fa-plus-circle' }} me-2"></i>
                        {{ isset($property) ? 'Edit Property' : 'Add New Property' }}
                    </h4>
                </div>
                <div class="card-body bg-light">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" 
                          action="{{ isset($property) ? route('landlord.properties.update', $property->property_id) : route('landlord.properties.store') }}" 
                          enctype="multipart/form-data">
                        @csrf
                        @if(isset($property))
                            @method('PUT')
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Property Title</label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       value="{{ old('title', $property->title ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="property_type" class="form-label">Property Type</label>
                                <select class="form-select" id="property_type" name="property_type" required>
                                    <option value="">Select Type</option>
                                    <option value="whole house" {{ (old('property_type', $property->property_type ?? '') == 'whole house') ? 'selected' : '' }}>Whole House</option>
                                    <option value="room" {{ (old('property_type', $property->property_type ?? '') == 'room') ? 'selected' : '' }}>Room</option>
                                    <option value="apartment" {{ (old('property_type', $property->property_type ?? '') == 'apartment') ? 'selected' : '' }}>Apartment</option>
                                    <option value="condominium" {{ (old('property_type', $property->property_type ?? '') == 'condominium') ? 'selected' : '' }}>Condominium</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" 
                                   value="{{ old('address', $property->address ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="map_link" class="form-label">Map Link (Google Maps or OpenStreetMap)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" class="form-control" id="map_link" name="map_link" 
                                       value="{{ old('map_link', $property->map_link ?? '') }}" 
                                       placeholder="Paste Google Maps or OpenStreetMap embed link here">
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> How to get a map link:
                                <ol class="mt-1 ps-3">
                                    <li>Go to Google Maps and search for your property location</li>
                                    <li>Click "Share" and then "Embed a map"</li>
                                    <li>Copy the HTML code and paste only the URL from the src attribute (starts with https://www.google.com/maps/embed)</li>
                                </ol>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $property->description ?? '') }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="monthly_rent" class="form-label">Monthly Rent (RM)</label>
                                <input type="number" class="form-control" id="monthly_rent" name="monthly_rent" 
                                       value="{{ old('monthly_rent', $property->monthly_rent ?? '') }}" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-4">
                                <label for="distance_from_uthm" class="form-label">Distance from UTHM (km)</label>
                                <input type="number" class="form-control" id="distance_from_uthm" name="distance_from_uthm" 
                                       value="{{ old('distance_from_uthm', $property->distance_from_uthm ?? '') }}" min="0" step="0.1" required>
                            </div>
                            <div class="col-md-4">
                                <label for="preferred_gender" class="form-label">Preferred Gender</label>
                                <select class="form-select" id="preferred_gender" name="preferred_gender" required>
                                    <option value="any" {{ (old('preferred_gender', $property->preferred_gender ?? '') == 'any') ? 'selected' : '' }}>Any</option>
                                    <option value="male" {{ (old('preferred_gender', $property->preferred_gender ?? '') == 'male') ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ (old('preferred_gender', $property->preferred_gender ?? '') == 'female') ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="bedrooms" class="form-label">Bedrooms</label>
                                <input type="number" class="form-control" id="bedrooms" name="bedrooms" 
                                       value="{{ old('bedrooms', $property->bedrooms ?? '') }}" min="0" required>
                            </div>
                            <div class="col-md-4">
                                <label for="bathrooms" class="form-label">Bathrooms</label>
                                <input type="number" class="form-control" id="bathrooms" name="bathrooms" 
                                       value="{{ old('bathrooms', $property->bathrooms ?? '') }}" min="0" required>
                            </div>
                            @if(isset($property))
                            <div class="col-md-4">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="available" {{ (old('status', $property->status ?? '') == 'available') ? 'selected' : '' }}>Available</option>
                                    <option value="rented" {{ (old('status', $property->status ?? '') == 'rented') ? 'selected' : '' }}>Rented</option>
                                    <option value="unavailable" {{ (old('status', $property->status ?? '') == 'unavailable') ? 'selected' : '' }}>Unavailable</option>
                                </select>
                            </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="images" class="form-label">Property Images</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                            <div class="form-text">You can select multiple images. Maximum 5MB per image.</div>
                        </div>

                        @if(isset($property) && $property->images->isNotEmpty())
                            <div class="mb-4">
                                <label class="form-label">Current Images</label>
                                <div class="row">
                                    @foreach($property->images as $image)
                                        <div class="col-md-3 mb-3">
                                            <div class="card">
                                                <img src="{{ asset($image->image_url) }}" class="card-img-top" alt="Property Image" style="height: 150px; object-fit: cover;">
                                                <div class="card-body p-2 text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image->image_id }}" id="delete_image_{{ $image->image_id }}">
                                                        <label class="form-check-label" for="delete_image_{{ $image->image_id }}">
                                                            Delete
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-text text-danger">Check the images you want to delete.</div>
                            </div>
                        @endif

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <a href="{{ route('landlord.properties') }}" class="btn btn-outline-primary me-md-2">
                                <i class="fas fa-arrow-left"></i> Back to Properties
                            </a>
                            <button type="submit" class="btn btn-primary shadow-sm">
                                <i class="fas {{ isset($property) ? 'fa-save' : 'fa-plus' }}"></i>
                                {{ isset($property) ? 'Update Property' : 'Create Property' }}
                            </button>
                        </div>
                        </form>
                        </div>
                        </div>
                        </div>
                        </div>
                        @endsection