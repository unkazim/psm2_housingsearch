@extends('ui.layout')

@section('title', 'Rental Applications')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Rental Applications</h1>
        <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-primary">
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

    @if($applications->isEmpty())
        <div class="alert alert-info shadow-sm">
            <p class="mb-0"><i class="fas fa-info-circle me-2"></i>You don't have any rental applications yet.</p>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header bg-gradient text-white" style="background-color: #4e73df;">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>All Applications</h5>
            </div>
            <div class="card-body bg-light">
                <ul class="nav nav-pills mb-4" id="applicationTabs" role="tablist">
                    <li class="nav-item me-2" role="presentation">
                        <button class="nav-link active px-4" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All</button>
                    </li>
                    <li class="nav-item me-2" role="presentation">
                        <button class="nav-link px-4" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">Pending</button>
                    </li>
                    <li class="nav-item me-2" role="presentation">
                        <button class="nav-link px-4" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">Approved</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab">Rejected</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="applicationTabsContent">
                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        @include('landlord.partials.application-list', ['applications' => $applications])
                    </div>
                    <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        @include('landlord.partials.application-list', ['applications' => $applications->where('status', 'pending')])
                    </div>
                    <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                        @include('landlord.partials.application-list', ['applications' => $applications->where('status', 'approved')])
                    </div>
                    <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                        @include('landlord.partials.application-list', ['applications' => $applications->where('status', 'rejected')])
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection