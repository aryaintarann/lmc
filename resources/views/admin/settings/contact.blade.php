@extends('layouts.admin')

@section('header', 'Contact Information')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.contact.update') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="contact_phone" class="form-label fw-bold text-primary"><i
                                    class="bi bi-telephone me-2"></i>Phone Number</label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                                value="{{ $settings['contact_phone'] ?? '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="contact_email" class="form-label fw-bold text-primary"><i
                                    class="bi bi-envelope me-2"></i>Email Address</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email"
                                value="{{ $settings['contact_email'] ?? '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="contact_address" class="form-label fw-bold text-primary"><i
                                    class="bi bi-geo-alt me-2"></i>Physical Address</label>
                            <textarea class="form-control" id="contact_address" name="contact_address" rows="3"
                                required>{{ $settings['contact_address'] ?? '' }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold">
                                <i class="bi bi-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection