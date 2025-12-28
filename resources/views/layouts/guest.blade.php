<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Legian Medical Clinic') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #2E4D36 0%, #1A2E22 100%);
            --primary-color: #2E4D36;
            --secondary-color: #1A2E22;
            --accent-warm: #C5A059;
            --bg-soft: #f5f7fa;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-soft);
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }

        .bg-navy {
            background: var(--primary-gradient);
        }

        .text-gold {
            color: var(--accent-warm);
        }

        .btn-brand {
            background-color: var(--accent-warm);
            border-color: var(--accent-warm);
            color: white;
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-brand:hover {
            background-color: #B39048;
            border-color: #B39048;
            color: white;
            transform: translateY(-1px);
        }

        .card-auth {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 77, 54, 0.15);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
    </style>

    @stack('styles')
</head>

<body class="d-flex align-items-center justify-content-center p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <a href="/">
                        <img src="{{ asset('img/lmc.png') }}" alt="Legian Medical Clinic" height="60">
                    </a>
                </div>

                <!-- Card Content -->
                <div class="card card-auth">
                    <div class="card-body p-4 p-md-5">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Back to home link -->
                <div class="text-center mt-4">
                    <a href="/" class="text-muted text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>