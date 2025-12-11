@extends('layouts.admin')

@section('header', 'Header Settings')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.header.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Title Section --}}
                        <h5 class="mb-3 text-primary"><i class="bi bi-translate me-2"></i>Hero Title</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="title_id" class="form-label fw-bold text-muted">Title (Bahasa Indonesia)</label>
                                <input type="text" class="form-control" id="title_id" name="title[id]"
                                    value="{{ $header->title['id'] ?? '' }}"
                                    placeholder="Kesehatan Anda, Prioritas Kami">
                            </div>
                            <div class="col-md-6">
                                <label for="title_en" class="form-label fw-bold text-muted">Title (English)</label>
                                <input type="text" class="form-control" id="title_en" name="title[en]"
                                    value="{{ $header->title['en'] ?? '' }}"
                                    placeholder="Your Health, Our Priority">
                            </div>
                        </div>

                        {{-- Tagline Section --}}
                        <h5 class="mb-3 text-primary"><i class="bi bi-chat-quote me-2"></i>Hero Tagline</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="tagline_id" class="form-label fw-bold text-muted">Tagline (Bahasa Indonesia)</label>
                                <textarea class="form-control" id="tagline_id" name="tagline[id]" rows="3">{{ $header->tagline['id'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="tagline_en" class="form-label fw-bold text-muted">Tagline (English)</label>
                                <textarea class="form-control" id="tagline_en" name="tagline[en]" rows="3">{{ $header->tagline['en'] ?? '' }}</textarea>
                            </div>
                        {{-- Button Section --}}
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="button_text_id" class="form-label fw-bold text-muted">Button Text (ID)</label>
                                <input type="text" class="form-control" id="button_text_id" name="button_text[id]"
                                    value="{{ $header->button_text['id'] ?? '' }}"
                                    placeholder="Buat Janji Temu">
                            </div>
                            <div class="col-md-4">
                                <label for="button_text_en" class="form-label fw-bold text-muted">Button Text (EN)</label>
                                <input type="text" class="form-control" id="button_text_en" name="button_text[en]"
                                    value="{{ $header->button_text['en'] ?? '' }}"
                                    placeholder="Book Appointment">
                            </div>
                            <div class="col-md-4">
                                <label for="button_url" class="form-label fw-bold text-muted">Button URL</label>
                                <input type="text" class="form-control" id="button_url" name="button_url"
                                    value="{{ $header->button_url ?? '' }}"
                                    placeholder="https://wa.me/...">
                            </div>
                        </div>

                        {{-- Logo Section --}}
                        <h5 class="mb-3 text-primary"><i class="bi bi-image me-2"></i>Logo</h5>
                        <div class="mb-4">
                            <label for="logo" class="form-label fw-bold text-muted">Upload Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            <div class="form-text">Recommended size: 200x80px (PNG or SVG for best quality)</div>

                            @if($header && $header->logo)
                                <div class="mt-3">
                                    <p class="mb-1 text-muted small">Current Logo:</p>
                                    <img src="{{ asset('storage/' . $header->logo) }}" alt="Current Logo"
                                        class="img-thumbnail" style="height: 80px;">
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
