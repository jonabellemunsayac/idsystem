<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Kalawaan, Pasig</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('barangayKalawaan/styles.css') }}" rel="stylesheet">
</head>
<body style="background:white">

    <nav class="navbar navbar-expand-lg fixed-top p-0" style="background: white; height: 80px">
    <div class="container-fluid p-0">
      <!-- Logo + Name -->
      <div class="d-flex align-items-center p-0">
          <img src="{{ asset('barangayKalawaan/images/logo.png') }}" alt="Logo" class="img-fluid" 
               style="height: 70px; width: 70px; border-radius: 50%; margin-right: 10px;">
          
          <div class="d-flex flex-column justify-content-center text-start">
            <h1 class="fw-bold m-0">Barangay Kalawaan</h1>
            <small>Pasig City, Metro Manila, Philippines</small>
          </div>
      </div>

      <!-- Hamburger -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapsible content -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <!-- Search -->
        <div class="mx-auto my-2 search-container">
          <form action="" class="d-flex position-relative">
            <input type="text" placeholder="Search" class="form-control" style="border-radius: 20px 0 0 20px;">
            <button class="btn text-white" style="background: black; border-radius: 0 20px 20px 0;">Search</button>
          </form>
        </div>

        <!-- Nav Links -->
        <div class="navlink d-flex flex-column flex-lg-row align-items-center">
          <a href="{{ url('/') }}" class="nav-link fw-bold text-black">Home</a>
          <a href="{{ url('/about') }}" class="nav-link fw-bold text-black">About</a>
          <a href="{{ url('/services') }}" class="nav-link fw-bold text-black">Services</a>
          <a href="{{ url('/news') }}" class="nav-link fw-bold text-black">News</a>
          <a href="{{ url('/contact') }}" class="nav-link fw-bold text-black">Contact Us</a>
          <a href="{{ route('login') }}" class="nav-link fw-bold text-primary">Portal Login</a>
        </div>
      </div>
    </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('barangayKalawaan/images/img1.png') }}" class="d-block w-100" alt="Barangay Hall">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('barangayKalawaan/images/img2.png') }}" class="d-block w-100" alt="Community">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('barangayKalawaan/images/img3.png') }}" class="d-block w-100" alt="Services">
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <div class="hero-overlay">
            <div class="container text-center text-white">
                <h1 class="display-3 fw-bold mb-3">Welcome to Barangay Kalawaan</h1>
                <p class="lead mb-4">Your Partner in Community Development and Progress</p>
                <a href="{{ route('public.register') }}" class="btn btn-light btn-lg px-5">Register Now</a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Our Services</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-file-text display-4 text-primary mb-3"></i>
                            <h5 class="card-title fw-bold">Document Issuance</h5>
                            <p class="card-text">Barangay Clearance, Certificates, and IDs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-shield-check display-4 text-primary mb-3"></i>
                            <h5 class="card-title fw-bold">Peace & Order</h5>
                            <p class="card-text">Blotter reports and conflict resolution</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-calendar-check display-4 text-primary mb-3"></i>
                            <h5 class="card-title fw-bold">Appointments</h5>
                            <p class="card-text">Schedule appointments with barangay officials</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section id="news" class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Latest News & Updates</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ asset('barangayKalawaan/images/news1.jpg') }}" class="card-img-top" alt="News 1">
                        <div class="card-body">
                            <p class="text-muted small mb-2">January 5, 2026</p>
                            <h5 class="card-title fw-bold">Community Clean-up Drive</h5>
                            <p class="card-text">Join us in our monthly community clean-up initiative...</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ asset('barangayKalawaan/images/news2.jpg') }}" class="card-img-top" alt="News 2">
                        <div class="card-body">
                            <p class="text-muted small mb-2">January 3, 2026</p>
                            <h5 class="card-title fw-bold">Free Medical Mission</h5>
                            <p class="card-text">Free health check-ups and consultations available...</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ asset('barangayKalawaan/images/news3.jpg') }}" class="card-img-top" alt="News 3">
                        <div class="card-body">
                            <p class="text-muted small mb-2">December 28, 2025</p>
                            <h5 class="card-title fw-bold">Skills Training Program</h5>
                            <p class="card-text">Enroll now in our livelihood skills training program...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-white py-5" style="background: #003067;">
        <div class="container">
            <div class="row">
            <!-- Column 1: Logo + Name -->
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('barangayKalawaan/images/logo.png') }}" alt="Logo" class="img-fluid me-3" 
                         style="height: 60px; width: 60px; border-radius: 50%;">
                    <div>
                        <h5 class="fw-bold mb-0">Barangay Kalawaan</h5>
                        <small>Pasig City</small>
                    </div>
                </div>
                <p class="small">Serving the community with dedication and excellence since 1975.</p>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-white text-decoration-none">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="text-white text-decoration-none">About Us</a></li>
                    <li><a href="{{ url('/services') }}" class="text-white text-decoration-none">Services</a></li>
                    <li><a href="{{ url('/news') }}" class="text-white text-decoration-none">News</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-white text-decoration-none">Contact Us</a></li>
                    <li><a href="{{ route('login') }}" class="text-white text-decoration-none">Portal Login</a></li>
                </ul>
            </div>

            <!-- Column 3: Contact Info -->
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Contact Us</h6>
                <p class="mb-1">Kalawaan, Pasig City</p>
                <p class="mb-1 text-white" style="color: white !important;">(02) 8643-1111</p>
                <p class="mb-1">brgykalawaan.gov@gmail.com</p>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <a href="#" class="text-white"><i class="bi bi-facebook" style="font-size: 1.5rem;"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-twitter-x" style="font-size: 1.5rem;"></i></a>
                </div>
            </div>
            </div>

            <hr class="my-4 text-secondary">

            <div class="text-center small text-white">
            © 2026 Barangay Kalawaan, Pasig City. All Rights Reserved.
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
