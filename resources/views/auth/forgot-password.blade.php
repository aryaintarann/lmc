<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark mb-2">{{ __('Forgot Password?') }}</h4>
        <p class="text-muted small">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label fw-medium">{{ __('Email') }}</label>
            <div class="position-relative">
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="form-control py-2 @error('email') is-invalid @enderror" placeholder="Enter your email"
                    required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-brand text-white w-100 py-2 fw-bold">
            {{ __('Email Password Reset Link') }}
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-decoration-none small"
                style="color: var(--primary-color, #2E4D36);">
                <i class="bi bi-arrow-left me-1"></i> {{ __('Back to Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>