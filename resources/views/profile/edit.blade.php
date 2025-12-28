@extends('layouts.admin')

@section('header', 'Profile')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- Update Profile Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>{{ __('Profile Information') }}</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-key me-2"></i>{{ __('Update Password') }}</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card border-danger">
                <div class="card-header text-danger">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>{{ __('Delete Account') }}</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection