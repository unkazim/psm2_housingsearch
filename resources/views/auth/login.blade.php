@extends('ui.layout')

@section('title', 'Login')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <h2 class="text-primary fw-bold">Welcome Back!</h2>
                    <p class="text-muted">Please login to access your account</p>
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
                                @if ($errors->has('email'))
                                    <div>{{ $errors->first('email') }}</div>
                                @endif
                                @if ($errors->has('password'))
                                    <div>{{ $errors->first('password') }}</div>
                                @endif
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('username') is-invalid @enderror" 
                                           id="username" 
                                           name="username" 
                                           value="{{ old('username') }}" 
                                           placeholder="Enter username or email"
                                           required 
                                           autofocus>
                                    <label for="username">
                                        <i class="fas fa-user text-muted me-2"></i>Username or Email
                                    </label>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter password"
                                           required>
                                    <label for="password">
                                        <i class="fas fa-lock text-muted me-2"></i>Password
                                    </label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label text-muted" for="remember">Remember Me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">
                                    Forgot Password?
                                </a>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 10px;">
                                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="text-muted mb-0">Don't have an account?
                                    <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">
                                        Create Account
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
    .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
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