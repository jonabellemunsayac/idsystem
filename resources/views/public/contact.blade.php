@extends('public.layout')

@section('title', 'Contact Us | Barangay Kalawaan')

@section('content')

    <!-- Page Header -->
    <header class="page-header py-5 bg-light mt-5">
        <div class="container pt-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold text-blue">Contact Us</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Contact Info Cards -->
    <section class="section-padding pb-0">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Visit Us</h5>
                        <p class="text-muted mb-0">Barangay Hall, Kalawaan<br>Pasig City, Metro Manila</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Call Us</h5>
                        <p class="text-muted mb-0">Emergency: (02) 8643-1111<br>Office: (02) 8643-2222</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Email Us</h5>
                        <p class="text-muted mb-0">info@brgykalawaan.gov.ph<br>secretariat@brgykalawaan.gov.ph</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Map -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <h3 class="fw-bold text-blue mb-4">Send us a Message</h3>
                    <p class="text-muted mb-5">Have any questions, concerns, or suggestions? Fill out the form below and we'll get back to you as soon as possible.</p>
                    
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light border-0" id="name" placeholder="Your Name">
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control bg-light border-0" id="email" placeholder="Your Email">
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light border-0" id="subject" placeholder="Subject">
                                    <label for="subject">Subject</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control bg-light border-0" placeholder="Message" id="message" style="height: 150px"></textarea>
                                    <label for="message">Message</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-pasig py-3 px-5 w-100">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="h-100 rounded-4 overflow-hidden shadow-sm" style="min-height: 400px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.642738743128!2d121.08051797590393!3d14.562391985919655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c7d7e34563d7%3A0xe8d0172e01df37f8!2sBarangay%20Kalawaan%20Hall!5e0!3m2!1sen!2sph!4v1709653066986!5m2!1sen!2sph" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
