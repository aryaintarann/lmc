@extends('layouts.admin')

@section('header', 'About Section Settings')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.about.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Title (Multi-language) --}}
                        <h5 class="mb-3 text-primary"><i class="bi bi-card-heading me-2"></i>Section Title</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="title_id" class="form-label fw-bold text-muted">Title (Bahasa Indonesia)</label>
                                <input type="text" class="form-control" id="title_id" name="title[id]"
                                    value="{{ $about->title['id'] ?? '' }}" required
                                    placeholder="Tentang Kami">
                            </div>
                            <div class="col-md-6">
                                <label for="title_en" class="form-label fw-bold text-muted">Title (English)</label>
                                <input type="text" class="form-control" id="title_en" name="title[en]"
                                    value="{{ $about->title['en'] ?? '' }}" required
                                    placeholder="About Us">
                            </div>
                        </div>

                        {{-- Description (Multi-language) --}}
                        <h5 class="mb-3 text-primary"><i class="bi bi-text-paragraph me-2"></i>Description</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="description_id" class="form-label fw-bold text-muted">Description (Bahasa Indonesia)</label>
                                <textarea class="form-control" id="description_id" name="description[id]" rows="6"
                                    required>{{ $about->description['id'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="description_en" class="form-label fw-bold text-muted">Description (English)</label>
                                <textarea class="form-control" id="description_en" name="description[en]" rows="6"
                                    required>{{ $about->description['en'] ?? '' }}</textarea>
                            </div>
                        </div>

                        {{-- Vision (Multi-language, Optional) --}}
                        <h5 class="mb-3 text-primary"><i class="bi bi-eye me-2"></i>Vision (Optional)</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="vision_id" class="form-label fw-bold text-muted">Vision (Bahasa Indonesia)</label>
                                <textarea class="form-control" id="vision_id" name="vision[id]" rows="3">{{ $about->vision['id'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="vision_en" class="form-label fw-bold text-muted">Vision (English)</label>
                                <textarea class="form-control" id="vision_en" name="vision[en]" rows="3">{{ $about->vision['en'] ?? '' }}</textarea>
                            </div>
                        </div>

                        {{-- Mission (Multi-language, Optional) --}}
                        <h5 class="mb-3 text-primary"><i class="bi bi-flag me-2"></i>Mission (Optional)</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="mission_id" class="form-label fw-bold text-muted">Mission (Bahasa Indonesia)</label>
                                <textarea class="form-control" id="mission_id" name="mission[id]" rows="3">{{ $about->mission['id'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="mission_en" class="form-label fw-bold text-muted">Mission (English)</label>
                                <textarea class="form-control" id="mission_en" name="mission[en]" rows="3">{{ $about->mission['en'] ?? '' }}</textarea>
                            </div>
                        </div>

                        {{-- Image --}}
                        <h5 class="mb-3 text-primary"><i class="bi bi-image me-2"></i>About Image</h5>
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold text-muted">Upload Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">Recommended size: 800x600px</div>

                            @if($about && $about->image)
                                <div class="mt-3">
                                    <p class="mb-1 text-muted small">Current Image:</p>
                                    <img src="{{ asset('storage/' . $about->image) }}" class="img-thumbnail"
                                        style="max-height: 200px;">
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