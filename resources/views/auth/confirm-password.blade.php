<x-guest-layout>
    <div class="text-center mb-4">
        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
            style="width: 60px; height: 60px;">
            <i class="bi bi-shield-lock fs-3" style="color: var(--primary-color, #2E4D36);"></i>
        </div>
        <h4 class="fw-bold text-dark mb-2">{{ __('Confirm Password') }}</h4>
        <p class="text-muted small">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label fw-medium">{{ __('Password') }}</label>
            <input id="password" type="password" name="password"
                class="form-control py-2 @error('password') is-invalid @enderror" placeholder="Enter your password"
                required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-brand text-white w-100 py-2 fw-bold">
            {{ __('Confirm') }}
        </button>
    </form>
</x-guest-layout>