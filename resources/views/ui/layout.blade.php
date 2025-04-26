<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - UTHM Student Housing</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add this in the head section, after your existing CSS links -->
    <style>
        /* Property Application Styles */
        .card {
            border: none;
            border-radius: 10px;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0;
            background: linear-gradient(45deg, #4e73df, #224abe);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
            border: none;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e0e0e0;
        }
        
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
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
            color: #4e73df;
        }
    
        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
        }
    
        .modal-header {
            background: linear-gradient(45deg, #4e73df, #224abe);
            color: white;
            border-radius: 15px 15px 0 0;
        }
    
        .modal-footer {
            border-top: none;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">UTHM Student Housing</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(auth()->user()->role === 'student')
                            <li class="nav-item">
                                <a class="nav-link" href="/student-area">Student Area</a>
                            </li>
                        @elseif(auth()->user()->role === 'landlord')
                            <li class="nav-item">
                                <a class="nav-link" href="/landlord-area">Landlord Area</a>
                            </li>
                        @elseif(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="/admin-area">Admin Area</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
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

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light mt-5 py-3">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} UTHM Student Housing. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>