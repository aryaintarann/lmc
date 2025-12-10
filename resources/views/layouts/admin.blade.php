<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Legian Medical Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0a2540;
            --secondary-color: #1c4966;
            --sidebar-width: 250px;
        }

        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--primary-color);
            color: white;
            padding-top: 20px;
            z-index: 1000;
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            color: #fff;
            text-decoration: none;
            display: block;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #fff;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
        }

        .top-bar {
            background: white;
            padding: 15px 30px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 20px;
            border-radius: 15px 15px 0 0 !important;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">LMC Admin</a>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <!-- Content Section -->
            <div class="sidebar-heading mt-3 mb-2 px-3 text-white-50 small text-uppercase">Content</div>

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

            <a class="nav-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}"
                href="{{ route('admin.settings.index') }}">
                <i class="bi bi-gear"></i> Advanced
            </a>
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

            @if(Auth::user()->role === 'owner')
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
                <span class="me-3 text-muted">Welcome, {{ Auth::user()->name }}</span>
                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                    {{ substr(Auth::user()->name, 0, 1) }}
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
</body>

</html>