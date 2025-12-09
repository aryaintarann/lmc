@extends('layouts.admin')

@section('header', 'Header Settings')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.header.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="header_badge" class="form-label fw-bold text-muted">Top Badge Text</label>
                            <input type="text" class="form-control" id="header_badge" name="header_badge"
                                value="{{ $settings['header_badge'] ?? '' }}"
                                placeholder="e.g. Welcome to Legian Medical Clinic">
                        </div>

                        <div class="mb-4">
                            <label for="header_title" class="form-label fw-bold text-muted">Hero Title</label>
                            <input type="text" class="form-control form-control-lg" id="header_title" name="header_title"
                                value="{{ $settings['header_title'] ?? '' }}" required>
                            <div class="form-text">The main headline on the landing page.</div>
                        </div>

                        <div class="mb-4">
                            <label for="header_subtitle" class="form-label fw-bold text-muted">Hero Subtitle</label>
                            <textarea class="form-control" id="header_subtitle" name="header_subtitle" rows="3"
                                required>{{ $settings['header_subtitle'] ?? '' }}</textarea>
                            <div class="form-text">A short description or slogan below the title.</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="header_btn_text" class="form-label fw-bold text-muted">Button Text</label>
                                <input type="text" class="form-control" id="header_btn_text" name="header_btn_text"
                                    value="{{ $settings['header_btn_text'] ?? 'Book Appointment' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="header_btn_link" class="form-label fw-bold text-muted">Button Link</label>
                                <input type="text" class="form-control" id="header_btn_link" name="header_btn_link"
                                    value="{{ $settings['header_btn_link'] ?? '#contact' }}"
                                    placeholder="#contact or https://...">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="header_image" class="form-label fw-bold text-muted">Hero Image</label>
                            <input type="file" class="form-control" id="header_image" name="header_image" accept="image/*">
                            <div class="form-text">Recommended size: 600x600px</div>

                            @if(isset($settings['header_image']))
                                <div class="mt-3">
                                    <p class="mb-1 text-muted small">Current Image:</p>
                                    <img src="{{ asset('storage/' . $settings['header_image']) }}" alt="Current Header"
                                        class="img-thumbnail" style="height: 150px;">
                                </div>
                            @endif
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