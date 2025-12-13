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
        {{-- Recent Articles --}}
        <div class="col-md-8">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-journal-text me-2 text-primary"></i> Recent Articles</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4">Title</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentArticles as $article)
                                    <tr>
                                        <td class="ps-4 fw-medium text-dark">{{ Str::limit($article->title, 40) }}</td>
                                        <td class="small text-muted">{{ $article->date }}</td>
                                        <td>
                                            @if($article->published_at)
                                                <span class="badge bg-success-subtle text-success rounded-pill px-3">Published</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Draft</span>
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

        {{-- Zero Result Analysis Widget --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-search me-2 text-danger"></i> Missing Keywords
                    </h5>
                    <span class="badge bg-danger-subtle text-danger rounded-pill">High Demand</span>
                </div>
                <div class="card-body">
                    @if($missingKeywords->count() > 0)
                        <p class="small text-muted mb-3">Users searched for these but found nothing. Write about them!</p>
                        <ul class="list-group list-group-flush">
                            @foreach($missingKeywords as $log)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom-0 pb-2">
                                    <span class="fw-medium text-dark">{{ $log->query }}</span>
                                    <span class="badge bg-light text-dark border rounded-pill">{{ $log->total }}x</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-check-circle fs-1 text-success mb-2"></i>
                            <p class="mb-0 small">Great job! No missing content detected.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection