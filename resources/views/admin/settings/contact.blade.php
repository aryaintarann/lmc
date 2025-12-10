@extends('layouts.admin')

@section('header', 'Contact Information')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.contact.update') }}" method="POST">
                        @csrf

                        <h5 class="text-secondary border-bottom pb-2 mb-3">Section Headings</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contact_section_subtitle" class="form-label fw-bold small text-muted">Section
                                    Subtitle</label>
                                <input type="text" class="form-control" id="contact_section_subtitle"
                                    name="contact_section_subtitle"
                                    value="{{ $settings['contact_section_subtitle'] ?? 'Get in Touch' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact_section_title" class="form-label fw-bold small text-muted">Section
                                    Title</label>
                                <input type="text" class="form-control" id="contact_section_title"
                                    name="contact_section_title"
                                    value="{{ $settings['contact_section_title'] ?? 'Contact Us' }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="contact_section_description" class="form-label fw-bold small text-muted">Section
                                Description</label>
                            <textarea class="form-control" id="contact_section_description"
                                name="contact_section_description"
                                rows="2">{{ $settings['contact_section_description'] ?? 'We are here to assist you. Reach out to us anytime.' }}</textarea>
                        </div>

                        <h5 class="text-secondary border-bottom pb-2 mb-3 mt-4">Contact Details Box</h5>
                        <div class="mb-3">
                            <label for="contact_info_title" class="form-label fw-bold small text-muted">Box Title</label>
                            <input type="text" class="form-control" id="contact_info_title" name="contact_info_title"
                                value="{{ $settings['contact_info_title'] ?? 'Contact Information' }}">
                        </div>
                        <div class="mb-3">
                            <label for="contact_info_description" class="form-label fw-bold small text-muted">Box
                                Description</label>
                            <textarea class="form-control" id="contact_info_description" name="contact_info_description"
                                rows="2">{{ $settings['contact_info_description'] ?? 'Reach out to us directly or visit our clinic.' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="contact_phone" class="form-label fw-bold small text-muted"><i
                                    class="bi bi-telephone me-2"></i>Phone Number</label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                                value="{{ $settings['contact_phone'] ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact_email" class="form-label fw-bold small text-muted"><i
                                    class="bi bi-envelope me-2"></i>Email Address</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email"
                                value="{{ $settings['contact_email'] ?? '' }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="contact_address" class="form-label fw-bold small text-muted"><i
                                    class="bi bi-geo-alt me-2"></i>Physical Address</label>
                            <textarea class="form-control" id="contact_address" name="contact_address" rows="2"
                                required>{{ $settings['contact_address'] ?? '' }}</textarea>
                        </div>

                        <h5 class="text-secondary border-bottom pb-2 mb-3 mt-4">Google Map</h5>
                        <div class="mb-4">
                            <label for="contact_map_url" class="form-label fw-bold small text-muted">Map Embed URL (src
                                attribute only)</label>
                            <input type="text" class="form-control" id="contact_map_url" name="contact_map_url"
                                value="{{ $settings['contact_map_url'] ?? '' }}"
                                placeholder="https://www.google.com/maps/embed?pb=...">
                            <div class="form-text">Paste the URL from the 'src' attribute of the Google Maps Embed code.
                            </div>
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