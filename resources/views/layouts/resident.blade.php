<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Resident Portal - Pasig BMS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --pasig-blue: #0038A8;
            --pasig-red: #CE1126;
            --sidebar-bg: #0038A8;
            --sidebar-hover: rgba(255, 255, 255, 0.15);
            --sidebar-active: rgba(255, 255, 255, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding-bottom: 64px; /* Space for bottom nav on mobile */
        }

        /* Mobile Header */
        .mobile-header {
            background-color: var(--pasig-blue);
            color: white;
            padding: 0.75rem 1rem;
            position: sticky;
            top: 0;
            z-index: 30;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .mobile-header .header-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .hamburger-btn {
            background: none;
            border: none;
            color: white;
            padding: 0.5rem;
            cursor: pointer;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .hamburger-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .mobile-branding {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            border-radius: 0.5rem;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-icon i {
            color: var(--pasig-blue);
            font-size: 1.25rem;
        }

        .brand-text h1 {
            font-size: 0.875rem;
            font-weight: bold;
            line-height: 1;
            margin: 0;
        }

        .brand-text p {
            font-size: 0.625rem;
            opacity: 0.8;
            margin: 0;
        }

        /* Sidebar */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 39;
            display: none;
        }

        .sidebar-overlay.active {
            display: block;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            z-index: 40;
            height: 100vh;
            width: 256px;
            background-color: var(--sidebar-bg);
            color: white;
            display: none;
            flex-direction: column;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .sidebar-header {
            padding: 1rem;
        }

        .sidebar-header .sidebar-branding {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-header .sidebar-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-header h1 {
            font-size: 1rem;
            font-weight: bold;
            line-height: 1;
            margin: 0;
        }

        .sidebar-header p {
            font-size: 0.75rem;
            opacity: 0.75;
            margin: 0;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem 0.75rem;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.25rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: white;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar-nav .nav-link:hover {
            background-color: var(--sidebar-hover);
        }

        .sidebar-nav .nav-link.active {
            background-color: var(--sidebar-active);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 1rem;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            border-top: 1px solid #e5e7eb;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 0 0.5rem;
            z-index: 50;
            box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.1);
        }

        .bottom-nav a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.2s;
        }

        .bottom-nav a:hover {
            color: #6b7280;
        }

        .bottom-nav a.active {
            color: var(--pasig-blue);
        }

        .bottom-nav a i {
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
        }

        .bottom-nav a span {
            font-size: 0.625rem;
            font-weight: 500;
        }

        /* Content Area */
        .container-resident {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .card-header {
            background-color: var(--pasig-blue) !important;
            color: white !important;
            border-bottom: 2px solid var(--pasig-red);
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        .card-body {
            padding: 1rem;
        }

        .btn-primary {
            background-color: var(--pasig-blue);
            border-color: var(--pasig-blue);
        }

        .btn-primary:hover {
            background-color: #002980;
            border-color: #002980;
        }

        .resident-menu {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .resident-menu .btn {
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
            width: 100%;
            text-align: left;
        }

        .sidebar-resident {
            background-color: white;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }

        .sidebar-resident h5 {
            color: var(--pasig-blue);
            font-weight: 700;
            margin-bottom: 0.75rem;
            border-bottom: 2px solid #fbbf24;
            padding-bottom: 0.5rem;
            font-size: 1rem;
        }

        .sidebar-resident a {
            display: block;
            padding: 0.5rem 0;
            color: #333;
            text-decoration: none;
            border-left: 3px solid transparent;
            padding-left: 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .sidebar-resident a:hover {
            color: var(--pasig-blue);
            border-left-color: var(--pasig-blue);
        }

        .sidebar-resident p {
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .resident-header {
            background: linear-gradient(135deg, var(--pasig-blue) 0%, #002980 100%);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .resident-header h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .resident-header p {
            margin-bottom: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }

        .profile-image-container {
            text-align: center;
            margin-bottom: 1rem;
        }

        .profile-image-container img,
        .profile-image-container > div {
            max-width: 120px !important;
            width: 120px !important;
            height: 120px !important;
        }

        /* Desktop Styles */
        @media (min-width: 768px) {
            body {
                padding-bottom: 0;
            }

            .mobile-header,
            .bottom-nav {
                display: none;
            }

            .sidebar {
                position: static;
                transform: translateX(0);
                display: flex;
            }

            .sidebar-overlay {
                display: none !important;
            }

            .main-layout {
                display: flex;
            }

            .content-area {
                flex: 1;
            }

            .resident-menu {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .container-resident {
                padding: 2rem;
            }

            .resident-header h1 {
                font-size: 1.75rem;
            }

            .profile-image-container {
                text-align: left;
            }
        }

        @media (min-width: 992px) {
            .resident-menu {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (min-width: 576px) and (max-width: 767px) {
            .resident-menu {
                grid-template-columns: repeat(2, 1fr);
            }

            .container-resident {
                padding: 1.5rem;
            }

            .card-body {
                padding: 1.25rem;
            }
        }
    </style>
    @yield('extra-styles')
</head>
<body>
    <!-- Mobile Header (visible only on mobile) -->
    <header class="mobile-header d-md-none">
        <div class="header-left">
            <div class="mobile-branding">
                <div class="brand-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div class="brand-text">
                    <h1>Pasig BMS</h1>
                    <p>Resident Portal</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="main-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-branding">
                    <div class="sidebar-icon">
                        <span style="font-size: 1.125rem; font-weight: bold;">P</span>
                    </div>
                    <div>
                        <h1>Pasig BMS</h1>
                        <p>Resident Portal</p>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item">
                    <a href="{{ route('resident.dashboard') }}" class="nav-link {{ request()->routeIs('resident.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-door"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('resident.appointments') }}" class="nav-link {{ request()->routeIs('resident.appointments') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i>
                        <span>Appointments</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('resident.certificates') }}" class="nav-link {{ request()->routeIs('resident.certificates') ? 'active' : '' }}">
                        <i class="bi bi-file-text"></i>
                        <span>Certificates</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('resident.family') }}" class="nav-link {{ request()->routeIs('resident.family') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Family Members</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('resident.profile') }}" class="nav-link {{ request()->routeIs('resident.profile') ? 'active' : '' }}">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="content-area">
            <div class="container-resident">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bottom Navigation (visible only on mobile) -->
    <nav class="bottom-nav d-md-none">
        <a href="{{ route('resident.dashboard') }}" class="{{ request()->routeIs('resident.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door{{ request()->routeIs('resident.dashboard') ? '-fill' : '' }}"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('resident.appointments') }}" class="{{ request()->routeIs('resident.appointments') || request()->routeIs('resident.book-appointment') ? 'active' : '' }}">
            <i class="bi bi-calendar-check{{ request()->routeIs('resident.appointments') || request()->routeIs('resident.book-appointment') ? '-fill' : '' }}"></i>
            <span>Appts</span>
        </a>
        <a href="{{ route('resident.certificates') }}" class="{{ request()->routeIs('resident.certificates') || request()->routeIs('resident.request-certificate') ? 'active' : '' }}">
            <i class="bi bi-file-text{{ request()->routeIs('resident.certificates') || request()->routeIs('resident.request-certificate') ? '-fill' : '' }}"></i>
            <span>Certs</span>
        </a>
        <a href="{{ route('resident.family') }}" class="{{ request()->routeIs('resident.family') ? 'active' : '' }}">
            <i class="bi bi-people{{ request()->routeIs('resident.family') ? '-fill' : '' }}"></i>
            <span>Family</span>
        </a>
        <a href="{{ route('resident.profile') }}" class="{{ request()->routeIs('resident.profile') ? 'active' : '' }}">
            <i class="bi bi-person{{ request()->routeIs('resident.profile') ? '-fill' : '' }}"></i>
            <span>Profile</span>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const hamburgerIcon = document.getElementById('hamburgerIcon');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
            
            // Toggle icon
            if (sidebar.classList.contains('active')) {
                hamburgerIcon.classList.remove('bi-list');
                hamburgerIcon.classList.add('bi-x');
            } else {
                hamburgerIcon.classList.remove('bi-x');
                hamburgerIcon.classList.add('bi-list');
            }
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking nav link on mobile
        document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    toggleSidebar();
                }
            });
        });
    </script>
    @yield('extra-scripts')
</body>
</html>
