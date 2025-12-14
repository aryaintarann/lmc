<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Articles - Legian Medical Clinic</title>
    <link rel="icon" href="img/lmc.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Reuse styles from landing (in a real app, extract this to a layout file) -->
    <style>
        :root {
            /* Palette: LMC Brand (Dark Navy & Gold/White) */
            --primary-gradient: linear-gradient(135deg, #0a2540 0%, #1c4966 100%);
            --primary-color: #0a2540;
            --secondary-color: #1c4966;
            --accent-warm: #c5a059;
            --dark-blue: #051626;
            --text-main: #344767;
            --text-muted: #7b809a;
            --bg-soft: #f5f7fa;
            --card-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05);
            --card-hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            --card-radius: 20px;
            --btn-radius: 50px;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background-color: #f8f9fa;
            overflow-x: hidden;
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
            background: var(--primary-color);
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

        /* Article Cards */
        .article-card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
            height: 100%;
        }

        .article-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--card-hover-shadow);
        }

        .article-img-wrapper {
            overflow: hidden;
            height: 240px;
            position: relative;
        }

        .article-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .article-card:hover img {
            transform: scale(1.1);
        }

        .article-date {
            background: rgba(13, 110, 253, 0.1);
            color: var(--primary-color);
            padding: 6px 15px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.75rem;
            display: inline-block;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }

        .article-link {
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s;
        }

        .article-link i {
            margin-left: 5px;
            transition: margin 0.3s;
        }

        .article-link:hover i {
            margin-left: 10px;
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
            background: rgba(10, 37, 64, 0.05);
            color: var(--secondary-color);
            border-color: var(--secondary-color);
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
    </style>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-dark">{{ __('Health Insights') }}</h1>
            <p class="lead text-muted">{{ __('Explore our full collection of health articles and updates.') }}</p>
        </div>

        <div class="row g-4 justify-content-center mb-5">
            <div class="col-md-6">
                <form action="{{ route('articles.index') }}" method="GET"
                    class="d-flex shadow-sm rounded-pill bg-white p-1">
                    <input type="text" name="q" class="form-control border-0 rounded-pill ps-4"
                        placeholder="{{ __('Search health articles...') }}" value="{{ request('q') }}"
                        aria-label="Search">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>

        @if($articles->count() > 0)
            <div class="row g-4">
                @foreach($articles as $article)
                    <div class="col-lg-4 col-md-6">
                        <div class="article-card position-relative">
                            <div class="article-img-wrapper">
                                <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : asset('storage/' . $article->image) }}"
                                    alt="{{ $article->title }}">
                            </div>
                            <div class="card-body p-4">
                                <span class="article-date">{{ $article->date }}</span>
                                <h5 class="fw-bold mb-3">{{ $article->title }}</h5>
                                <p class="text-muted mb-4">{{ $article->excerpt }}</p>
                                <a href="{{ route('articles.show', $article->id) }}"
                                    class="article-link stretched-link">{{ __('Read More') }} <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-search fs-1 text-muted opacity-25" style="font-size: 4rem !important;"></i>
                </div>
                <h4 class="fw-bold text-muted">{{ __('No articles found') }}</h4>
                <p class="text-muted">{{ __('Try searching for something else or browse all articles.') }}</p>
                @if(request('q'))
                    <a href="{{ route('articles.index') }}"
                        class="btn btn-outline-primary rounded-pill mt-3">{{ __('Clear Search') }}</a>
                @endif
            </div>
        @endif
    </div>

    <!-- Minimal Footer -->
    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4 mt-5" style="background-color: var(--dark-blue) !important;">
        <div class="container">
            <div class="row g-5">
                <div class="col-12 text-center">
                    <img src="{{ asset('img/lmc.png') }}" alt="Logo" class="mb-4"
                        style="height: 60px; filter: brightness(0) invert(1);">
                    <p class="text-white-50 mb-4" style="max-width: 600px; margin: 0 auto;">
                        {{ __('We are committed to providing the best medical service with a personal touch. Your health is our priority.') }}
                    </p>
                    <p class="text-white-50 small mt-4">&copy; {{ date('Y') }}
                        {{ __('Legian Medical Clinic. All Rights Reserved.') }}
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>