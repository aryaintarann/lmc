@extends('layouts.admin')

@section('header', 'Edit Gallery Image')

@section('content')
    <div class="card">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Edit Gallery Image</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <!-- Title ID -->
                        <div class="mb-3">
                            <label for="title_id" class="form-label fw-semibold">
                                Title (Indonesian) <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title.id') is-invalid @enderror" 
                                   id="title_id" 
                                   name="title[id]" 
                                   value="{{ old('title.id', $gallery->getTranslation('title', 'id')) }}"
                                   placeholder="e.g., Ruang Tunggu">
                            @error('title.id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Title EN -->
                        <div class="mb-3">
                            <label for="title_en" class="form-label fw-semibold">
                                Title (English)
                                <small class="text-muted">(Auto-translated if empty)</small>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title.en') is-invalid @enderror" 
                                   id="title_en" 
                                   name="title[en]" 
                                   value="{{ old('title.en', $gallery->getTranslation('title', 'en')) }}"
                                   placeholder="e.g., Waiting Area">
                            @error('title.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Image</label>
                            <div class="border rounded p-2">
                                <img src="{{ asset('storage/' . $gallery->image) }}" 
                                     alt="{{ $gallery->title }}" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label fw-semibold">
                                New Image <small class="text-muted">(Leave empty to keep current)</small>
                            </label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image"
                                   accept="image/jpeg,image/png,image/jpg,image/webp">
                            <div class="form-text">Max 2MB. Accepted formats: JPEG, PNG, JPG, WebP</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview -->
                        <div class="mb-3" id="preview-container" style="display: none;">
                            <label class="form-label fw-semibold">New Image Preview</label>
                            <div class="border rounded p-2">
                                <img id="image-preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Order -->
                        <div class="mb-3">
                            <label for="order" class="form-label fw-semibold">Display Order</label>
                            <input type="number" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   id="order" 
                                   name="order" 
                                   value="{{ old('order', $gallery->order) }}"
                                   min="0">
                            <div class="form-text">Lower numbers appear first</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active"
                                       {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">Active</label>
                            </div>
                            <div class="form-text">Inactive images won't appear on the landing page</div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('preview-container').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
