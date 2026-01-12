@extends('public.layout')

@section('title', 'Services | Barangay Kalawaan')

@section('content')

    <!-- Page Header -->
    <header class="page-header py-5 bg-light mt-5">
        <div class="container pt-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold text-blue">Our Services</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Services</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center section-header mx-auto mb-5">
                <span class="section-label">What We Offer</span>
                <h2 class="display-5 fw-bold text-blue">Public Services</h2>
                <p class="text-muted">Convenient and efficient processing of documents and requests.</p>
            </div>

            <div class="row g-4">
                <!-- Service 1: Barangay ID -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-elevate">
                        <div class="card-body p-4 text-center">
                            <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <h4 class="card-title fw-bold mb-3">Barangay ID</h4>
                            <p class="card-text text-muted mb-4">Official identification card for residents of Barangay Kalawaan. Valid for various transactions and proof of residency.</p>
                            <a href="#" class="btn btn-outline-pasig w-100">Apply Now</a>
                        </div>
                    </div>
                </div>

                <!-- Service 2: Barangay Clearance -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-elevate">
                        <div class="card-body p-4 text-center">
                            <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                <i class="bi bi-file-earmark-check"></i>
                            </div>
                            <h4 class="card-title fw-bold mb-3">Barangay Clearance</h4>
                            <p class="card-text text-muted mb-4">Document certifying that a resident has no derogatory record. Requirement for employment, business, and other purposes.</p>
                            <a href="#" class="btn btn-outline-pasig w-100">Apply Now</a>
                        </div>
                    </div>
                </div>

                <!-- Service 3: Certificate of Indigency -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-elevate">
                        <div class="card-body p-4 text-center">
                            <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                <i class="bi bi-heart"></i>
                            </div>
                            <h4 class="card-title fw-bold mb-3">Certificate of Indigency</h4>
                            <p class="card-text text-muted mb-4">Issued to less fortunate residents seeking financial, medical, or educational assistance from government agencies.</p>
                            <a href="#" class="btn btn-outline-pasig w-100">Apply Now</a>
                        </div>
                    </div>
                </div>

                <!-- Service 4: Business Permit -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-elevate">
                        <div class="card-body p-4 text-center">
                            <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                <i class="bi bi-shop"></i>
                            </div>
                            <h4 class="card-title fw-bold mb-3">Business Permit</h4>
                            <p class="card-text text-muted mb-4">Clearance for business operations within the barangay. Ensures compliance with local ordinances.</p>
                            <a href="#" class="btn btn-outline-pasig w-100">Apply Now</a>
                        </div>
                    </div>
                </div>

                <!-- Service 5: Lupon Tagapamayapa -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-elevate">
                        <div class="card-body p-4 text-center">
                             <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                <i class="bi bi-people"></i>
                            </div>
                            <h4 class="card-title fw-bold mb-3">Lupon Tagapamayapa</h4>
                            <p class="card-text text-muted mb-4">Amicable settlement of disputes between residents to promote peace and order in the community.</p>
                            <a href="#" class="btn btn-outline-pasig w-100">Learn More</a>
                        </div>
                    </div>
                </div>

                <!-- Service 6: Other Certifications -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-elevate">
                        <div class="card-body p-4 text-center">
                            <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <h4 class="card-title fw-bold mb-3">Other Certifications</h4>
                            <p class="card-text text-muted mb-4">Certificate of Residency, Certificate of Good Moral Character, and other specific certifications.</p>
                            <a href="#" class="btn btn-outline-pasig w-100">Apply Now</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="section-padding bg-blue text-white text-center">
        <div class="container">
            <h2 class="display-5 fw-bold mb-4">Need Assistance?</h2>
            <p class="lead mb-5 opacity-75">Our barangay staff is ready to help you with your concerns. Visit us at the Barangay Hall.</p>
            <a href="{{ route('public.contact') }}" class="btn btn-warning btn-lg px-5 fw-bold text-dark">Contact Us</a>
        </div>
    </section>

@endsection
