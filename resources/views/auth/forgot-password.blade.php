@extends('ui.layout')

@section('title', 'Forgot Password')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <h2 class="text-primary fw-bold">Forgot Password</h2>
                    <p class="text-muted">Enter your email address to receive a password reset link</p>
                </div>
                
                <div class="card shadow-lg border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="Enter your email address"
                                           required 
                                           autofocus>
                                    <label for="email">
                                        <i class="fas fa-envelope text-muted me-2"></i>Email Address
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 10px;">
                                    <i class="fas fa-paper-plane me-2"></i>Send Password Reset Link
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="text-muted mb-0">
                                    <a href="{{ route('login') }}" class="text-primary text-decoration-none">
                                        <i class="fas fa-arrow-left me-1"></i> Back to Login
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-floating > label {
        padding-left: 1rem;
    }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
        transform: translateY(-1px);
    }
    .alert {
        border: none;
        border-radius: 10px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection