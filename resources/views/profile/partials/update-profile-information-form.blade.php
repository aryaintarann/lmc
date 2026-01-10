@php /** @var \App\Models\User $user */ @endphp
<p class="text-muted mb-4">
    {{ __("Update your account's profile information and email address.") }}
</p>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label">{{ __('Name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-muted small mb-1">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" class="btn btn-link btn-sm p-0 text-decoration-underline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="text-success small">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

        @if (session('status') === 'profile-updated')
            <span class="text-success small">
                <i class="bi bi-check-circle me-1"></i>{{ __('Saved.') }}
            </span>
        @endif
    </div>
</form>