<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Legian Medical Clinic') }} - Login</title>

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
            --primary-color: #2E4D36;
            --secondary-color: #1A2E22;
            --accent-warm: #C5A059;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
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
            background: linear-gradient(135deg, #2E4D36 0%, #1A2E22 100%);
        }

        .text-gold {
            color: var(--accent-warm);
        }

        .btn-brand {
            background-color: var(--accent-warm);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-brand:hover {
            background-color: #B39048;
            transform: translateY(-1px);
        }

        .card-login {
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

        .brand-side {
            position: relative;
            overflow: hidden;
        }

        .brand-side::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .input-with-icon {
            padding-left: 40px;
        }

        .link-primary-custom {
            color: var(--primary-color);
            text-decoration: none;
        }

        .link-primary-custom:hover {
            color: var(--accent-warm);
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center p-3 p-md-4">

    <div class="card card-login w-100" style="max-width: 900px;">
        <div class="row g-0">
            <!-- Left Side: Branding -->
            <div
                class="col-lg-5 bg-navy brand-side d-none d-lg-flex flex-column align-items-center justify-content-center p-5 text-center">
                <div class="position-relative z-1">
                    <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                        style="width: 100px; height: 100px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        <img src="{{ asset('img/lmc.png') }}" alt="Logo" style="height: 60px;" class="drop-shadow">
                    </div>

                    <h1 class="text-white fw-bold mb-2" style="font-size: 1.75rem;">Legian Medical Clinic</h1>
                    <p class="text-gold fw-medium text-uppercase small" style="letter-spacing: 2px;">Premium Care,
                        Trusted Health</p>
                </div>
            </div>

            <!-- Right Side: Login Form -->
            <div class="col-lg-7 p-4 p-md-5">
                <div class="mx-auto" style="max-width: 400px;">
                    <!-- Mobile Logo -->
                    <div class="text-center d-lg-none mb-4">
                        <img src="{{ asset('img/lmc.png') }}" alt="Logo" height="50">
                    </div>

                    <div class="mb-4">
                        <h2 class="fw-bold text-dark mb-2">Login</h2>
                        <p class="text-muted small">Welcome! Please enter your details.</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <div class="position-relative">
                                <i class="bi bi-envelope input-icon"></i>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                    class="form-control input-with-icon py-2 @error('email') is-invalid @enderror"
                                    placeholder="Enter your email" required autofocus autocomplete="username">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <div class="position-relative">
                                <i class="bi bi-lock input-icon"></i>
                                <input id="password" type="password" name="password"
                                    class="form-control input-with-icon py-2 @error('password') is-invalid @enderror"
                                    placeholder="Enter your password" required autocomplete="current-password">
                                <button type="button" onclick="togglePassword()"
                                    class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted pe-3"
                                    style="z-index: 5;">
                                    <i class="bi bi-eye" id="toggleIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                <label class="form-check-label small" for="remember_me">Remember Me</label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="link-primary-custom small fw-medium" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-brand text-white w-100 py-2 fw-bold">
                            Login
                        </button>
                    </form>

                    <!-- Back to home -->
                    <div class="text-center mt-4">
                        <a href="/" class="text-muted text-decoration-none small">
                            <i class="bi bi-arrow-left me-1"></i> Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>

</html>