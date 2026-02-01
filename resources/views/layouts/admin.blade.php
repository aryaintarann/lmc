<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Legian Medical Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            /* LMC Palette */
            --primary-gradient: linear-gradient(135deg, #2E4D36 0%, #1A2E22 100%);
            --primary-color: #2E4D36;
            --secondary-color: #1A2E22;
            --accent-warm: #C5A059;
            --bg-soft: #f5f7fa;
            --sidebar-width: 260px;
            --card-radius: 20px;
            --btn-radius: 50px;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }

        body {
            background-color: var(--bg-soft);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #344767;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .sidebar-brand,
        .card-header {
            font-family: 'Outfit', sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--primary-gradient);
            color: white;
            padding-top: 20px;
            padding-bottom: 20px;
            z-index: 1000;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.05);
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Scrollbar styling for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 2rem;
            color: #fff;
            text-decoration: none;
            display: block;
            letter-spacing: -0.5px;
            padding: 0 1.5rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 25px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: var(--accent-warm);
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
            opacity: 0.5;
            margin-top: 1.5rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        .top-bar {
            background: white;
            padding: 1rem 2rem;
            margin-bottom: 2rem;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
            background: white;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f0f0f0;
            padding: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            border-radius: var(--card-radius) var(--card-radius) 0 0 !important;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #e0e6ed;
            padding: 0.6rem 1rem;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(28, 73, 102, 0.15);
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: var(--btn-radius);
            padding: 10px 24px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(10, 37, 64, 0.2);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(46, 77, 54, 0.3);
            background: linear-gradient(135deg, #1A2E22 0%, #2E4D36 100%);
            border-color: transparent;
        }

        .btn-secondary {
            border-radius: var(--btn-radius);
            padding: 10px 24px;
            background: #e9ecef;
            border: none;
            color: var(--primary-color);
            font-weight: 600;
        }

        .btn-secondary:hover {
            background: #dde2e6;
            color: var(--primary-color);
        }

        /* Tables */
        .table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #8898aa;
            border-bottom-width: 1px;
            padding-bottom: 1rem;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem 0.75rem;
        }

        /* Tabs */
        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background: transparent;
            border-bottom: 2px solid var(--accent-warm);
        }

        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: var(--primary-color);
        }

        /* Mobile Sidebar Toggle */
        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            display: none;
            background: var(--primary-gradient);
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .sidebar-toggle i {
            font-size: 1.2rem;
        }

        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding-top: 80px;
            }

            .top-bar {
                margin-top: 0;
            }
        }

        @media (max-width: 768px) {
            :root {
                --sidebar-width: 280px;
            }

            .sidebar {
                width: var(--sidebar-width);
            }

            .main-content {
                padding: 1rem;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem;
                padding-left: 75px;
            }

            .top-bar h4 {
                font-size: 1.25rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 1rem;
            }

            .card-header .btn {
                width: 100%;
            }

            .table {
                font-size: 0.875rem;
            }

            .table thead th {
                font-size: 0.7rem;
            }

            .btn-sm {
                padding: 0.375rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .sidebar-brand {
                font-size: 1.1rem;
            }

            .sidebar .nav-link {
                font-size: 0.9rem;
                padding: 10px 20px;
            }

            .sidebar .nav-link i {
                font-size: 1rem;
            }

            .top-bar {
                margin-bottom: 1rem;
            }

            .card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>

<body>
    @php /** @var \App\Models\User $user */ $user = Auth::user(); @endphp

    <!-- Mobile Sidebar Toggle -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">LMC Admin</a>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <!-- Content Section -->
            <div class="sidebar-heading mt-3 mb-2 px-3 text-white-50 small text-uppercase">Analysis</div>

            <a class="nav-link {{ request()->routeIs('admin.analytics.index') ? 'active' : '' }}"
                href="{{ route('admin.analytics.index') }}">
                <i class="bi bi-graph-up-arrow"></i> Analytics
            </a>

            <div class="sidebar-heading mt-3 mb-2 px-3 text-white-50 small text-uppercase">Page Content</div>

            <a class="nav-link {{ request()->routeIs('admin.settings.header') ? 'active' : '' }}"
                href="{{ route('admin.settings.header') }}">
                <i class="bi bi-card-heading"></i> Header
            </a>
            <a class="nav-link {{ request()->routeIs('admin.settings.about') ? 'active' : '' }}"
                href="{{ route('admin.settings.about') }}">
                <i class="bi bi-info-circle"></i> About
            </a>
            <a class="nav-link {{ request()->routeIs('admin.settings.contact') ? 'active' : '' }}"
                href="{{ route('admin.settings.contact') }}">
                <i class="bi bi-telephone"></i> Contact
            </a>

            <!-- Modules Section -->
            <div class="sidebar-heading mt-3 mb-2 px-3 text-white-50 small text-uppercase">Modules</div>


            <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
                href="{{ route('admin.services.index') }}">
                <i class="bi bi-activity"></i> Services
            </a>
            <a class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}"
                href="{{ route('admin.doctors.index') }}">
                <i class="bi bi-people"></i> Doctors
            </a>
            <a class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"
                href="{{ route('admin.articles.index') }}">
                <i class="bi bi-newspaper"></i> Articles
            </a>
            <a class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}"
                href="{{ route('admin.gallery.index') }}">
                <i class="bi bi-images"></i> Gallery
            </a>

            @if($user->role === 'owner')
                <div class="sidebar-heading mt-3 mb-2 px-3 text-white-50 small text-uppercase">Administration</div>
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people-fill"></i> Users
                </a>
            @endif
            <div class="mt-5 px-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100 btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div>
                <h4 class="mb-0 fw-bold">@yield('header')</h4>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-3 text-muted">Welcome, {{ $user->name }}</span>
                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Summernote CSS/JS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', fu n ction() {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');

            function toggleSidebar() {
            sidebar.classList.toggle('show');
            sidebarBackdrop.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }

            if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }

        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', toggleSidebar);
        }

        // Close sidebar when clicking a link on mobile
        const navLinks = sidebar.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', fu nction() {
                if(window.innerWidth <= 1024) {
                toggleSidebar();
            }
        });
            });

        // Handle window resize
        window.addEventListener('resize', f unction() {
            if(window.innerWidth > 1024) {
            sidebar.classList.remove('show');
            sidebarBackdrop.classList.remove('show');
            document.body.style.overflow = '';
        }
            });
});
    </script>

    @stack('scripts')
</body>

</html>