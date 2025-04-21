@extends('ui.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Admin Dashboard</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome, {{ Auth::user()->name }}!</h5>
                    <p class="card-text">This is your admin dashboard. You can manage users, approve landlords, and monitor system activities here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection