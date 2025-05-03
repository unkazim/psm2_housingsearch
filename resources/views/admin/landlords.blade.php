@extends('ui.layout')

@section('title', 'Manage Landlords')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Manage Landlords</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($landlords->isEmpty())
        <div class="alert alert-info shadow-sm">
            <p class="mb-0"><i class="fas fa-info-circle me-2"></i>There are no landlords in the system.</p>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>All Landlords ({{ $landlords->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="landlordsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Bank Account</th>
                                <th>Status</th>
                                <th>Registration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($landlords as $landlord)
                                <tr>
                                    <td>{{ $landlord->user->name }}</td>
                                    <td>{{ $landlord->user->email }}</td>
                                    <td>{{ $landlord->user->phone }}</td>
                                    <td>{{ $landlord->bank_account }}</td>
                                    <td>
                                        @if($landlord->approval_status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($landlord->approval_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $landlord->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $landlord->landlord_id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $landlord->landlord_id }}">
                                                @if($landlord->approval_status != 'approved')
                                                    <li>
                                                        <form action="{{ route('admin.landlords.approve', $landlord->landlord_id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-check text-success"></i> Approve
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if($landlord->approval_status != 'rejected')
                                                    <li>
                                                        <form action="{{ route('admin.landlords.reject', $landlord->landlord_id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-times text-warning"></i> Reject
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.landlords.delete', $landlord->landlord_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this landlord account? This action cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-trash text-danger"></i> Delete Account
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
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