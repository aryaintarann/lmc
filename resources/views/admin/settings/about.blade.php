@extends('layouts.admin')

@section('header', 'About Section Settings')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.about.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="about_title" class="form-label fw-bold text-muted">Section Title</label>
                            <input type="text" class="form-control form-control-lg" id="about_title" name="about_title"
                                value="{{ $settings['about_title'] ?? '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="about_subtitle" class="form-label fw-bold text-muted">Section Subtitle</label>
                            <input type="text" class="form-control" id="about_subtitle" name="about_subtitle"
                                value="{{ $settings['about_subtitle'] ?? '' }}" placeholder="Usually the Clinic Name">
                        </div>

                        <div class="mb-4">
                            <label for="about_description" class="form-label fw-bold text-muted">Description /
                                Content</label>
                            <textarea class="form-control" id="about_description" name="about_description" rows="6"
                                required>{{ $settings['about_description'] ?? '' }}</textarea>
                            <div class="form-text">The main text displaying the clinic's introduction.</div>
                        </div>

                        <div class="mb-4">
                            <label for="about_image" class="form-label fw-bold text-muted">About Image</label>
                            @if(isset($settings['about_image']))
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $settings['about_image']) }}" class="img-thumbnail"
                                        style="max-height: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="about_image" name="about_image">
                            <div class="form-text">Upload an image to display in the about section.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted">Key Features List</label>
                            <div id="features-container">
                                @php
                                    $features = isset($settings['about_features']) ? json_decode($settings['about_features'], true) : [];
                                    if (empty($features))
                                        $features = ['']; // Start with at least one empty field
                                @endphp
                                @foreach($features as $feature)
                                    <div class="input-group mb-2 feature-item">
                                        <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                        <input type="text" class="form-control" name="about_features[]" value="{{ $feature }}"
                                            placeholder="e.g. Experienced Professionals">
                                        <button class="btn btn-outline-danger remove-feature" type="button"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-feature">
                                <i class="bi bi-plus-lg"></i> Add Feature Item
                            </button>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold">
                                <i class="bi bi-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const container = document.getElementById('features-container');
                            const addButton = document.getElementById('add-feature');

                            // Add Feature
                            addButton.addEventListener('click', function () {
                                const div = document.createElement('div');
                                div.className = 'input-group mb-2 feature-item';
                                div.innerHTML = `
                                        <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                        <input type="text" class="form-control" name="about_features[]" placeholder="e.g. Experienced Professionals">
                                        <button class="btn btn-outline-danger remove-feature" type="button"><i class="bi bi-trash"></i></button>
                                    `;
                                container.appendChild(div);
                            });

                            // Remove Feature (Event Delegation)
                            container.addEventListener('click', function (e) {
                                if (e.target.closest('.remove-feature')) {
                                    e.target.closest('.feature-item').remove();
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection