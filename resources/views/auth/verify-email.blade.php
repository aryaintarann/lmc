<x-guest-layout>
    <div class="text-center mb-4">
        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
            style="width: 60px; height: 60px;">
            <i class="bi bi-envelope-check fs-3" style="color: var(--accent-warm, #C5A059);"></i>
        </div>
        <h4 class="fw-bold text-dark mb-2">{{ __('Verify Email') }}</h4>
        <p class="text-muted small">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-brand text-white px-4 py-2 fw-bold w-100">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary px-4 py-2 w-100">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>