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

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            background-color: #2E4D36;
        }

        .text-gold {
            color: #C5A059;
        }

        .btn-navy {
            background-color: #C5A059;
            transition: all 0.3s ease;
        }

        .btn-navy:hover {
            background-color: #B39048;
            /* Darker Gold */
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <!-- Main Card -->
    <div
        class="bg-white rounded-2xl shadow-xl overflow-hidden w-full max-w-4xl flex flex-col md:flex-row h-auto md:h-[600px]">

        <!-- Left Side: Branding -->
        <div
            class="md:w-1/2 bg-navy flex flex-col items-center justify-center p-8 text-center relative overflow-hidden">
            <!-- Background Element (Optional decoration) -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <i class="bi bi-hospital text-[300px] absolute -top-10 -left-10 text-white"></i>
            </div>

            <div class="relative z-10">
                <div
                    class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center mb-6 mx-auto backdrop-blur-sm border border-white/20">
                    <img src="{{ asset('img/lmc.png') }}" alt="Logo" class="h-14 w-auto drop-shadow-md">
                </div>

                <h1 class="text-3xl font-bold text-white mb-2 tracking-tight">Legian Medical Clinic</h1>
                <p class="text-gold font-medium tracking-widest uppercase text-sm">Premium Care, Trusted Health</p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white relative">
            <div class="w-full max-w-md mx-auto">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Login Anggota</h2>
                    <p class="text-gray-500 text-sm">Welcome back! Please enter your details.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="username"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2E4D36] focus:border-transparent text-gray-900 placeholder-gray-400 sm:text-sm transition-all shadow-sm"
                                placeholder="Enter your email">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="bi bi-lock"></i>
                            </div>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password"
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2E4D36] focus:border-transparent text-gray-900 placeholder-gray-400 sm:text-sm transition-all shadow-sm"
                                placeholder="Enter your password">
                            <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="h-4 w-4 text-[#2E4D36] focus:ring-[#2E4D36] border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember Me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-[#2E4D36] hover:text-[#C5A059] transition-colors"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white btn-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C5A059]">
                            Login
                        </button>
                    </div>
                </form>
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