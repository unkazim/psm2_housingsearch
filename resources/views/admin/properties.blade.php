@extends('ui.layout')

@section('title', 'Manage Properties')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Manage Properties</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($properties->isEmpty())
        <div class="alert alert-info shadow-sm">
            <p class="mb-0"><i class="fas fa-info-circle me-2"></i>There are no properties in the system.</p>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-home me-2"></i>All Properties ({{ $properties->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="propertiesTable">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Address</th>
                                <th>Landlord</th>
                                <th>Monthly Rent</th>
                                <th>Status</th>
                                <th>Listed Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $property)
                                <tr>
                                    <td>{{ $property->title }}</td>
                                    <td>{{ $property->address }}</td>
                                    <td>{{ $property->landlord->user->name }}</td>
                                    <td>RM {{ number_format($property->monthly_rent, 2) }}</td>
                                    <td>
                                        @if($property->status == 'available')
                                            <span class="badge bg-success">Available</span>
                                        @elseif($property->status == 'rented')
                                            <span class="badge bg-warning">Rented</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($property->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $property->listed_date->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.property.details', $property->property_id) }}" class="btn btn-sm btn-primary me-2">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <form action="{{ route('admin.property.delete', $property->property_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection