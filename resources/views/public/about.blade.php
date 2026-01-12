@extends('public.layout')

@section('title', 'About Us | Barangay Kalawaan')

@section('content')

    <!-- Page Header -->
    <header class="page-header py-5 bg-light mt-5">
        <div class="container pt-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold text-blue">About Us</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- History Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('images/kalawaan.jpg') }}" alt="Kalawaan History" class="img-fluid rounded-4 shadow w-100">
                </div>
                <div class="col-lg-6">
                    <span class="section-label">Our History</span>
                    <h2 class="display-6 fw-bold text-blue mb-4">From Duck Raisers to a Thriving Baranggay</h2>
                    <p class="text-muted">Barangay Kalawaan is one of the thirty barangays comprising the City of Pasig. Its name was derived from the word "Kalawaan" which means "place of spiders" or possibly relating to the vast bodies of water found in the area during the early times.</p>
                    <p class="text-muted">Historically, it was a humble settlement of duck raisers in 1926. Over the decades, it has transformed into a vibrant residential and commercial area while maintaining its rich cultural heritage and community spirit.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="section-padding bg-blue text-white">
        <div class="container">
            <div class="row g-5 text-center">
                <div class="col-md-6">
                    <div class="p-4 border border-light rounded-4 h-100">
                        <div class="display-4 text-warning mb-3"><i class="bi bi-flag"></i></div>
                        <h3 class="fw-bold mb-3">Mission</h3>
                        <p class="lead opacity-75">To provide efficient, effective, and transparent public service to the constituents of Barangay Kalawaan, promoting peace, order, and progress through community involvement.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 border border-light rounded-4 h-100">
                        <div class="display-4 text-warning mb-3"><i class="bi bi-eye"></i></div>
                        <h3 class="fw-bold mb-3">Vision</h3>
                        <p class="lead opacity-75">A progressive, peaceful, and resilient Barangay Kalawaan inhabited by God-fearing and empowered citizens living in a clean and safe environment.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Barangay Council -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center section-header mx-auto mb-5">
                <span class="section-label">Our Leaders</span>
                <h2 class="display-5 fw-bold text-blue">Barangay Council</h2>
                <p class="text-muted">Meet the dedicated officials serving our community.</p>
            </div>

            <!-- Captain -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-4 col-md-6">
                    <div class="text-center">
                        <div class="mb-3">
                            <img src="{{ asset('images/cap.jpg') }}" alt="Barangay Captain" class="rounded-circle shadow-lg" width="200" height="200" style="object-fit: cover;">
                        </div>
                        <h3 class="h4 fw-bold text-blue">Hon. Juan Dela Cruz</h3>
                        <p class="text-muted text-uppercase small ls-1 fw-bold">Punong Barangay</p>
                    </div>
                </div>
            </div>

            <!-- Councilors -->
            <div class="row g-4 justify-content-center">
                <!-- Councilor 1 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="mb-3">
                            <img src="https://via.placeholder.com/150" alt="Councilor" class="rounded-circle shadow-sm" width="120" height="120">
                        </div>
                        <h5 class="fw-bold text-dark">Hon. Maria Santos</h5>
                        <p class="text-muted small">Kagawad</p>
                    </div>
                </div>
                <!-- Councilor 2 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="mb-3">
                            <img src="https://via.placeholder.com/150" alt="Councilor" class="rounded-circle shadow-sm" width="120" height="120">
                        </div>
                        <h5 class="fw-bold text-dark">Hon. Pedro Reyes</h5>
                        <p class="text-muted small">Kagawad</p>
                    </div>
                </div>
                <!-- Councilor 3 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="mb-3">
                            <img src="https://via.placeholder.com/150" alt="Councilor" class="rounded-circle shadow-sm" width="120" height="120">
                        </div>
                        <h5 class="fw-bold text-dark">Hon. Ana Lim</h5>
                        <p class="text-muted small">Kagawad</p>
                    </div>
                </div>
                <!-- Councilor 4 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="mb-3">
                            <img src="https://via.placeholder.com/150" alt="Councilor" class="rounded-circle shadow-sm" width="120" height="120">
                        </div>
                        <h5 class="fw-bold text-dark">Hon. Jose Garcia</h5>
                        <p class="text-muted small">Kagawad</p>
                    </div>
                </div>
                  <!-- Councilor 5 -->
                  <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="mb-3">
                            <img src="https://via.placeholder.com/150" alt="Councilor" class="rounded-circle shadow-sm" width="120" height="120">
                        </div>
                        <h5 class="fw-bold text-dark">Hon. Lita Cruz</h5>
                        <p class="text-muted small">Kagawad</p>
                    </div>
                </div>
                  <!-- Councilor 6 -->
                  <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="mb-3">
                            <img src="https://via.placeholder.com/150" alt="Councilor" class="rounded-circle shadow-sm" width="120" height="120">
                        </div>
                        <h5 class="fw-bold text-dark">Hon. Robert Tan</h5>
                        <p class="text-muted small">Kagawad</p>
                    </div>
                </div>
                  <!-- Councilor 7 -->
                  <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="mb-3">
                            <img src="https://via.placeholder.com/150" alt="Councilor" class="rounded-circle shadow-sm" width="120" height="120">
                        </div>
                        <h5 class="fw-bold text-dark">Hon. Tessie Sy</h5>
                        <p class="text-muted small">Kagawad</p>
                    </div>
                </div>
                <!-- SK Chair -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="mb-3">
                            <img src="https://via.placeholder.com/150" alt="Councilor" class="rounded-circle shadow-sm" width="120" height="120">
                        </div>
                        <h5 class="fw-bold text-dark">Hon. SK Chair</h5>
                        <p class="text-muted small">SK Chairperson</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
