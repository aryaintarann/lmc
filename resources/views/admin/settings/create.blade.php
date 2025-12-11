@extends('layouts.admin')

@section('header', 'Add Setting')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="key" class="form-label">Key</label>
                    <input type="text" class="form-control @error('key') is-invalid @enderror" id="key" name="key"
                        value="{{ old('key') }}" placeholder="e.g. footer_text">
                    <div class="form-text">Use lowercase and underscores.</div>
                    @error('key')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                        <option value="text">Text (short)</option>
                        <option value="textarea">Textarea (long)</option>
                        <option value="image">Image URL</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">Value</label>
                    <textarea class="form-control @error('value') is-invalid @enderror" id="value" name="value"
                        rows="3">{{ old('value') }}</textarea>
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Setting</button>
                </div>
            </form>
        </div>
    </div>
@endsection
