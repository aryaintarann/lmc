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

                <div class="mb-3">
                    <label for="specialty" class="form-label">Specialty</label>
                    <input type="text" class="form-control @error('specialty') is-invalid @enderror" id="specialty"
                        name="specialty" value="{{ old('specialty', $doctor->specialty) }}" required>
                    @error('specialty')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio"
                        rows="3">{{ old('bio', $doctor->bio) }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Profile Image</label>
                    @if($doctor->image)
                        <div class="mb-2">
                            @if(Str::startsWith($doctor->image, 'http'))
                                <img src="{{ $doctor->image }}" alt="Current Image" class="img-thumbnail" style="height: 100px;">
                            @else
                                <img src="{{ asset('storage/' . $doctor->image) }}" alt="Current Image" class="img-thumbnail"
                                    style="height: 100px;">
                            @endif
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                        accept="image/*">
                    <div class="form-text">Leave blank to keep current image. Upload new (JPG, PNG) to replace.</div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Doctor</button>
                </div>
            </form>
        </div>
    </div>
@endsection