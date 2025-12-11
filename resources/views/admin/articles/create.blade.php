@extends('layouts.admin')

@section('header', 'Create Article')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Language Tabs -->
                <ul class="nav nav-tabs mb-3" id="langTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button"
                            role="tab" aria-controls="en" aria-selected="true">English (Default)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="id-tab" data-bs-toggle="tab" data-bs-target="#id" type="button"
                            role="tab" aria-controls="id" aria-selected="false">Indonesia</button>
                    </li>
                </ul>

                <div class="tab-content" id="langTabContent">
                    <!-- English Tab -->
                    <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                        <div class="mb-3">
                            <label for="title_en" class="form-label">Title (EN)</label>
                            <input type="text" class="form-control @error('title.en') is-invalid @enderror" id="title_en"
                                name="title[en]" value="{{ old('title.en') }}">
                            @error('title.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt_en" class="form-label">Excerpt (EN)</label>
                            <textarea class="form-control @error('excerpt.en') is-invalid @enderror" id="excerpt_en"
                                name="excerpt[en]" rows="2">{{ old('excerpt.en') }}</textarea>
                            <div class="form-text">Brief summary shown on listings.</div>
                            @error('excerpt.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content_en" class="form-label">Content (EN)</label>
                            <textarea class="form-control summernote @error('content.en') is-invalid @enderror"
                                id="content_en" name="content[en]" rows="10">{{ old('content.en') }}</textarea>
                            @error('content.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Indonesian Tab -->
                    <div class="tab-pane fade" id="id" role="tabpanel" aria-labelledby="id-tab">
                        <div class="mb-3">
                            <label for="title_id" class="form-label">Title (ID)</label>
                            <input type="text" class="form-control @error('title.id') is-invalid @enderror" id="title_id"
                                name="title[id]" value="{{ old('title.id') }}">
                            @error('title.id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt_id" class="form-label">Excerpt (ID)</label>
                            <textarea class="form-control @error('excerpt.id') is-invalid @enderror" id="excerpt_id"
                                name="excerpt[id]" rows="2">{{ old('excerpt.id') }}</textarea>
                            <div class="form-text">Ringkasan singkat untuk tampilan daftar.</div>
                            @error('excerpt.id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content_id" class="form-label">Content (ID)</label>
                            <textarea class="form-control summernote @error('content.id') is-invalid @enderror"
                                id="content_id" name="content[id]" rows="10">{{ old('content.id') }}</textarea>
                            @error('content.id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Shared Fields -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Article Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                            accept="image/*">
                        <div class="form-text">Upload an image for the article (Max 2MB).</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="date" class="form-control @error('published_at') is-invalid @enderror"
                            id="published_at" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}">
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Article</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.summernote').summernote({
                placeholder: 'Write your content here...',
                tabsize: 2,
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endsection
