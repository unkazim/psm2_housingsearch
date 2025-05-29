@extends('ui.layout')

@section('title', 'Landlord Dashboard')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-primary mb-4">Landlord Dashboard</h1>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->profile_image)
                            <img src="{{ asset('profile_images/'.Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                        @else
                            <i class="fas fa-user-circle me-2"></i>
                        @endif
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('landlord.profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="alert alert-info shadow-sm border-0" style="background: linear-gradient(45deg, #e3f2fd, #bbdefb);">
                <h5 class="alert-heading text-primary"><i class="fas fa-user-circle me-2"></i>Welcome!</h5>
                <p class="mb-0">This is your landlord dashboard. You can manage your properties and rental applications here.</p>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(45deg, #4e73df, #224abe);">
                <div class="card-body text-white">
                    <h5 class="card-title"><i class="fas fa-home me-2"></i>Properties</h5>
                    <p class="card-text display-4">{{ $properties->count() }}</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a class="text-white text-decoration-none stretched-link" href="{{ route('landlord.properties') }}">
                        View Details <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Pending Applications</h5>
                    <p class="card-text display-4">{{ $pendingApplicationsCount }}</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="{{ route('landlord.applications') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Add New Property</h5>
                    <p class="card-text">List a new property for rent</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="{{ route('landlord.properties.create') }}">Add Property</a>
                    <div class="small text-white"><i class="fas fa-plus"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-home me-1"></i> Your Properties</span>
                    <a href="{{ route('landlord.properties') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($properties->isEmpty())
                        <div class="alert alert-info">
                            You haven't listed any properties yet. <a href="{{ route('landlord.properties.create') }}">Add your first property</a>.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Address</th>
                                        <th>Rent (RM)</th>
                                        <th>Status</th>
                                        <th>Pending Applications</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($properties->take(5) as $property)
                                    <tr>
                                        <td>{{ $property->title }}</td>
                                        <td>{{ $property->address }}</td>
                                        <td>{{ number_format($property->monthly_rent, 2) }}</td>
                                        <td>
                                            @if($property->status == 'available')
                                                <span class="badge bg-success">Available</span>
                                            @elseif($property->status == 'rented')
                                                <span class="badge bg-primary">Rented</span>
                                            @else
                                                <span class="badge bg-secondary">Unavailable</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($property->rental_applications_count > 0)
                                                <span class="badge bg-warning">{{ $property->rental_applications_count }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('landlord.properties.edit', $property->property_id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-file-alt me-1"></i> Recent Applications</span>
                    <a href="{{ route('landlord.applications') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @if(!isset($recentApplications) || $recentApplications->isEmpty())
                        <div class="alert alert-info">
                            No recent rental applications.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Property</th>
                                        <th>Student</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentApplications as $application)
                                    <tr>
                                        <td>{{ $application->property->title }}</td>
                                        <td>{{ $application->student->user->name }}</td>
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
                                            <a href="{{ route('landlord.applications') }}#application-{{ $application->application_id }}" class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection