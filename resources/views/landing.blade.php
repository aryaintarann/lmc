<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Legian Medical Clinic</title>
    <link rel="icon" href="img/lmc.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Palette: LMC Brand (Dark Navy & Gold/White) */
            --primary-gradient: linear-gradient(135deg, #0a2540 0%, #1c4966 100%);
            --primary-color: #0a2540;
            --secondary-color: #1c4966;
            --accent-warm: #c5a059;
            /* Gold/Bronze accent often found in medical logos */
            --dark-blue: #051626;
            /* Even darker for contrast */
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

        /* Hero */
        .hero-section {
            position: relative;
            padding: 120px 0 100px;
            background: white;
            overflow: hidden;
        }

        .hero-bg-blob {
            position: absolute;
            top: -20%;
            right: -10%;
            width: 60%;
            height: 120%;
            background: linear-gradient(120deg, rgba(13, 110, 253, 0.08), rgba(13, 202, 240, 0.1));
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            z-index: 0;
            animation: float 6s ease-in-out infinite;
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
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.1), rgba(13, 202, 240, 0.1));
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
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
            transition: all 0.3s;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
            color: white;
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
            box-shadow: 0 8px 25px rgba(10, 37, 64, 0.4);
            color: white;
            background: #153a5b;
        }

        /* Modal */
        .modal-content {
            border: none;
            border-radius: 24px;
            overflow: hidden;
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

        .choice-btn {
            padding: 1rem;
            border-radius: var(--btn-radius);
            border: 2px solid #e9ecef;
            color: var(--text-main);
            font-weight: 600;
            text-align: left;
            transition: 0.2s;
        }

        .choice-btn:hover,
        .choice-btn.active {
            border-color: var(--primary-color);
            background-color: var(--bg-soft);
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
    </style>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <!-- Questionnaire Modal -->
    <div class="modal fade" id="questionnaireModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Welcome to Legian Medical Clinic</h5>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4">
                        <img src="img/lmc.png" class="mb-3" alt="Logo" style="height: 80px;">
                        <h4 class="fw-bold text-dark">How can we help you today?</h4>
                        <p class="text-muted">Select an option to personalize your experience.</p>
                    </div>
                    <div class="d-grid gap-3">
                        <button
                            class="btn btn-outline-light choice-btn d-flex align-items-center justify-content-between p-3"
                            data-target="services">
                            <span class="d-flex align-items-center gap-3">
                                <i class="bi bi-bandaid text-primary fs-4"></i>
                                <span class="text-dark fw-semibold">Check Services</span>
                            </span>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </button>
                        <button
                            class="btn btn-outline-light choice-btn d-flex align-items-center justify-content-between p-3"
                            data-target="doctors">
                            <span class="d-flex align-items-center gap-3">
                                <i class="bi bi-people text-primary fs-4"></i>
                                <span class="text-dark fw-semibold">Find a Doctor</span>
                            </span>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </button>
                        <button
                            class="btn btn-outline-light choice-btn d-flex align-items-center justify-content-between p-3"
                            data-target="contact">
                            <span class="d-flex align-items-center gap-3">
                                <i class="bi bi-calendar-check text-primary fs-4"></i>
                                <span class="text-dark fw-semibold">Book Appointment</span>
                            </span>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </button>
                        <button
                            class="btn btn-outline-light choice-btn d-flex align-items-center justify-content-between p-3"
                            data-target="all">
                            <span class="d-flex align-items-center gap-3">
                                <i class="bi bi-grid text-primary fs-4"></i>
                                <span class="text-dark fw-semibold">See Everything</span>
                            </span>
                            <i class="bi bi-chevron-right text-muted"></i>
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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#doctors">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <!-- Hero Section -->
    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="hero-bg-blob"></div>
        <div class="container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-6 text-start animate-up">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill shadow-sm fw-bold">
                        {{ $settings['header_badge'] ?? 'Welcome to Legian Medical Clinic' }}
                    </span>
                    <h1 class="display-3 fw-bolder mb-3 text-dark">
                        {{ $settings['header_title'] ?? 'Your Health, Our Top Priority' }}
                    </h1>
                    <p class="lead text-muted mb-4">
                        {{ $settings['header_subtitle'] ?? 'Experience world-class healthcare with a personal touch.' }}
                    </p>
                    <div class="d-flex gap-3">
                        @php
                            $btnLink = $settings['header_btn_link'] ?? '#contact';
                            if (!Str::startsWith($btnLink, ['http://', 'https://', '#', '/'])) {
                                $btnLink = 'https://' . $btnLink;
                            }
                        @endphp
                        <a href="{{ $btnLink }}" class="btn btn-gradient btn-lg">
                            {{ $settings['header_btn_text'] ?? 'Book Appointment' }}
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#services" class="btn btn-dark-blue btn-lg">Our Services</a>
                    </div>
                    <div class="mt-5 d-flex gap-4">
                        <div class="d-flex align-items-center">
                            <h2 class="fw-bold mb-0 text-dark">10+</h2>
                            <p class="mb-0 ms-2 text-muted small lh-1">Years of<br>Service</p>
                        </div>
                        <div class="border-start border-2"></div>
                        <div class="d-flex align-items-center">
                            <h2 class="fw-bold mb-0 text-dark">24/7</h2>
                            <p class="mb-0 ms-2 text-muted small lh-1">Emergency<br>Support</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 animate-up delay-200">
                    <div class="position-relative">
                        @if(isset($settings['header_image']))
                            <img src="{{ asset('storage/' . $settings['header_image']) }}"
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
                                    <h6 class="mb-0 fw-bold">Certified Clinic</h6>
                                    <small class="text-muted">ISO 9001 Approved</small>
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
                <span class="section-subtitle">Comprehensive Care</span>
                <h2 class="section-title">Our Services</h2>
                <p class="text-muted" style="max-width: 600px; margin: 0 auto;">We provide a wide range of medical
                    services to ensure your health and well-being are always covered.</p>
            </div>
            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-md-4">
                        <div class="card service-card h-100">
                            <div class="card-body text-center">
                                <div class="icon-box">
                                    <i class="{{ $service->icon }} fs-3 text-primary"></i>
                                </div>
                                <div class="card-title fw-bold h5">{!! $service->title !!}</div>
                                <div class="card-text text-muted">{!! $service->description !!}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Doctors Section -->
        <section id="doctors" class="section-block position-relative">
            <div class="text-center mb-5">
                <span class="section-subtitle">Our Team</span>
                <h2 class="section-title">Meet Our Specialists</h2>
                <p class="text-muted">Expert doctors dedicated to your well-being</p>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($doctors as $doctor)
                    <div class="col-md-6 col-lg-5">
                        <div class="card service-card border-0 p-4 d-flex flex-row align-items-center">
                            @if($doctor->image)
                                <img src="{{ $doctor->image }}" class="rounded-circle shadow-sm me-4" alt="{{ $doctor->name }}"
                                    style="width: 80px; height: 80px; object-fit: cover;">
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
                    <img src="https://placehold.co/600x400" class="img-fluid rounded-4 shadow-lg" alt="Clinic Interior"
                        style="border-radius: var(--card-radius);">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title text-primary">{{ $settings['about_title'] ?? 'About Us' }}</h2>
                    <h4 class="mb-3 fw-bold">{{ $settings['site_name'] ?? 'Legian Medical Clinic' }}</h4>
                    <p class="text-muted lead mb-4">
                        {{ $settings['about_description'] ?? 'Legian Medical Clinic has been a pillar of health in the community.' }}
                    </p>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Experienced Medical
                            Professionals</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Advanced Medical
                            Technology</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Comfortable and Safe
                            Environment</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-5 section-block" style="background-color: var(--bg-light);">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-subtitle">Get in Touch</span>
                    <h2 class="section-title">Contact Us</h2>
                    <p class="text-muted">We are here to assist you. Reach out to us anytime.</p>
                </div>
                <div class="row g-4 align-items-stretch">
                    <!-- Contact Info Card -->
                    <div class="col-lg-5">
                        <div class="card bg-dark text-white border-0 h-100 p-4"
                            style="background: var(--dark-blue)!important; border-radius: var(--card-radius);">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h3 class="fw-bold mb-4">Contact Information</h3>
                                    <p class="mb-4 text-white-50">Reach out to us directly or visit our clinic.</p>

                                    <div class="d-flex align-items-center mb-4">
                                        <div class="d-flex align-items-center justify-content-center bg-white bg-opacity-10 text-white rounded-circle me-3"
                                            style="width: 50px; height: 50px; min-width: 50px; font-size: 1.2rem;">
                                            <i class="bi bi-telephone-fill"></i>
                                        </div>
                                        <div>
                                            <small class="text-white-50 d-block">Phone</small>
                                            <span
                                                class="fw-semibold">{{ $settings['contact_phone'] ?? '+62 361 755 123' }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-4">
                                        <div class="d-flex align-items-center justify-content-center bg-white bg-opacity-10 text-white rounded-circle me-3"
                                            style="width: 50px; height: 50px; min-width: 50px; font-size: 1.2rem;">
                                            <i class="bi bi-envelope-fill"></i>
                                        </div>
                                        <div>
                                            <small class="text-white-50 d-block">Email</small>
                                            <span class="fw-semibold">{{ $settings['contact_email'] ??
                                                'info@legianclinic.com' }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-4">
                                        <div class="d-flex align-items-center justify-content-center bg-white bg-opacity-10 text-white rounded-circle me-3"
                                            style="width: 50px; height: 50px; min-width: 50px; font-size: 1.2rem;">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </div>
                                        <div>
                                            <small class="text-white-50 d-block">Location</small>
                                            <span
                                                class="fw-semibold">{{ $settings['contact_address'] ?? 'Jln. Legian No. 123, Bali' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="d-flex gap-3">
                                        <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                                        <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Google Maps Card (Right) -->
                    <div class="col-lg-7">
                        <div class="card border-0 h-100 overflow-hidden shadow-sm"
                            style="border-radius: var(--card-radius);">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.2057973752674!2d115.17112997575233!3d-8.671913391856384!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd246d8995a5c6d%3A0xe7a4c7e3f7960fc5!2sLegian%2C%20Kuta%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1709476543210!5m2!1sen!2sid"
                                width="100%" height="100%" style="border:0; min-height: 400px;" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
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
                <span class="section-subtitle">Health Insights</span>
                <h2 class="section-title">Latest Articles</h2>
                <p class="text-muted">Stay informed with our latest health tips and news.</p>
            </div>
            <div class="row g-4">
                @foreach($landingArticles as $article)
                    <div class="col-md-4">
                        <div class="article-card">
                            <div class="article-img-wrapper">
                                <img src="{{ $article->image }}" alt="{{ $article->title }}">
                            </div>
                            <div class="card-body p-4">
                                <span class="article-date">{{ $article->date }}</span>
                                <h5 class="fw-bold mb-3">{{ $article->title }}</h5>
                                <p class="text-muted mb-4">{{ $article->excerpt }}</p>
                                <a href="{{ route('articles.show', $article->id) }}"
                                    class="article-link stretched-link">Read More <i class="bi bi-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(isset($totalArticles) && $totalArticles > 3)
                <div class="text-center mt-5">
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-primary rounded-pill px-5 py-3 fw-bold">
                        More Articles <i class="bi bi-arrow-right ms-2"></i>
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
                    <p class="text-white-50 mb-4" style="max-width: 600px; margin: 0 auto;">We are committed to
                        providing the best medical service with a personal
                        touch. Your health is our priority.</p>
                    <p class="text-white-50 small mt-4">&copy; 2024 Legian Medical Clinic. All Rights Reserved.</p>
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
            localStorage.clear();

            // Always show modal on refresh
            modal.show();

            // Handle choice buttons
            document.querySelectorAll('.choice-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');

                    // Optimistic UI update
                    reorderSections(targetId);
                    modal.hide();

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
                        .then(data => console.log('Preference saved:', data))
                        .catch(error => console.error('Error:', error));
                });
            });

            function reorderSections(topSectionId) {
                if (topSectionId === 'all') return; // Do nothing for 'all', just show default layout

                const section = document.getElementById(topSectionId);
                const heroSection = document.getElementById('hero');
                const dynamicContent = document.getElementById('dynamic-content');

                if (section && heroSection) {
                    // Move the selected section to BEFORE the hero section (as requested "diatas header")
                    // We target the parent of hero (which is body) and insert before hero
                    heroSection.parentNode.insertBefore(section, heroSection);

                    // Smooth scroll to it
                    section.scrollIntoView({ behavior: 'smooth' });
                } else if (section && !heroSection) {
                    // Fallback if hero is missing, prepend to dynamic content
                    dynamicContent.prepend(section);
                    section.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    </script>
</body>

</html>