@extends('layouts.admin')

@section('header', 'Manage Gallery')

@section('content')
    <div class="card">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Gallery Images</h5>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="bi bi-plus-lg me-1"></i> Add New
            </a>
        </div>
        <div class="card-body">
            @if($galleries->count() > 0)
                <div class="row g-4">
                    @foreach($galleries as $gallery)
                        <div class="col-md-4 col-lg-3">
                            <div class="card h-100 border {{ $gallery->is_active ? '' : 'border-danger opacity-50' }}">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top"
                                        alt="{{ $gallery->title }}" style="height: 180px; object-fit: cover;">
                                    @if(!$gallery->is_active)
                                        <span class="position-absolute top-0 end-0 badge bg-danger m-2">Inactive</span>
                                    @endif
                                    <span class="position-absolute top-0 start-0 badge bg-primary m-2">Order:
                                        {{ $gallery->order }}</span>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title fw-bold mb-2">{{ $gallery->title }}</h6>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}"
                                            class="btn btn-sm btn-outline-primary flex-grow-1">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this image?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $galleries->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-images text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">No gallery images found. Add your first image!</p>
                    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Add Gallery Image
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection