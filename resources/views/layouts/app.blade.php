<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pasig BMS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --pasig-blue: #0038A8;
            --pasig-red: #CE1126;
            --sidebar-width-lg: 200px;
            --sidebar-width-sm: 60px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        #wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        #sidebar-wrapper {
            width: var(--sidebar-width-lg);
            background-color: var(--pasig-blue);
            color: white;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            transition: width 0.3s ease-out;
        }

        .sidebar-heading {
            padding: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .sidebar-logo {
            width: 32px;
            height: 32px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--pasig-blue);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .sidebar-logo i.bi {
            font-weight: normal;
            line-height: 1;
        }

        .sidebar-title h2 {
            font-size: 0.8rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.1;
        }

        .sidebar-title p {
            font-size: 0.65rem;
            opacity: 0.8;
            margin: 0;
            font-weight: 400;
        }

        .sidebar-menu-label {
            display: none;
        }

        .list-group {
            flex: 1;
            padding: 0.25rem 0;
        }

        .list-group-item {
            background-color: transparent !important;
            color: white !important;
            border: none !important;
            padding: 0.5rem 0.75rem !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            transition: all 0.2s;
            cursor: pointer;
            font-weight: 500;
            margin: 0.1rem 0.4rem;
            border-radius: 4px;
        }

        .list-group-item:hover {
            background-color: rgba(255, 255, 255, 0.15) !important;
        }

        .list-group-item.active {
            background-color: var(--pasig-red) !important;
            font-weight: 600;
        }

        .list-group-item i.bi {
            font-weight: normal;
            line-height: 1;
            flex-shrink: 0;
            font-size: 0.95rem;
        }

        .list-group-item i.bi.bi-chevron-down {
            font-size: 0.65rem;
            margin-left: auto;
            transition: transform 0.2s;
        }

        .list-group-item[aria-expanded="true"] i.bi.bi-chevron-down {
            transform: rotate(180deg);
        }

        /* Collapse items */
        .collapse .list-group-item {
            padding: 0.4rem 0.75rem 0.4rem 2rem !important;
            font-size: 0.75rem;
        }

        /* Page Content */
        #page-content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            gap: 0.75rem;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex: 1;
            min-width: 0;
        }

        .btn-icon {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 0.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: color 0.2s;
            position: relative;
            flex-shrink: 0;
        }

        .btn-icon:hover {
            color: var(--pasig-blue);
        }

        .btn-icon i.bi {
            font-weight: normal;
            line-height: 1;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            background-color: #f3f4f6;
            border-radius: 4px;
            padding: 0.4rem 0.6rem;
            flex: 1;
            max-width: 300px;
            min-width: 120px;
        }

        .search-wrapper i {
            color: #9ca3af;
            margin-right: 0.4rem;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .search-wrapper i.bi {
            font-weight: normal;
            line-height: 1;
        }

        .search-wrapper input {
            border: none !important;
            background: transparent !important;
            outline: none;
            font-size: 0.8rem;
            width: 100%;
        }

        .search-wrapper input::placeholder {
            color: #9ca3af;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .notification-dot {
            width: 5px;
            height: 5px;
            background-color: #ef4444;
            border-radius: 50%;
            position: absolute;
            top: 1px;
            right: 1px;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }

        .dropdown-menu {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .dropdown-item {
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
            color: var(--pasig-blue);
        }

        /* Responsive: Tablet */
        @media (max-width: 1024px) and (min-width: 769px) {
            #sidebar-wrapper {
                width: var(--sidebar-width-sm);
            }

            .sidebar-heading {
                justify-content: center;
                padding: 0.6rem;
            }

            .sidebar-title {
                display: none;
            }

            .sidebar-logo {
                width: 28px;
                height: 28px;
                font-size: 0.95rem;
            }

            .list-group-item {
                justify-content: center;
                font-size: 0;
                padding: 0.5rem !important;
                margin: 0.1rem 0.3rem;
            }

            .list-group-item i:not(.bi-chevron-down) {
                font-size: 1rem;
                margin-right: 0;
            }

            .list-group-item i.bi-chevron-down {
                display: none;
            }

            .collapse .list-group-item {
                padding: 0.5rem !important;
            }

            .search-wrapper {
                display: none;
            }

            .main-content {
                padding: 0.75rem;
            }
        }

        /* Mobile Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* Responsive: Mobile */
        @media (max-width: 768px) {
            #wrapper {
                flex-direction: column;
            }

            #sidebar-wrapper {
                position: fixed;
                top: 0;
                left: -280px;
                width: 280px;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease;
                box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
            }

            #sidebar-wrapper.show {
                left: 0;
            }

            .sidebar-heading {
                padding: 1rem;
                justify-content: flex-start;
            }

            .sidebar-logo {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }

            .sidebar-title {
                display: block;
            }

            .list-group {
                flex-direction: column;
                padding: 0.25rem 0;
            }

            .list-group-item {
                font-size: 0.85rem !important;
                padding: 0.6rem 0.75rem !important;
                margin: 0.1rem 0.4rem;
                border-radius: 4px;
                justify-content: flex-start;
            }

            .list-group-item i:not(.bi-chevron-down) {
                margin-right: 0.5rem;
                font-size: 1rem;
            }

            .list-group-item i.bi-chevron-down {
                display: inline-block;
                margin-left: auto;
            }

            .collapse {
                display: block !important;
                height: 0;
                overflow: hidden;
                transition: height 0.3s ease;
            }

            .collapse.show {
                height: auto;
            }

            .collapse .list-group-item {
                display: flex !important;
                padding-left: 2.5rem !important;
                font-size: 0.8rem !important;
            }

            #page-content-wrapper {
                width: 100%;
            }

            .topbar {
                padding: 0.75rem;
            }

            .topbar-left {
                flex: 1;
            }

            .btn-icon {
                font-size: 1.2rem;
            }

            .search-wrapper {
                display: none !important;
            }

            .main-content {
                padding: 0.75rem;
            }
        }

        /* Responsive: Small Mobile */
        @media (max-width: 480px) {
            .topbar {
                padding: 0.4rem 0.5rem;
            }

            .btn-icon {
                font-size: 1rem;
                padding: 0.3rem;
            }

            .main-content {
                padding: 0.5rem;
            }

            .list-group-item {
                font-size: 0.7rem;
                padding: 0.4rem 0.5rem !important;
            }

            .search-wrapper {
                padding: 0.35rem 0.4rem;
                max-width: none;
            }

            .search-wrapper input {
                font-size: 0.75rem;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/list-views.css') }}">
    @yield('extra-styles')
</head>
<body>
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">
                <div class="sidebar-logo">
                    <i class="bi bi-building"></i>
                </div>
                <div class="sidebar-title">
                    <h2>Barangay</h2>
                    <p>E-Services System</p>
                </div>
            </div>
            
            <div class="sidebar-menu-label">Menu</div>
            
            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}" class="list-group-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
                
                @if(in_array(auth()->user()->role, ['encoder', 'admin', 'superadmin']))
                <!-- Residents Group -->
                <a href="#residentsSubmenu" class="list-group-item" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('residents.*') || request()->routeIs('clans.*') ? 'true' : 'false' }}">
                    <i class="bi bi-people-fill"></i> Residents <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8em;"></i>
                </a>
                <div class="collapse {{ request()->routeIs('residents.*') || request()->routeIs('clans.*') ? 'show' : '' }}" id="residentsSubmenu">
                    <a href="{{ route('residents.index') }}" class="list-group-item ps-5 {{ request()->routeIs('residents.*') ? 'active' : '' }}" style="font-size: 0.85rem;">
                        Resident Records
                    </a>
                    <a href="{{ route('clans.index') }}" class="list-group-item ps-5 {{ request()->routeIs('clans.*') ? 'active' : '' }}" style="font-size: 0.85rem;">
                        Clan Module
                    </a>
                </div>

                <a href="{{ route('ids.index') }}" class="list-group-item {{ request()->routeIs('ids.*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card-fill"></i> ID Management
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
                <a href="{{ route('appointments.index') }}" class="list-group-item {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event-fill"></i> Appointments
                </a>
                
                <a href="{{ route('blotter.index') }}" class="list-group-item {{ request()->routeIs('blotter.*') ? 'active' : '' }}">
                    <i class="bi bi-file-text-fill"></i> Blotter Records
                </a>
                
                <a href="{{ route('assets.index') }}" class="list-group-item {{ request()->routeIs('assets.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam-fill"></i> Assets Management
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['encoder', 'admin', 'superadmin']))
                <a href="{{ route('certificates.index') }}" class="list-group-item {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                    <i class="bi bi-award-fill"></i> Certificates
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
                <a href="{{ route('reports.index') }}" class="list-group-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill"></i> Reports & Analytics
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['site_editor', 'admin', 'superadmin']))
                <a href="{{ route('site-editor.index') }}" class="list-group-item {{ request()->routeIs('site-editor.*') ? 'active' : '' }}">
                    <i class="bi bi-brush-fill"></i> Site Editor
                </a>
                @endif

                @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('audit-logs.index') }}" class="list-group-item {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Audit Logs
                </a>

                <!-- User Management (superadmin only) -->
                <a href="{{ route('users.index') }}" class="list-group-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> User Management
                </a>
                @endif

                <!-- Settings Group -->
                <a href="#settingsSubmenu" class="list-group-item" data-bs-toggle="collapse"
                   aria-expanded="{{ request()->routeIs('settings.*') ? 'true' : 'false' }}">
                    <i class="bi bi-gear-fill"></i> Settings <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8em;"></i>
                </a>
                <div class="collapse {{ request()->routeIs('settings.*') ? 'show' : '' }}" id="settingsSubmenu">
                    <a href="{{ route('settings.user-account.index') }}" class="list-group-item ps-5 {{ request()->routeIs('settings.user-account.*') ? 'active' : '' }}" style="font-size: 0.85rem;">
                        User Accounts
                    </a>
                </div>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="topbar">
                <div class="topbar-left">
                    <button class="btn-icon d-md-none" id="menu-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                </div>

                <div class="topbar-actions">
                    <div class="dropdown">
                        <button class="btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Admin User</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('settings.user-account.index') }}">Change Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="main-content">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-exclamation-circle me-2"></i>Error!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        const sidebar = document.getElementById('sidebar-wrapper');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleButton = document.getElementById('menu-toggle');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }

        if (toggleButton) {
            toggleButton.addEventListener('click', toggleSidebar);
        }

        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }

        // Close sidebar when clicking a link on mobile
        if (window.innerWidth <= 768) {
            const sidebarLinks = document.querySelectorAll('#sidebar-wrapper .list-group-item');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Don't close if it's a collapse toggle
                    if (!this.hasAttribute('data-bs-toggle')) {
                        setTimeout(() => {
                            if (sidebar.classList.contains('show')) {
                                toggleSidebar();
                            }
                        }, 200);
                    }
                });
            });
        }
    </script>
    @yield('extra-scripts')
</body>
</html>
