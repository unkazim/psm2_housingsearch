@extends('ui.layout')

@section('title', 'Pending Landlord Approvals')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Pending Landlord Approvals</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
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

    @if($pendingLandlords->isEmpty())
        <div class="alert alert-info shadow-sm">
            <p class="mb-0"><i class="fas fa-info-circle me-2"></i>There are no pending landlord approvals at this time.</p>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-user-clock me-2"></i>Pending Approvals ({{ $pendingLandlords->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Bank Account</th>
                                <th>Registration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingLandlords as $landlord)
                                <tr>
                                    <td>{{ $landlord->user->name }}</td>
                                    <td>{{ $landlord->user->email }}</td>
                                    <td>{{ $landlord->user->phone }}</td>
                                    <td>{{ $landlord->bank_account }}</td>
                                    <td>{{ $landlord->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <form action="{{ route('admin.landlords.approve', $landlord->landlord_id) }}" method="POST" class="me-2">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.landlords.reject', $landlord->landlord_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i> Reject
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