@extends('public.layout')

@section('title', 'Barangay Kalawaan | Pasig City')

@section('content')

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show position-fixed" style="top: 100px; right: 20px; z-index: 9999; max-width: 400px;" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container hero-content text-center text-lg-start">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="badge bg-warning text-dark mb-4 px-3 py-2 rounded-pill fw-bold text-uppercase ls-1">Welcome to Pasig City</span>
                    <h1 class="hero-title text-white">Experience a Progressive & Safe Community</h1>
                    <p class="hero-subtitle">Barangay Kalawaan is committed to providing efficient public service, ensuring safety, and fostering unity among its residents.</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('public.services') }}" class="btn btn-pasig btn-lg">Explore Services</a>
                        <a href="{{ route('public.about') }}" class="btn btn-outline-pasig btn-lg">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services / Features -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row mb-5 align-items-end">
                <div class="col-lg-8">
                    <span class="section-label">Our Service</span>
                    <h2 class="display-5 fw-bold text-blue">Efficient Public Service</h2>
                    <p class="text-muted lead">Access barangay services online or visit us for assistance.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('public.services') }}" class="btn btn-outline-primary rounded-pill px-4">View All Services</a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('public.services') }}" class="text-decoration-none">
                        <div class="feature-card">
                            <div class="icon-wrapper">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <h4 class="mb-3">Barangay ID</h4>
                            <p class="text-muted small mb-0">Get your official identification card for valid transactions.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('public.services') }}" class="text-decoration-none">
                        <div class="feature-card">
                            <div class="icon-wrapper">
                                <i class="bi bi-file-earmark-check"></i>
                            </div>
                            <h4 class="mb-3">Clearance</h4>
                            <p class="text-muted small mb-0">Apply for barangay clearance for employment or other purposes.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('public.services') }}" class="text-decoration-none">
                        <div class="feature-card">
                            <div class="icon-wrapper">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <h4 class="mb-3">Certificates</h4>
                            <p class="text-muted small mb-0">Request certificates of residency, indigency, and more.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('public.services') }}" class="text-decoration-none">
                        <div class="feature-card">
                            <div class="icon-wrapper">
                                <i class="bi bi-shop"></i>
                            </div>
                            <h4 class="mb-3">Business Permit</h4>
                            <p class="text-muted small mb-0">Secure necessary permits for your local business operations.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- News Highlights -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center section-header mx-auto">
                <span class="section-label">Latest Updates</span>
                <h2 class="display-5 fw-bold text-blue">News & Events</h2>
                <p class="text-muted">Stay informed about the latest happenings in our community.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <div class="position-relative">
                            <img src="{{ asset('images/blog1.png') }}" alt="News" class="news-img">
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3">Featured</span>
                        </div>
                        <div class="news-body">
                            <span class="news-date">July 4, 2025</span>
                            <h3 class="news-title">Pasig LGU acts on Topaz Road incident</h3>
                            <p class="text-muted small mb-4">Local government agencies coordinate to address safety concerns in the area...</p>
                            <a href="{{ route('public.news') }}" class="text-blue fw-bold small text-decoration-none">Read Full Story <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                     <div class="news-card">
                        <div class="position-relative">
                            <img src="{{ asset('images/blog1.png') }}" alt="News" class="news-img">
                        </div>
                        <div class="news-body">
                            <span class="news-date">July 10, 2025</span>
                            <h3 class="news-title">Community Clean-up Drive Success</h3>
                            <p class="text-muted small mb-4">Residents volunteered for a greener and cleaner Kalawaan this weekend...</p>
                            <a href="{{ route('public.news') }}" class="text-blue fw-bold small text-decoration-none">Read Full Story <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                     <div class="news-card">
                        <div class="position-relative">
                            <img src="{{ asset('images/blog1.png') }}" alt="News" class="news-img">
                        </div>
                        <div class="news-body">
                            <span class="news-date">July 15, 2025</span>
                            <h3 class="news-title">Medical Mission Schedule Announced</h3>
                            <p class="text-muted small mb-4">Free check-ups and medicine distribution will be held at the Barangay Hall...</p>
                            <a href="{{ route('public.news') }}" class="text-blue fw-bold small text-decoration-none">Read Full Story <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('public.news') }}" class="btn btn-outline-primary rounded-pill px-5">View All News</a>
            </div>
        </div>
    </section>

    <!-- About / Quick Info -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <img src="{{ asset('images/kalawaan.jpg') }}" alt="About Kalawaan" class="img-fluid rounded-4 shadow-lg w-100">
                </div>
                <div class="col-lg-6">
                    <span class="section-label">About Us</span>
                    <h2 class="display-5 fw-bold text-blue mb-4">A Historic & Vibrant Community</h2>
                    <p class="text-muted mb-4">Kalawaan is one of the thirty barangays comprising the City of Pasig. Sprawling along the legendary Pasig River, it has grown from a humble settlement of duck raisers in 1926 to a thriving residential and commercial area today.</p>
                    
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="quick-link-item">
                                <div class="quick-link-icon"><i class="bi bi-geo-alt"></i></div>
                                <div>
                                    <small class="text-muted d-block">Location</small>
                                    <span class="fw-bold text-dark">Pasig City</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="quick-link-item">
                                <div class="quick-link-icon"><i class="bi bi-map"></i></div>
                                <div>
                                    <small class="text-muted d-block">Land Area</small>
                                    <span class="fw-bold text-dark">200+ hectares</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('public.about') }}" class="btn btn-pasig btn-lg mt-4">Learn More About Us</a>
                </div>
            </div>
        </div>
    </section>

@endsection
