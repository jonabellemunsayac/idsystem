<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barangay Kalawaan') | Pasig City</title>
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
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}" href="{{ route('public.home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.about') ? 'active' : '' }}" href="{{ route('public.about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.services') ? 'active' : '' }}" href="{{ route('public.services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.news') ? 'active' : '' }}" href="{{ route('public.news') }}">News & Updates</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.contact') ? 'active' : '' }}" href="{{ route('public.contact') }}">Contact</a></li>
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('public.services') }}" class="btn btn-pasig btn-sm px-4">e-Services</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
                            <small class="text-secondary">Official Website</small>
                        </div>
                    </div>
                    <p class="text-secondary mb-4 small">Dedicated to serving the people of Pasig with integrity, transparency, and excellence.</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white mb-4">Quick Links</h6>
                    <div class="footer-links">
                        <a href="{{ route('public.home') }}">Home</a>
                        <a href="{{ route('public.about') }}">About Us</a>
                        <a href="{{ route('public.services') }}">Services</a>
                        <a href="{{ route('public.news') }}">News</a>
                        <a href="{{ route('public.contact') }}">Contact</a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white mb-4">Services</h6>
                    <div class="footer-links">
                        <a href="{{ route('public.services') }}">Barangay ID</a>
                        <a href="{{ route('public.services') }}">Barangay Clearance</a>
                        <a href="{{ route('public.services') }}">Indigency</a>
                        <a href="{{ route('public.services') }}">Business Permit</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h6 class="text-white mb-4">Contact Information</h6>
                    <ul class="list-unstyled text-secondary small">
                        <li class="mb-3 d-flex gap-2">
                            <i class="bi bi-geo-alt-fill text-blue"></i>
                            <span>Barangay Hall, Kalawaan, Pasig City, Metro Manila</span>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="bi bi-telephone-fill text-blue"></i>
                            <span>(02) 8643-1111</span>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="bi bi-envelope-fill text-blue"></i>
                            <span>brgykalawaan.gov@gmail.com</span>
                        </li>
                        <li class="d-flex gap-2">
                            <i class="bi bi-clock-fill text-blue"></i>
                            <span>Mon - Fri: 8:00 AM - 5:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; 2026 Barangay Kalawaan, Pasig City. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('shadow-md');
            } else {
                document.querySelector('.navbar').classList.remove('shadow-md');
            }
        });
    </script>
</body>
</html>
