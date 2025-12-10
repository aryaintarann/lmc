@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Services</h6>
                            <h2 class="mb-0 fw-bold">{{ \App\Models\Service::count() }}</h2>
                        </div>
                        <i class="bi bi-activity fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0">
                    <a href="{{ route('admin.services.index') }}" class="text-white text-decoration-none small">Manage
                        Services <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Doctors</h6>
                            <h2 class="mb-0 fw-bold">{{ \App\Models\Doctor::count() }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0">
                    <a href="{{ route('admin.doctors.index') }}" class="text-white text-decoration-none small">Manage
                        Doctors <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Published Articles</h6>
                            <h2 class="mb-0 fw-bold">{{ \App\Models\Article::count() }}</h2>
                        </div>
                        <i class="bi bi-newspaper fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0">
                    <a href="{{ route('admin.articles.index') }}" class="text-white text-decoration-none small">Manage
                        Articles <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Users</h6>
                            <h2 class="mb-0 fw-bold">{{ \App\Models\User::count() }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0">
                    <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none small">Manage
                        Users <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Recent Articles</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Published</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Article::latest()->take(5)->get() as $article)
                                    <tr>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ $article->date }}</td>
                                        <td>
                                            @if($article->published_at)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection