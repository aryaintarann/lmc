<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark mb-2">{{ __('Reset Password') }}</h4>
        <p class="text-muted small">
            {{ __('Enter your new password below.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-medium">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                class="form-control py-2 @error('email') is-invalid @enderror" required autofocus
                autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium">{{ __('Password') }}</label>
            <input id="password" type="password" name="password"
                class="form-control py-2 @error('password') is-invalid @enderror" placeholder="Enter new password"
                required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-medium">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control py-2"
                placeholder="Confirm new password" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-brand text-white w-100 py-2 fw-bold">
            {{ __('Reset Password') }}
        </button>
    </form>
</x-guest-layout>