<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Legian Medical Clinic</title>
    <meta name="description" content="{{ $header && isset($header->tagline) ? ($header->tagline[app()->getLocale()] ?? $header->tagline['id'] ?? 'Premier medical clinic in Bali.') : 'Premier medical clinic in Bali.' }}">
    <link rel="icon" href="img/lmc.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Palette: LMC Brand (Forest Green & Gold/White) */
            --primary-gradient: linear-gradient(135deg, #2E4D36 0%, #1A2E22 100%);
            --primary-color: #2E4D36;
            --secondary-color: #1A2E22;
            --accent-warm: #C5A059;
            /* Gold/Bronze accent */
            --dark-blue: #1A2E22;
            /* Very Dark Green for contrast */
            --text-main: #2E4D36;
            --text-muted: #7b809a;
            --bg-soft: #F8F9FA;
            --card-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05);
            --card-hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            --card-radius: 20px;
            --btn-radius: 50px;
        }

        /* Bootstrap Overrides */
        .text-primary, .link-primary {
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
            background-color: #a38446 !important; /* Darker Gold */
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
        .text-info { color: var(--secondary-color) !important; }
        .bg-info { background-color: var(--secondary-color) !important; }
        .text-warning { color: var(--accent-warm) !important; }
        .bg-warning { background-color: var(--accent-warm) !important; }
        .text-success { color: var(--primary-color) !important; }
        .bg-success { background-color: var(--primary-color) !important; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
        }

        h2, h3, h4, h5, h6, .display-1, .display-2, .display-3, .display-4, .navbar-brand {
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

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
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

        /* Hero */
        /* Hero */
        .hero-section {
            position: relative;
            padding: 100px 0 60px; /* Default for mobile */
            background: linear-gradient(180deg, rgba(240, 247, 255, 0.7) 0%, #ffffff 100%);
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .hero-section {
                padding: 140px 0 100px; /* Desktop padding */
            }
        }

        .hero-bg-blob {
            position: absolute;
            top: -15%;
            right: -10%;
            width: 55%;
            height: 110%;
            background: linear-gradient(135deg, rgba(46, 77, 54, 0.15), rgba(26, 46, 34, 0.2));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            z-index: 0;
            filter: blur(40px);
            animation: float 8s ease-in-out infinite;
        }

        .hero-bg-blob-2 {
            position: absolute;
            bottom: -10%;
            left: -10%;
            width: 45%;
            height: 90%;
            background: linear-gradient(135deg, rgba(197, 160, 89, 0.05), rgba(46, 77, 54, 0.08));
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            z-index: 0;
            filter: blur(50px);
            animation: float 10s ease-in-out infinite reverse;
        }

        .text-gradient-main {
            background: linear-gradient(90deg, #2E4D36 0%, #1A2E22 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Cards & Sections */
        .section-block {
            padding: 100px 0;
            position: relative;
        }

        .bg-soft {
            background-color: var(--bg-soft);
        }

        .section-title {
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--dark-blue);
            font-size: 2.5rem;
        }

        .section-subtitle {
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
            font-size: 0.85rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .service-card {
            border: none;
            border-radius: var(--card-radius);
            padding: 2.5rem 2rem;
            background: white;
            box-shadow: var(--card-shadow);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .service-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: var(--primary-gradient);
            transition: 0.4s ease;
            z-index: -1;
            border-radius: var(--card-radius);
            opacity: 0.05;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--card-hover-shadow);
        }

        .service-card:hover::before {
            height: 100%;
            opacity: 1;
        }

        .service-card:hover h5,
        .service-card:hover .card-title,
        .service-card:hover p,
        .service-card:hover i {
            color: white !important;
        }

        .service-card:hover .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .service-card:hover .icon-box {
            background: rgba(255, 255, 255, 0.2);
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(46, 77, 54, 0.1), rgba(197, 160, 89, 0.1));
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            color: var(--primary-color);
            transition: 0.4s;
        }

        /* Buttons */
        .btn {
            border-radius: var(--btn-radius);
        }

        .btn-gradient {
            background: linear-gradient(90deg, #C5A059 0%, #D4AF37 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(197, 160, 89, 0.4);
            transition: all 0.3s;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(197, 160, 89, 0.6);
            color: white;
            background: linear-gradient(90deg, #B39048 0%, #C5A059 100%);
        }

        .btn-dark-blue {
            background: var(--dark-blue);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(10, 37, 64, 0.3);
            font-weight: 600;
            padding: 12px 30px;
            transition: all 0.3s;
        }

        .btn-dark-blue:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 46, 34, 0.4);
            color: white;
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Modal */
        .modal-content {
            border: none;
            border-radius: 24px;
            overflow: hidden;
        }

        .modal {
            z-index: 1060; /* Ensure it's above everything including navbar */
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            border: none;
        }

        .modal-body {
            padding: 3rem 2rem;
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
            transition: margin 0.3s;
        }

        .article-link:hover {
            color: var(--secondary-color);
        }

        .article-link:hover i {
            margin-left: 8px !important;
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

        /* Contact Card */
        .contact-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .contact-card:hover {
            transform: translateY(-10px) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2) !important;
            z-index: 10;
            position: relative;
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

        /* Questionnaire Modal & Buttons */
        .choice-btn {
            background: white;
            padding: 1.25rem;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            color: var(--text-main);
            font-weight: 600;
            text-align: left;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            margin-bottom: 0; /* Override default */
        }

        .choice-btn:hover,
        .choice-btn.active {
            border-color: var(--primary-color);
            background-color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(10, 37, 64, 0.08);
            color: var(--primary-color);
        }

        .choice-btn i.bi-chevron-right {
            opacity: 0.3;
            transition: opacity 0.3s, transform 0.3s;
        }

        .choice-btn:hover i.bi-chevron-right {
            opacity: 1;
            transform: translateX(3px);
            color: var(--primary-color);
        }

        /* Helpers */
        .ls-1 {
            letter-spacing: 1px;
        }

        .hover-white {
            transition: color 0.2s;
        }

        .hover-white:hover {
            color: white !important;
        }

        /* Gallery Section */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .gallery-item img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(26, 46, 34, 0.8), transparent);
            padding: 2rem 1.5rem 1.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-carousel .carousel-control-prev,
        .gallery-carousel .carousel-control-next {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            opacity: 1;
            top: 50%;
            transform: translateY(-50%);
            position: absolute;
        }

        .gallery-carousel .carousel-control-prev {
            left: -70px;
        }

        .gallery-carousel .carousel-control-next {
            right: -70px;
        }

        .gallery-carousel .carousel-control-prev-icon,
        .gallery-carousel .carousel-control-next-icon {
            filter: invert(1) grayscale(100) brightness(0.2);
            width: 20px;
            height: 20px;
        }

        .gallery-carousel .carousel-control-prev:hover,
        .gallery-carousel .carousel-control-next:hover {
            background: var(--accent-warm);
        }

        .gallery-carousel .carousel-control-prev:hover .carousel-control-prev-icon,
        .gallery-carousel .carousel-control-next:hover .carousel-control-next-icon {
            filter: invert(1) grayscale(100) brightness(1);
        }

        .gallery-carousel .carousel-indicators {
            bottom: -50px;
        }

        .gallery-carousel .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary-color);
            opacity: 0.3;
            border: none;
        }

        .gallery-carousel .carousel-indicators button.active {
            opacity: 1;
            background-color: var(--accent-warm);
        }

        @media (max-width: 768px) {
            .gallery-carousel .carousel-control-prev,
            .gallery-carousel .carousel-control-next {
                display: none;
            }

            .gallery-item img {
                height: 220px;
            }
        }
    </style>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;800&family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
    <!-- Schema Markup -->
    {!! $schema !!}
</head>

<body>

    <!-- Questionnaire Modal -->
    <div class="modal fade" id="questionnaireModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 p-0">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- ... (Modal content will be wrapped in next steps) ... -->
                <div class="modal-body p-3 p-md-5 bg-soft">
                    <div class="text-center mb-5">
                        <div class="bg-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <img src="img/lmc.png" alt="Logo" style="height: 50px;">
                        </div>
                        <h4 class="fw-bold text-dark mb-2">{{ __('How can we help you today?') }}</h4>
                        <p class="text-muted mb-0 small text-uppercase ls-1 fw-bold">{{ __('Select to personalize your experience') }}</p>
                    </div>

                    <div class="d-grid gap-3" style="max-width: 450px; margin: 0 auto;">
                        <button class="btn choice-btn d-flex align-items-center justify-content-between" data-target="services">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                                    <i class="bi bi-bandaid fs-4"></i>
                                </div>
                                <div>
                                    <span class="d-block text-dark fw-bold">{{ __('Check Services') }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ __('View our medical treatments') }}</small>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </button>

                        <button class="btn choice-btn d-flex align-items-center justify-content-between" data-target="doctors">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                                    <i class="bi bi-people fs-4"></i>
                                </div>
                                <div>
                                    <span class="d-block text-dark fw-bold">{{ __('Find a Doctor') }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ __('Meet our specialists') }}</small>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </button>

                        <button class="btn choice-btn d-flex align-items-center justify-content-between" data-target="contact">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                                    <i class="bi bi-calendar-check fs-4"></i>
                                </div>
                                <div>
                                    <span class="d-block text-dark fw-bold">{{ __('Book Appointment') }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ __('Schedule your visit') }}</small>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </button>

                        <button class="btn choice-btn d-flex align-items-center justify-content-between" data-target="all">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                                    <i class="bi bi-grid fs-4"></i>
                                </div>
                                <div>
                                    <span class="d-block text-dark fw-bold">{{ __('See Everything') }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ __('Browse full website') }}</small>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="#">
                <img src="img/lmc.png" alt="Legian Medical Clinic" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#hero">{{ __('Home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">{{ __('About') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">{{ __('Gallery') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">{{ __('Services') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#doctors">{{ __('Doctors') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('articles.index') }}">{{ __('Articles') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">{{ __('Contact') }}</a></li>
                </ul>
                
                <!-- Right side: Search & Language -->
                <ul class="navbar-nav align-items-center">
                    <!-- Search Trigger -->
                    <li class="nav-item">
                        <button class="btn btn-sm btn-link nav-link text-decoration-none" onclick="toggleNavbarSearch()" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </li>

                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <div class="dropdown">
                            <button class="btn btn-sm nav-lang-btn rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-translate fs-5"></i>
                                <span id="current-lang-label" class="ls-1">{{ strtoupper(app()->getLocale()) }}</span>
                                <i class="bi bi-chevron-down ms-1" style="font-size: 0.7rem; opacity: 0.7;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom animate-up">
                                <li>
                                    <a class="dropdown-item dropdown-item-custom d-flex align-items-center justify-content-between" href="{{ route('lang.switch', 'en') }}">
                                        <span>English</span>
                                        @if(app()->getLocale() == 'en') <i class="bi bi-check-circle-fill text-success fs-6"></i> @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-item-custom d-flex align-items-center justify-content-between" href="{{ route('lang.switch', 'id') }}">
                                        <span>Indonesia</span>
                                        @if(app()->getLocale() == 'id') <i class="bi bi-check-circle-fill text-success fs-6"></i> @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Navbar Search Bar Overlay -->
        <div id="navbar-search-bar" class="w-100 bg-white border-top py-2 d-none position-absolute start-0" style="top: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div class="container">
                <form action="{{ route('articles.index') }}" method="GET" class="d-flex align-items-center">
                    <i class="bi bi-search text-muted me-2"></i>
                    <input type="text" name="q" id="nav-search-input" class="form-control border-0 bg-transparent shadow-none" placeholder="{{ __('Search articles...') }}" autocomplete="off">
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


    <!-- Hero Section -->
    <!-- Hero Section -->
    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="hero-bg-blob"></div>
        <div class="hero-bg-blob-2"></div>
        <div class="container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start animate-up">
                    <h1 class="display-3 fw-bolder mb-3 text-gradient-main" style="line-height: 1.2;">
                        @php
                            $locale = app()->getLocale();
                            $title = $header && isset($header->title) ? ($header->title[$locale] ?? $header->title['id'] ?? '') : __('Your Health, Our Top Priority');
                        @endphp
                        {{ $title }}
                    </h1>
                    <p class="lead text-muted mb-4">
                        @php
                            $tagline = $header && isset($header->tagline) ? ($header->tagline[$locale] ?? $header->tagline['id'] ?? '') : __('Experience world-class healthcare with a personal touch.');
                        @endphp
                        {{ $tagline }}
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-lg-start">
                        @php
                            $buttonText = $header && isset($header->button_text) ? ($header->button_text[$locale] ?? $header->button_text['id'] ?? '') : __('Book Appointment');
                            $buttonUrl = $header && isset($header->button_url) ? $header->button_url : '#contact';
                            
                            // Check if URL is not an anchor link and doesn't have http/https
                            if ($buttonUrl && !Str::startsWith($buttonUrl, ['http://', 'https://', '#'])) {
                                $buttonUrl = 'https://' . $buttonUrl;
                            }
                        @endphp
                        <a href="{{ $buttonUrl }}" class="btn btn-gradient btn-lg">
                            {{ $buttonText }}
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#services" class="btn btn-dark-blue btn-lg width-full-mobile">{{ __('Our Services') }}</a>
                    </div>
                    
                    <style>
                        @media (max-width: 768px) {
                            .width-full-mobile {
                                width: 100%;
                            }
                        }
                    </style>
<<<<<<< HEAD

=======
>>>>>>> 684281805be73869ed436c9b34e12dea9ea543ef
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 animate-up delay-200">
                    <div class="position-relative">
                        @if($header && $header->logo)
                            <img src="{{ asset('storage/' . $header->logo) }}"
                                class="img-fluid rounded-4 shadow-lg position-relative z-2" alt="Medical Team"
                                style="border-radius: 30px;">
                        @else
                            <img src="https://placehold.co/600x600?text=Doctors+Team"
                                class="img-fluid rounded-4 shadow-lg position-relative z-2" alt="Medical Team"
                                style="border-radius: 30px;">
                        @endif
                        <!-- Floating Card -->
                        <div class="card position-absolute bottom-0 start-0 p-3 shadow border-0 z-3 rounded-4 mb-n4 ms-n4 d-none d-md-block"
                            style="max-width: 250px;">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle p-2 me-3 text-white">
                                    <i class="bi bi-shield-check-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ __('Trusted for Over 10 Years') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dynamic Container -->
    <div id="dynamic-content" class="container py-5">
        <!-- Sections will be reordered here -->

        <!-- Services Section -->
        <section id="services" class="section-block bg-soft position-relative overflow-hidden rounded-5 my-5 px-4">
            <!-- Decorative circle -->
            <div class="position-absolute top-0 start-0 translate-middle bg-white rounded-circle opacity-50"
                style="width: 300px; height: 300px; filter: blur(50px);"></div>

            <div class="text-center mb-5 position-relative z-1">
                <span class="section-subtitle">{{ __('Comprehensive Care') }}</span>
                <h2 class="section-title">{{ __('Our Services') }}</h2>
                <p class="text-muted" style="max-width: 600px; margin: 0 auto;">{{ __('We provide a wide range of medical services to ensure your health and well-being are always covered.') }}</p>
            </div>
            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-md-4">
                        <div class="card service-card h-100">
                            <div class="card-body text-center">
                                <div class="icon-box">
                                    <i class="{{ $service->icon }} fs-3 text-primary"></i>
                                </div>
                                <div class="card-title fw-bold h5">{{ $service->title }}</div>
                                <div class="card-text text-muted">{{ $service->description }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Doctors Section -->
        <section id="doctors" class="section-block position-relative">
            <div class="text-center mb-5">
                <span class="section-subtitle">{{ __('Our Team') }}</span>
                <h2 class="section-title">{{ __('Meet Our Specialists') }}</h2>
                <p class="text-muted">{{ __('Expert doctors dedicated to your well-being') }}</p>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($doctors as $doctor)
                    <div class="col-md-6 col-lg-5">
                        <div class="card service-card border-0 p-4 d-flex flex-row align-items-center">
                            @if($doctor->image)
                                @if(Str::startsWith($doctor->image, 'http'))
                                    <img src="{{ $doctor->image }}" class="rounded-circle shadow-sm me-4" alt="{{ $doctor->name }}"
                                        style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('storage/' . $doctor->image) }}" class="rounded-circle shadow-sm me-4" alt="{{ $doctor->name }}"
                                        style="width: 80px; height: 80px; object-fit: cover;">
                                @endif
                            @else
                                <div class="rounded-circle shadow-sm me-4 bg-light d-flex align-items-center justify-content-center text-primary fw-bold"
                                    style="width: 80px; height: 80px; font-size: 1.5rem;">
                                    {{ substr($doctor->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h5 class="fw-bold mb-1">{{ $doctor->name }}</h5>
                                <p class="text-primary mb-2 fw-medium">{{ $doctor->specialty }}</p>
                                <small class="text-muted">{{ $doctor->bio }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Facilities / About Section -->
        <section id="about" class="section-block">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    @if($about && $about->image)
                        <img src="{{ asset('storage/' . $about->image) }}" class="img-fluid rounded-4 shadow-lg" alt="About Clinic"
                            style="border-radius: var(--card-radius);">
                    @else
                        <img src="https://placehold.co/600x400" class="img-fluid rounded-4 shadow-lg" alt="Clinic Interior"
                            style="border-radius: var(--card-radius);">
                    @endif
                </div>
                <div class="col-lg-6 text-center text-lg-start">
                    @php
                        $locale = app()->getLocale();
                        $aboutTitle = $about && isset($about->title) ? ($about->title[$locale] ?? $about->title['id'] ?? '') : __('About Us');
                        $aboutDesc = $about && isset($about->description) ? ($about->description[$locale] ?? $about->description['id'] ?? '') : __('Legian Medical Clinic has been a pillar of health in the community.');
                    @endphp
                    <h2 class="section-title text-primary">{{ $aboutTitle }}</h2>
                    <p class="text-muted lead mb-4">
                        {{ $aboutDesc }}
                    </p>
                    @if($about && $about->vision && ($about->vision[$locale] ?? $about->vision['id'] ?? ''))
                        <h5 class="text-primary mb-2">{{ __('Vision') }}</h5>
                        <div class="text-muted mb-3">{!! $about->vision[$locale] ?? $about->vision['id'] ?? '' !!}</div>
                    @endif
                    @if($about && $about->mission && ($about->mission[$locale] ?? $about->mission['id'] ?? ''))
                        <h5 class="text-primary mb-2">{{ __('Mission') }}</h5>
                        <div class="text-muted mb-3">{!! $about->mission[$locale] ?? $about->mission['id'] ?? '' !!}</div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="section-block bg-soft rounded-5 my-5 px-4">
            <div class="text-center mb-5">
                <span class="section-subtitle">{{ __('Our Facilities') }}</span>
                <h2 class="section-title">{{ __('Gallery') }}</h2>
                <p class="text-muted" style="max-width: 600px; margin: 0 auto;">{{ __('Take a virtual tour of our modern clinic and facilities.') }}</p>
            </div>
            
            @if($galleries->count() > 0)
                @php
                    $galleryChunks = $galleries->chunk(3);
                @endphp
                <div class="position-relative" style="padding: 0 80px;">
                    <div id="galleryCarousel" class="carousel slide gallery-carousel" data-bs-ride="carousel">
                        <!-- Indicators -->
                        <div class="carousel-indicators">
                            @foreach($galleryChunks as $index => $chunk)
                                <button type="button" data-bs-target="#galleryCarousel" data-bs-slide-to="{{ $index }}" 
                                    class="{{ $index === 0 ? 'active' : '' }}" 
                                    {{ $index === 0 ? 'aria-current="true"' : '' }} 
                                    aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach($galleryChunks as $index => $chunk)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="row g-4">
                                        @foreach($chunk as $gallery)
                                            <div class="col-md-4">
                                                <div class="gallery-item">
                                                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}">
                                                    <div class="gallery-overlay">
                                                        <h6 class="text-white mb-0 fw-bold">{{ $gallery->title }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Navigation Arrows -->
                        @if($galleryChunks->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">{{ __('Previous') }}</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">{{ __('Next') }}</span>
                            </button>
                        @endif
                    </div>
                </div>
            @else
                <!-- Fallback: No gallery images in database -->
                <div class="text-center py-5">
                    <i class="bi bi-images text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">{{ __('Gallery images coming soon.') }}</p>
                </div>
            @endif
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-5 section-block" style="background-color: var(--bg-light);">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-subtitle">{{ __('Get in Touch') }}</span>
                    <h2 class="section-title">{{ __('Contact Us') }}</h2>
                    <p class="text-muted">{{ __('We are here to assist you. Reach out to us anytime.') }}</p>
                </div>
                <div class="row g-4 align-items-stretch">
                    <!-- Contact Info Card -->
                    <div class="col-lg-5">
                        <div class="card contact-card bg-dark text-white border-0 h-100 p-4"
                            style="background: var(--dark-blue)!important; border-radius: var(--card-radius);">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h3 class="fw-bold mb-4">{{ __('Contact Information') }}</h3>
                                    <p class="mb-4 text-white-50">{{ __('Reach out to us directly or visit our clinic.') }}</p>

                                    <div class="d-flex align-items-center mb-4">
                                        <div class="d-flex align-items-center justify-content-center bg-white bg-opacity-10 text-white rounded-circle me-3"
                                            style="width: 50px; height: 50px; min-width: 50px; font-size: 1.2rem;">
                                            <i class="bi bi-telephone-fill"></i>
                                        </div>
                                        <div>
                                            <small class="text-white-50 d-block">{{ __('Phone') }}</small>
                                            <span class="fw-semibold">{{ $contact->phone ?? '+62 361 755 123' }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-4">
                                        <div class="d-flex align-items-center justify-content-center bg-white bg-opacity-10 text-white rounded-circle me-3"
                                            style="width: 50px; height: 50px; min-width: 50px; font-size: 1.2rem;">
                                            <i class="bi bi-envelope-fill"></i>
                                        </div>
                                        <div>
                                            <small class="text-white-50 d-block">{{ __('Email') }}</small>
                                            <span class="fw-semibold">{{ $contact->email ?? 'info@legianclinic.com' }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-4">
                                        <div class="d-flex align-items-center justify-content-center bg-white bg-opacity-10 text-white rounded-circle me-3"
                                            style="width: 50px; height: 50px; min-width: 50px; font-size: 1.2rem;">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </div>
                                        <div>
                                            <small class="text-white-50 d-block">{{ __('Location') }}</small>
                                            @php
                                                $locale = app()->getLocale();
                                                $address = $contact && isset($contact->address) ? ($contact->address[$locale] ?? $contact->address['id'] ?? '') : 'Jln. Legian No. 123, Bali';
                                            @endphp
                                            <span class="fw-semibold">{{ $address }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="d-flex gap-3">
                                        @if($contact && $contact->facebook)
                                            <a href="{{ $contact->facebook }}" target="_blank" class="text-white fs-5 hover-white"><i class="bi bi-facebook"></i></a>
                                        @endif
                                        @if($contact && $contact->instagram)
                                            <a href="{{ $contact->instagram }}" target="_blank" class="text-white fs-5 hover-white"><i class="bi bi-instagram"></i></a>
                                        @endif
                                        @if($contact && $contact->whatsapp)
                                            <a href="https://wa.me/{{ str_replace([' ', '+', '-'], '', $contact->whatsapp) }}" target="_blank" class="text-white fs-5 hover-white"><i class="bi bi-whatsapp"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Google Maps Card (Right) -->
                    <div class="col-lg-7">
                        <div class="card border-0 h-100 overflow-hidden shadow-sm"
                            style="border-radius: var(--card-radius);">
                            @if($contact && $contact->maps_embed)
                                {!! $contact->maps_embed !!}
                            @else
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15773.66578051662!2d115.1764618!3d-8.7180415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd246b9a8ae1e5b%3A0xc3b821a3641031c5!2sLegian%20Area!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid"
                                    width="100%" height="100%" style="border:0; min-height: 400px;" allowfullscreen=""
                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <!-- Articles Section -->
    <section id="articles" class="section-block bg-soft">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle">{{ __('Health Insights') }}</span>
                <h2 class="section-title">{{ __('Latest Articles') }}</h2>
                <p class="text-muted">{{ __('Stay informed with our latest health tips and news.') }}</p>
            </div>
            <div class="row g-4">
                @foreach($landingArticles as $article)
                    <div class="col-md-4">
                        <div class="article-card position-relative">
                            <div class="article-img-wrapper">
                                <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                            </div>
                            <div class="card-body p-4">
                                <span class="article-date">{{ $article->date }}</span>
                                <h5 class="fw-bold mb-3">{{ $article->title }}</h5>
                                <p class="text-muted mb-4">{{ $article->excerpt }}</p>
                                <a href="{{ route('articles.show', $article->id) }}"
                                    class="article-link stretched-link">{{ __('Read More') }} <i class="bi bi-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(isset($totalArticles) && $totalArticles > 3)
                <div class="text-center mt-5">
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-primary rounded-pill px-5 py-3 fw-bold">
                        {{ __('More Articles') }} <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>
        </div>
    </section>

    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4" style="background-color: var(--dark-blue) !important;">
        <div class="container">
            <div class="row g-5">
                <div class="col-12 text-center">
                    <img src="img/lmc.png" alt="Logo" class="mb-4"
                        style="height: 60px; filter: brightness(0) invert(1);">
                    <p class="text-white-50 mb-4" style="max-width: 600px; margin: 0 auto;">{{ __('We are committed to providing the best medical service with a personal touch. Your health is our priority.') }}</p>
                    <p class="text-white-50 small mt-4">&copy; {{ date('Y') }} {{ __('Legian Medical Clinic. All Rights Reserved.') }}</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalElement = document.getElementById('questionnaireModal');
            const modal = new bootstrap.Modal(modalElement);
            const dynamicContent = document.getElementById('dynamic-content');

            // Reset state on load
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }
            window.scrollTo(0, 0);

            // Show modal on every refresh as requested
            modal.show();

            // Handle choice buttons
            document.querySelectorAll('.choice-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');

                    // Save preference
                    localStorage.setItem('lmc_user_preference', targetId);

                    // Optimistic UI update
                    modal.hide();
                    setTimeout(() => {
                        reorderSections(targetId);
                    }, 300);

                    // AJAX Request
                    fetch('{{ route("preferences.set") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ preference: targetId })
                    })
                        .then(response => response.json())
                        .catch(error => console.error('Error:', error));
                });
            });

            function reorderSections(topSectionId) {
                if (topSectionId === 'all') return; // Do nothing for 'all', just show default layout

                const section = document.getElementById(topSectionId);

                if (section) {
                    // Smooth scroll to the section
                    section.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });

        // Language Switch Handler with Auto-Translation
        document.addEventListener('click', function(e) {
            const langLink = e.target.closest('a[href*="lang/"]');
            if (langLink) {
                e.preventDefault();
                
                const href = langLink.getAttribute('href');
                const newLang = href.split('/').pop(); // Extract 'en' or 'id'
                const currentLang = '{{ app()->getLocale() }}';
                
                if (newLang === currentLang) {
                    return; // Same language, do nothing
                }
                
                // Determine source language (what admin entered)
                // By default, assume admin enters in Indonesian
                const sourceLang = 'id';
                const targetLang = newLang;
                

                
                // Redirect to change session language
                window.location.href = href;
            }
        });
    </script>
</body>

</html>