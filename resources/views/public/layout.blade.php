<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barangay Kalawaan | Pasig City')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/pasig.css') }}" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('public.home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <div class="brand-text d-flex flex-column">
                    <h1>Barangay Kalawaan</h1>
                    <small>Pasig City, Metro Manila</small>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-2 align-items-center">
                    <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() === 'public.home') active @endif" href="{{ route('public.home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() === 'public.about') active @endif" href="{{ route('public.about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() === 'public.services') active @endif" href="{{ route('public.services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() === 'public.news') active @endif" href="{{ route('public.news') }}">News & Updates</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() === 'public.contact') active @endif" href="{{ route('public.contact') }}">Contact</a></li>
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('login') }}" class="btn btn-pasig btn-sm px-4">Resident Portal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="footer-brand mb-4 d-flex align-items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50">
                        <div>
                            <h5 class="mb-0">Barangay Kalawaan</h5>
                            <small>Pasig City</small>
                        </div>
                    </div>
                    <p class="footer-text">Committed to community development, peace, order, and progress. Serving Kalawaan residents with excellence and integrity.</p>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-4">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('public.home') }}" class="footer-link">Home</a></li>
                        <li><a href="{{ route('public.about') }}" class="footer-link">About Us</a></li>
                        <li><a href="{{ route('public.services') }}" class="footer-link">Services</a></li>
                        <li><a href="{{ route('public.news') }}" class="footer-link">News</a></li>
                        <li><a href="{{ route('public.contact') }}" class="footer-link">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-4">Services</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('public.services') }}" class="footer-link">Barangay ID</a></li>
                        <li><a href="{{ route('public.services') }}" class="footer-link">Barangay Clearance</a></li>
                        <li><a href="{{ route('public.services') }}" class="footer-link">Certificates</a></li>
                        <li><a href="{{ route('public.services') }}" class="footer-link">Business Permit</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-4">Contact Info</h6>
                    <p class="footer-text mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        Barangay Hall, Kalawaan, Pasig City
                    </p>
                    <p class="footer-text mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        (02) 8643-1111
                    </p>
                    <p class="footer-text mb-3">
                        <i class="bi bi-envelope me-2"></i>
                        brgykalawaan.gov@gmail.com
                    </p>
                    <h6 class="fw-bold mb-3">Follow Us</h6>
                    <a href="https://www.facebook.com/barangay.kalawaan.2024" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-light">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center footer-bottom">
                <p class="mb-0">© 2026 Barangay Kalawaan, Pasig City. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
