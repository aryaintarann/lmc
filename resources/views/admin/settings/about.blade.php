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
                        <h5 class="mb-3 text-dark">Section Title</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="title_id" class="form-label fw-bold text-muted">Title (Bahasa Indonesia)</label>
                                <input type="text" class="form-control" id="title_id" name="title[id]"
                                    value="{{ $about->title['id'] ?? '' }}" placeholder="Tentang Kami">
                            </div>
                            <div class="col-md-6">
                                <label for="title_en" class="form-label fw-bold text-muted">Title (English)</label>
                                <input type="text" class="form-control" id="title_en" name="title[en]"
                                    value="{{ $about->title['en'] ?? '' }}" placeholder="About Us">
                            </div>
                        </div>

                        {{-- Description (Multi-language) --}}
                        <h5 class="mb-3 text-dark">Description</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="description_id" class="form-label fw-bold text-muted">Description (Bahasa
                                    Indonesia)</label>
                                <textarea class="form-control summernote" id="description_id" name="description[id]"
                                    rows="10">{{ $about->description['id'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="description_en" class="form-label fw-bold text-muted">Description
                                    (English)</label>
                                <textarea class="form-control summernote" id="description_en" name="description[en]"
                                    rows="10">{{ $about->description['en'] ?? '' }}</textarea>
                            </div>
                        </div>



                        {{-- Image --}}
                        <h5 class="mb-3 text-dark">About Image</h5>
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

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>
@endpush