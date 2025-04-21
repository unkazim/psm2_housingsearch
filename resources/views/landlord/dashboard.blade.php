@extends('ui.layout')

@section('title', 'Landlord Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Landlord Dashboard</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome, {{ Auth::user()->name }}!</h5>
                    <p class="card-text">This is your landlord dashboard. You can manage your properties and rental listings here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection