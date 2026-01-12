@extends('public.layout')

@section('title', 'News & Updates | Barangay Kalawaan')

@section('content')

    <!-- Page Header -->
    <header class="page-header py-5 bg-light mt-5">
        <div class="container pt-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold text-blue">News & Updates</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">News</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Featured News -->
    <section class="section-padding pb-0">
        <div class="container">
             <div class="card border-0 shadow-sm overflow-hidden mb-5">
                <div class="row g-0">
                    <div class="col-lg-7">
                        <img src="{{ asset('images/blog1.png') }}" class="img-fluid h-100 object-fit-cover" alt="Featured News" style="min-height: 400px;">
                    </div>
                    <div class="col-lg-5 p-4 p-lg-5 d-flex flex-column justify-content-center">
                        <span class="badge bg-warning text-dark align-self-start mb-3">Featured Story</span>
                        <div class="news-meta text-muted small mb-2">
                           <i class="bi bi-calendar3 me-2"></i> July 20, 2025
                        </div>
                        <h2 class="card-title fw-bold text-blue mb-3">Major Infrastructure Projects Launched in Kalawaan</h2>
                        <p class="card-text text-muted mb-4">The local government has officially broken ground on several key infrastructure projects aimed at improving drainage systems and road networks within the barangay. This initiative is part of the city-wide development plan...</p>
                        <a href="#" class="btn btn-pasig align-self-start">Read Full Story</a>
                    </div>
                </div>
             </div>
        </div>
    </section>

    <!-- News Grid -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-4">
                 <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <div class="position-relative">
                            <img src="{{ asset('images/blog1.png') }}" alt="News" class="news-img">
                        </div>
                        <div class="news-body">
                            <span class="news-date">July 18, 2025</span>
                            <h3 class="news-title">Updated Waste Collection Schedule</h3>
                            <p class="text-muted small mb-4">Please be advised of the new garbage collection schedule effective starting next week...</p>
                            <a href="#" class="text-blue fw-bold small text-decoration-none">Read Full Story <i class="bi bi-arrow-right"></i></a>
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
                            <h3 class="news-title">Free Rabies Vaccination Drive</h3>
                            <p class="text-muted small mb-4">Protect your pets! Join the free anti-rabies vaccination campaign this coming Saturday...</p>
                            <a href="#" class="text-blue fw-bold small text-decoration-none">Read Full Story <i class="bi bi-arrow-right"></i></a>
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
                            <h3 class="news-title">Scholarship Application Now Open</h3>
                            <p class="text-muted small mb-4">Pasig City Scholars application for the upcoming academic year is now accepting requirements...</p>
                            <a href="#" class="text-blue fw-bold small text-decoration-none">Read Full Story <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <div class="position-relative">
                            <img src="{{ asset('images/blog1.png') }}" alt="News" class="news-img">
                        </div>
                        <div class="news-body">
                            <span class="news-date">July 5, 2025</span>
                            <h3 class="news-title">Senior Citizens Pension Payout</h3>
                            <p class="text-muted small mb-4">Social pension distribution for registered senior citizens will be held at the covered court...</p>
                            <a href="#" class="text-blue fw-bold small text-decoration-none">Read Full Story <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <div class="position-relative">
                            <img src="{{ asset('images/blog1.png') }}" alt="News" class="news-img">
                        </div>
                        <div class="news-body">
                            <span class="news-date">July 1, 2025</span>
                            <h3 class="news-title">Fire Safety Seminar Conducted</h3>
                            <p class="text-muted small mb-4">BFP Pasig conducted a fire safety awareness seminar for residents and business owners...</p>
                            <a href="#" class="text-blue fw-bold small text-decoration-none">Read Full Story <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <div class="position-relative">
                            <img src="{{ asset('images/blog1.png') }}" alt="News" class="news-img">
                        </div>
                        <div class="news-body">
                            <span class="news-date">June 28, 2025</span>
                            <h3 class="news-title">Job Fair 2025</h3>
                            <p class="text-muted small mb-4">Over 50 companies participated in the recently concluded mega job fair at Pasig Sports Center...</p>
                            <a href="#" class="text-blue fw-bold small text-decoration-none">Read Full Story <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link bg-blue border-blue text-white" href="#">1</a></li>
                    <li class="page-item"><a class="page-link text-blue" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-blue" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link text-blue" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>

@endsection
