<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EventHub - TARUMT Event Management System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            .hero-section {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
            }
            .hero-content {
                color: white;
            }
            .feature-card {
                transition: transform 0.3s ease;
                border: none;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .feature-card:hover {
                transform: translateY(-5px);
            }
            .btn-custom {
                border-radius: 25px;
                padding: 12px 30px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-calendar-alt me-2"></i>EventHub
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
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

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 hero-content">
                        <h1 class="display-4 fw-bold mb-4">
                            Welcome to EventHub
                        </h1>
                        <p class="lead mb-4">
                            TARUMT's comprehensive event management platform for seamless event planning, 
                            vendor coordination, and ticket booking.
                        </p>
                        <div class="d-flex gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-light btn-custom">
                                    <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-light btn-custom">
                                    <i class="fas fa-user-plus me-2"></i>Get Started
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-custom">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <i class="fas fa-calendar-alt text-white" style="font-size: 15rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold">Key Features</h2>
                    <p class="lead text-muted">Everything you need for successful event management</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                <h5 class="card-title">User Management</h5>
                                <p class="card-text">
                                    Role-based access control for admins, vendors, and customers with secure authentication.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-plus fa-3x text-success mb-3"></i>
                                <h5 class="card-title">Event Management</h5>
                                <p class="card-text">
                                    Create, manage, and track events with comprehensive planning tools and timeline management.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-ticket-alt fa-3x text-warning mb-3"></i>
                                <h5 class="card-title">Ticket Booking</h5>
                                <p class="card-text">
                                    Streamlined ticket booking system with multiple payment options and digital receipts.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-store fa-3x text-info mb-3"></i>
                                <h5 class="card-title">Vendor Management</h5>
                                <p class="card-text">
                                    Coordinate vendors and manage booth bookings with integrated payment processing.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-headset fa-3x text-secondary mb-3"></i>
                                <h5 class="card-title">Customer Support</h5>
                                <p class="card-text">
                                    Comprehensive support system with inquiry tracking and automated notifications.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-bar fa-3x text-danger mb-3"></i>
                                <h5 class="card-title">Analytics & Reports</h5>
                                <p class="card-text">
                                    Detailed analytics and reporting tools for event performance and user insights.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-5 bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="display-6 fw-bold mb-4">About EventHub</h2>
                        <p class="lead mb-4">
                            EventHub is a comprehensive event management platform designed specifically for TARUMT 
                            to streamline event organization, vendor coordination, and customer engagement.
                        </p>
                        <p class="mb-4">
                            Our platform provides everything needed for successful event management, from initial 
                            planning to post-event analysis, ensuring seamless coordination between all stakeholders.
                        </p>
                        <div class="d-flex gap-3">
                            @guest
                                <a href="{{ route('register') }}" class="btn btn-primary btn-custom">
                                    <i class="fas fa-rocket me-2"></i>Start Now
                                </a>
                            @endguest
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <i class="fas fa-university text-primary" style="font-size: 10rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white py-4">
            <div class="container text-center">
                <p class="mb-0">&copy; {{ date('Y') }} EventHub - TARUMT Event Management System. All rights reserved.</p>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
