@extends('layouts.admin')

@section('header', 'Edit Setting')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Key</label>
                    <input type="text" class="form-control" value="{{ $setting->key }}" disabled>
                    <div class="form-text">Key name cannot be changed.</div>
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">Value</label>
                    <textarea class="form-control @error('value') is-invalid @enderror" id="value" name="value"
                        rows="5">{{ old('value', $setting->value) }}</textarea>
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Value</button>
                </div>
            </form>
        </div>
    </div>
@endsection
