<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} - Legian Medical Clinic</title>
    <link rel="icon" href="{{ asset('img/lmc.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Palette: LMC Brand (Forest Green & Gold/White) */
            --primary-gradient: linear-gradient(135deg, #2E4D36 0%, #1A2E22 100%);
            --primary-color: #2E4D36;
            --secondary-color: #1A2E22;
            --accent-warm: #C5A059;
            --dark-blue: #1A2E22;
            --text-main: #2E4D36;
            --text-muted: #7b809a;
            --bg-soft: #F8F9FA;
            --card-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05);
            --card-hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            --card-radius: 20px;
            --btn-radius: 50px;
        }

        /* Bootstrap Overrides */
        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--accent-warm) !important;
            border-color: var(--accent-warm) !important;
            color: #ffffff !important;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #a38446 !important;
            /* Darker Gold */
            border-color: #a38446 !important;
        }

        .btn-outline-primary {
            color: var(--accent-warm) !important;
            border-color: var(--accent-warm) !important;
        }

        .btn-outline-primary:hover {
            background-color: var(--accent-warm) !important;
            color: white !important;
        }

        .text-secondary {
            color: var(--secondary-color) !important;
        }

        .bg-secondary {
            background-color: var(--secondary-color) !important;
        }

        .text-info {
            color: var(--secondary-color) !important;
        }

        .bg-info {
            background-color: var(--secondary-color) !important;
        }

        .text-warning {
            color: var(--accent-warm) !important;
        }

        .bg-warning {
            background-color: var(--accent-warm) !important;
        }

        .text-success {
            color: var(--primary-color) !important;
        }

        .bg-success {
            background-color: var(--primary-color) !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            background-color: white;
            overflow-x: hidden;
        }

        h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
        }

        h2,
        h3,
        h4,
        h5,
        h6,
        .display-1,
        .display-2,
        .display-3,
        .display-4,
        .navbar-brand {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        /* Navbar */
        .navbar {
            backdrop-filter: blur(20px);
            background-color: rgba(255, 255, 255, 0.85) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-main) !important;
            margin: 0 10px;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: var(--accent-warm);
            transition: all 0.3s;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .navbar-toggler {
            border: none;
            border-radius: var(--btn-radius);
            padding: 0.5rem 0.75rem;
            background-color: transparent;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: 2px solid var(--primary-color);
        }

        /* Language Switcher */
        .nav-lang-btn {
            border: 1px solid rgba(10, 37, 64, 0.1);
            background: transparent;
            color: var(--primary-color);
            font-weight: 700;
            padding: 8px 16px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-lang-btn:hover,
        .nav-lang-btn[aria-expanded="true"] {
            background-color: var(--accent-warm) !important;
            color: #ffffff !important;
            border-color: var(--accent-warm) !important;
            transform: translateY(-1px);
        }

        .dropdown-menu-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 8px;
            margin-top: 12px !important;
        }

        .dropdown-item-custom {
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 600;
            color: var(--text-main);
            transition: all 0.2s;
        }

        .dropdown-item-custom:hover,
        .dropdown-item-custom:active {
            background-color: var(--bg-soft);
            color: var(--primary-color);
        }

        /* Helpers */
        .ls-1 {
            letter-spacing: 1px;
        }

        .article-header {
            background-color: var(--bg-soft);
            padding: 80px 0;
            text-align: center;
        }

        .article-img {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin-top: -60px;
            margin-bottom: 40px;
        }

        .article-content {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-main);
        }
    </style>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;800&family=Plus+Jakarta+Sans:wght@400;600&display=swap"
        rel="stylesheet">
    <!-- Schema Markup -->
    {!! $schema !!}
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('img/lmc.png') }}" alt="Legian Medical Clinic" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#hero') }}">{{ __('Home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#about') }}">{{ __('About') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#services') }}">{{ __('Services') }}</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#doctors') }}">{{ __('Doctors') }}</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('articles.index') }}">{{ __('Articles') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#contact') }}">{{ __('Contact') }}</a></li>

                    <!-- Search Trigger -->
                    <li class="nav-item ms-lg-2">
                        <button class="btn btn-sm btn-link nav-link text-decoration-none" onclick="toggleNavbarSearch()"
                            type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </li>

                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <div class="dropdown">
                            <button class="btn btn-sm nav-lang-btn rounded-pill" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-translate fs-5"></i>
                                <span id="current-lang-label" class="ls-1">{{ strtoupper(app()->getLocale()) }}</span>
                                <i class="bi bi-chevron-down ms-1" style="font-size: 0.7rem; opacity: 0.7;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom animate-up">
                                <li>
                                    <a class="dropdown-item dropdown-item-custom d-flex align-items-center justify-content-between"
                                        href="{{ route('lang.switch', 'en') }}">
                                        <span>English</span>
                                        @if(app()->getLocale() == 'en') <i
                                        class="bi bi-check-circle-fill text-success fs-6"></i> @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-item-custom d-flex align-items-center justify-content-between"
                                        href="{{ route('lang.switch', 'id') }}">
                                        <span>Indonesia</span>
                                        @if(app()->getLocale() == 'id') <i
                                        class="bi bi-check-circle-fill text-success fs-6"></i> @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Navbar Search Bar Overlay -->
        <div id="navbar-search-bar" class="w-100 bg-white border-top py-2 d-none position-absolute start-0"
            style="top: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div class="container">
                <form action="{{ route('articles.index') }}" method="GET" class="d-flex align-items-center">
                    <i class="bi bi-search text-muted me-2"></i>
                    <input type="text" name="q" id="nav-search-input"
                        class="form-control border-0 bg-transparent shadow-none"
                        placeholder="{{ __('Search articles...') }}" autocomplete="off" value="{{ request('q') }}">
                    <button type="button" class="btn-close ms-2" onclick="toggleNavbarSearch()"></button>
                </form>
            </div>
        </div>
    </nav>

    <script>
        function toggleNavbarSearch() {
            const searchBar = document.getElementById('navbar-search-bar');
            const input = document.getElementById('nav-search-input');

            if (searchBar.classList.contains('d-none')) {
                searchBar.classList.remove('d-none');
                searchBar.classList.add('animate-up'); // Add animation class
                setTimeout(() => input.focus(), 100);
            } else {
                searchBar.classList.add('d-none');
            }
        }
    </script>

    <header class="article-header">
        <div class="container">
            <span class="badge bg-primary rounded-pill mb-3 px-3 py-2">{{ $article->date }}</span>
            <h1 class="display-4 fw-bold text-dark mb-0">{{ $article->title }}</h1>
        </div>
    </header>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : asset('storage/' . $article->image) }}"
                    alt="{{ $article->title }}" class="img-fluid article-img w-100 object-fit-cover"
                    style="height: 400px; object-fit: cover;">
            </div>
        </div>

        <div class="article-content">
            <p class="lead fw-bold mb-4">{{ $article->excerpt }}</p>

            <div class="article-body">
                {!! $article->processed_content !!}
            </div>
        </div>
    </div>

    @if(isset($isHighBounce) && $isHighBounce && isset($relatedArticles) && count($relatedArticles) > 0)
        <!-- Exit Rate Optimizer Widget -->
        <div class="container mt-5">
            <div class="p-5 bg-light rounded-4 position-relative overflow-hidden shadow-sm">
                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-50" style="background: var(--bg-soft);">
                </div>
                <div class="position-relative z-1">
                    <div class="text-center mb-4">
                        <span class="badge bg-warning text-dark mb-2 px-3 py-2 rounded-pill fw-bold">Recommended for
                            You</span>
                        <h3 class="fw-bold text-dark">{{ __('Before you go, check these out!') }}</h3>
                        <p class="text-muted">{{ __('Based on what others are reading right now.') }}</p>
                    </div>

                    <div class="row g-4">
                        @foreach($relatedArticles as $rel)
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                    <img src="{{ Str::startsWith($rel->image, 'http') ? $rel->image : asset('storage/' . $rel->image) }}"
                                        class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $rel->title }}">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2">{{ Str::limit($rel->title, 40) }}</h6>
                                        <a href="{{ route('articles.show', $rel->id) }}"
                                            class="stretched-link btn btn-sm btn-outline-primary rounded-pill">{{ __('Read Article') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container pb-5">

        <!-- Minimal Footer -->
        <!-- Footer -->
        <footer class="bg-dark text-white pt-5 pb-4 mt-5" style="background-color: var(--dark-blue) !important;">
            <div class="container">
                <div class="row g-5">
                    <div class="col-12 text-center">
                        <img src="{{ asset('img/lmc.png') }}" alt="Logo" class="mb-4"
                            style="height: 60px; filter: brightness(0) invert(1);">
                        <p class="text-white-50 mb-4" style="max-width: 600px; margin: 0 auto;">We are committed to
                            providing the best medical service with a personal
                            touch. Your health is our priority.</p>
                        <p class="text-white-50 small mt-4">&copy; 2024 Legian Medical Clinic. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

</body>

</html>