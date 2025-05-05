<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - UTHM Student Housing</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            /* UTHM Colors */
            --primary-color: #00205b;     /* UTHM Dark Blue */
            --primary-light: #2a4d8f;     /* Lighter shade of UTHM Blue */
            --primary-dark: #001233;      /* Darker shade of UTHM Blue */
            --secondary-color: #c8102e;   /* UTHM Red */
            --secondary-light: #e63e54;   /* Lighter shade of UTHM Red */
            --secondary-dark: #9a0c23;    /* Darker shade of UTHM Red */
            --accent-color: #f2c75c;      /* UTHM Gold/Yellow accent */
            --accent-light: #f7d783;      /* Lighter gold */
            --accent-dark: #d9ae3f;       /* Darker gold */
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background-color: #f8f9fa;
        }
        
        /* Navbar Styling */
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 12px 0;
        }
        
        .navbar-dark {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }
        
        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 8px 15px !important;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after, .nav-link.active:after {
            width: 80%;
        }
        
        /* Card Styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }
        
        .card-header {
            border-radius: 10px 10px 0 0;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .card-header.bg-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark)) !important;
        }
        
        .card-header.bg-secondary {
            background: linear-gradient(45deg, var(--secondary-color), var(--secondary-dark)) !important;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Button Styling */
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 32, 91, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(45deg, var(--secondary-color), var(--secondary-dark));
            border: none;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(45deg, var(--secondary-dark), var(--secondary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(200, 16, 46, 0.3);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 32, 91, 0.2);
        }
        
        /* Form Controls */
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e0e0e0;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 32, 91, 0.25);
        }
        
        /* Property Cards */
        .property-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        /* Footer */
        footer {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-color));
            padding: 20px 0;
            margin-top: 60px;
        }
        
        /* Property Details Styles */
        .property-details {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 20px;
        }
    
        .property-feature {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 50px;
            margin: 5px;
        }
    
        .property-feature i {
            margin-right: 8px;
            color: var(--secondary-color);
        }
        
        /* Dashboard Stats */
        .stat-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .stat-card.primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-light));
        }
        
        .stat-card.secondary {
            background: linear-gradient(45deg, var(--secondary-color), var(--secondary-light));
        }
        
        .stat-card.accent {
            background: linear-gradient(45deg, var(--accent-dark), var(--accent-color));
            color: var(--primary-dark);
        }
        
        .stat-card .icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .stat-card .count {
            font-size: 2rem;
            font-weight: 700;
        }
        
        .stat-card .title {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid var(--secondary-color);
        }
        
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid var(--accent-dark);
        }
        
        /* Pagination */
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .pagination .page-link {
            color: var(--primary-color);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }
        
        /* Badge Styling */
        .badge.bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .badge.bg-secondary {
            background-color: var(--secondary-color) !important;
        }
        
        .badge.bg-accent {
            background-color: var(--accent-color) !important;
            color: var(--primary-dark);
        }
        
        /* Additional styles from your existing layout */
        @stack('styles')
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-home me-2"></i>UTHM Student Housing
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(Auth::user()->user_type === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.properties*') ? 'active' : '' }}" href="{{ route('admin.properties') }}">
                                    <i class="fas fa-building me-1"></i> Properties
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Auth::user()->user_type === 'landlord')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('landlord.dashboard') ? 'active' : '' }}" href="{{ route('landlord.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('landlord.properties*') ? 'active' : '' }}" href="{{ route('landlord.properties') }}">
                                    <i class="fas fa-building me-1"></i> Properties
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('landlord.applications*') ? 'active' : '' }}" href="{{ route('landlord.applications') }}">
                                    <i class="fas fa-file-alt me-1"></i> Applications
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Auth::user()->user_type === 'student')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                                    <i class="fas fa-home me-1"></i> Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}" href="{{ route('student.profile') }}">
                                    <i class="fas fa-user me-1"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-home me-2"></i>UTHM Student Housing</h5>
                    <p class="mb-0">Finding the perfect accommodation for UTHM students.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="{{ route('login') }}" class="text-light text-decoration-none">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-light text-decoration-none">Register</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i>info@uthmhousing.com</li>
                        <li><i class="fas fa-phone me-2"></i>+60 12-345-6789</li>
                    </ul>
                </div>
            </div>
            <hr class="my-3 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} UTHM Student Housing. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>