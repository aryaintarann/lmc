@extends('layouts.admin')

@section('header', 'About Section Settings')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.about.update') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="about_title" class="form-label fw-bold text-muted">Section Title</label>
                            <input type="text" class="form-control form-control-lg" id="about_title" name="about_title"
                                value="{{ $settings['about_title'] ?? '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="about_description" class="form-label fw-bold text-muted">Description /
                                Content</label>
                            <textarea class="form-control" id="about_description" name="about_description" rows="6"
                                required>{{ $settings['about_description'] ?? '' }}</textarea>
                            <div class="form-text">The main text displaying the clinic's introduction.</div>
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