@extends('layouts.admin')

@section('header', 'Edit Doctor')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $doctor->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Language Tabs -->
                <ul class="nav nav-tabs mb-3" id="langTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button"
                            role="tab" aria-controls="en" aria-selected="true">English</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="id-tab" data-bs-toggle="tab" data-bs-target="#id" type="button"
                            role="tab" aria-controls="id" aria-selected="false">Indonesian <small
                                class="text-muted">(Auto-translated if empty)</small></button>
                    </li>
                </ul>

                <div class="tab-content mb-3" id="langTabContent">
                    <!-- English Tab -->
                    <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                        <div class="mb-3">
                            <label for="specialty_en" class="form-label">Specialty (EN)</label>
                            <input type="text" class="form-control @error('specialty.en') is-invalid @enderror"
                                id="specialty_en" name="specialty[en]"
                                value="{{ old('specialty.en', $doctor->getTranslation('specialty', 'en')) }}"
                                placeholder="e.g., General Practitioner">
                            @error('specialty.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio_en" class="form-label">Bio (EN)</label>
                            <textarea class="form-control @error('bio.en') is-invalid @enderror" id="bio_en" name="bio[en]"
                                rows="3"
                                placeholder="English bio">{{ old('bio.en', $doctor->getTranslation('bio', 'en')) }}</textarea>
                            @error('bio.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Indonesian Tab -->
                    <div class="tab-pane fade" id="id" role="tabpanel" aria-labelledby="id-tab">
                        <div class="mb-3">
                            <label for="specialty_id" class="form-label">Specialty (ID)</label>
                            <input type="text" class="form-control @error('specialty.id') is-invalid @enderror"
                                id="specialty_id" name="specialty[id]"
                                value="{{ old('specialty.id', $doctor->getTranslation('specialty', 'id')) }}"
                                placeholder="misal: Dokter Umum">
                            @error('specialty.id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio_id" class="form-label">Bio (ID)</label>
                            <textarea class="form-control @error('bio.id') is-invalid @enderror" id="bio_id" name="bio[id]"
                                rows="3"
                                placeholder="Bio bahasa Indonesia">{{ old('bio.id', $doctor->getTranslation('bio', 'id')) }}</textarea>
                            @error('bio.id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label">Current Image</label>
                    @if ($doctor->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->name }}" class="img-thumbnail"
                                style="max-height: 200px;">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">New Profile Image <small class="text-muted">(Leave empty to
                            keep current)</small></label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                        accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary me-2"
                        onclick="return confirm('Are you sure you want to cancel? Unsaved changes will be lost.')">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Doctor</button>
                </div>
            </form>
        </div>
    </div>
@endsection