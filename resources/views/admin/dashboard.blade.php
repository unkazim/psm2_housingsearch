@extends('ui.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-primary mb-4">Admin Dashboard</h1>
            </div>
            <div class="alert alert-info shadow-sm border-0" style="background: linear-gradient(45deg, #e3f2fd, #bbdefb);">
                <h5 class="alert-heading text-primary"><i class="fas fa-user-circle me-2"></i>Welcome, {{ Auth::user()->name }}!</h5>
                <p class="mb-0">This is your admin dashboard. You can manage users, approve landlords, and monitor system activities here.</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(45deg, #4e73df, #224abe);">
                <div class="card-body text-white">
                    <h5 class="card-title"><i class="fas fa-user-graduate me-2"></i>Students</h5>
                    <p class="card-text display-4">{{ $studentCount }}</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a class="text-white text-decoration-none stretched-link" href="{{ route('admin.students') }}">
                        View Details <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(45deg, #1cc88a, #169a6f);">
                <div class="card-body text-white">
                    <h5 class="card-title"><i class="fas fa-user-tie me-2"></i>Landlords</h5>
                    <p class="card-text display-4">{{ $landlordCount }}</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a class="text-white text-decoration-none stretched-link" href="{{ route('admin.landlords') }}">
                        View Details <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(45deg, #f6c23e, #dda20a);">
                <div class="card-body text-white">
                    <h5 class="card-title"><i class="fas fa-clock me-2"></i>Pending Approvals</h5>
                    <p class="card-text display-4">{{ $pendingLandlordCount }}</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a class="text-white text-decoration-none stretched-link" href="{{ route('admin.pending-landlords') }}">
                        View Details <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(45deg, #36b9cc, #258391);">
                <div class="card-body text-white">
                    <h5 class="card-title"><i class="fas fa-home me-2"></i>Properties</h5>
                    <p class="card-text display-4">{{ $propertyCount }}</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a class="text-white text-decoration-none stretched-link" href="{{ route('admin.properties') }}">
                        View Details <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('admin.pending-landlords') }}" class="btn btn-warning btn-lg w-100 mb-3">
                                <i class="fas fa-user-check me-2"></i>Approve Landlords
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.students') }}" class="btn btn-info btn-lg w-100 mb-3">
                                <i class="fas fa-users me-2"></i>Manage Students
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.landlords') }}" class="btn btn-success btn-lg w-100 mb-3">
                                <i class="fas fa-user-tie me-2"></i>Manage Landlords
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection