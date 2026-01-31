@extends('layouts.admin')

@section('header', 'Contact Information')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.contact.update') }}" method="POST">
                        @csrf

                        {{-- Basic Contact Info --}}
                        <h5 class="mb-3 text-dark">Contact Details</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold text-muted">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ $contact->phone ?? '' }}" placeholder="+62 361 755 123">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold text-muted">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $contact->email ?? '' }}" placeholder="clinic@example.com">
                            </div>
                        </div>

                        {{-- Address (Multi-language) --}}
                        <h5 class="mb-3 text-dark">Physical Address</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="address_id" class="form-label fw-bold text-muted">Address (Bahasa
                                    Indonesia)</label>
                                <textarea class="form-control" id="address_id" name="address[id]"
                                    rows="3">{{ $contact->address['id'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="address_en" class="form-label fw-bold text-muted">Address (English)</label>
                                <textarea class="form-control" id="address_en" name="address[en]"
                                    rows="3">{{ $contact->address['en'] ?? '' }}</textarea>
                            </div>
                        </div>

                        {{-- Additional Contact --}}
                        <h5 class="mb-3 text-dark">Additional Contact</h5>
                        <div class="mb-4">
                            <label for="whatsapp" class="form-label fw-bold text-muted">WhatsApp Number</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                value="{{ $contact->whatsapp ?? '' }}" placeholder="+62 812 3456 7890">
                            <div class="form-text">Include country code, will be used for WhatsApp link</div>
                        </div>

                        {{-- Operating Hours (Multi-language) --}}
                        <h5 class="mb-3 text-dark">Operating Hours</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="operating_hours_id" class="form-label fw-bold text-muted">Operating Hours
                                    (Bahasa Indonesia)</label>
                                <textarea class="form-control" id="operating_hours_id" name="operating_hours[id]" rows="3"
                                    placeholder="Senin - Sabtu: 08:00 - 20:00&#10;Minggu: Tutup">{{ $contact->getTranslation('operating_hours', 'id') ?? '' }}</textarea>
                                <div class="form-text">One schedule per line, e.g.: "Senin - Sabtu: 08:00 - 20:00"</div>
                            </div>
                            <div class="col-md-6">
                                <label for="operating_hours_en" class="form-label fw-bold text-muted">Operating Hours
                                    (English)</label>
                                <textarea class="form-control" id="operating_hours_en" name="operating_hours[en]" rows="3"
                                    placeholder="Mon - Sat: 8:00 AM - 8:00 PM&#10;Sun: Closed">{{ $contact->getTranslation('operating_hours', 'en') ?? '' }}</textarea>
                                <div class="form-text">One schedule per line, e.g.: "Mon - Sat: 8:00 AM - 8:00 PM"</div>
                            </div>
                        </div>

                        {{-- Social Media --}}
                        <h5 class="mb-3 text-dark">Social Media</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="facebook" class="form-label fw-bold text-muted">Facebook URL</label>
                                <input type="url" class="form-control" id="facebook" name="facebook"
                                    value="{{ $contact->facebook ?? '' }}"
                                    placeholder="https://facebook.com/legianmedicalclinic">
                            </div>
                            <div class="col-md-6">
                                <label for="instagram" class="form-label fw-bold text-muted">Instagram URL</label>
                                <input type="url" class="form-control" id="instagram" name="instagram"
                                    value="{{ $contact->instagram ?? '' }}"
                                    placeholder="https://instagram.com/legianmedicalclinic">
                            </div>
                        </div>

                        {{-- Google Maps--}}
                        <h5 class="mb-3 text-dark">Google Maps</h5>
                        <div class="mb-4">
                            <label for="maps_embed" class="form-label fw-bold text-muted">Maps Embed Code</label>
                            <textarea class="form-control" id="maps_embed" name="maps_embed" rows="3"
                                placeholder="<iframe src='https://www.google.com/maps/embed?pb=...' ...></iframe>">{{ $contact->maps_embed ?? '' }}</textarea>
                            <div class="form-text">Paste the full embed code from Google Maps</div>
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