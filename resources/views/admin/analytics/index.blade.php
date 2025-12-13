@extends('layouts.admin')

@section('header', 'Analytics Dashboard')

@section('content')
    <div class="row g-4">
        <!-- Quick Stats -->
        <div class="col-md-12">
            <div class="card bg-white border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">SEO Overview (The Guardian)</h5>
                        <p class="text-muted mb-0 small">Real-time insights from Google Analytics & Search Logs</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi bi-arrow-repeat me-1"></i>
                            Refresh</button>
                        <a href="https://analytics.google.com" target="_blank"
                            class="btn btn-sm btn-primary rounded-pill px-3">Open GA4 <i
                                class="bi bi-box-arrow-up-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Content Decay Alert -->
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">Content Decay & Growth</h6>
                    & Growth</h6>
                    <span class="badge bg-light text-dark border rounded-pill">MoM Traffic</span>
                </div>
                <div class="card-body p-0">
                    <div class="bg-light px-4 py-3 border-bottom border-light">
                        <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> Tracks articles losing
                            traffic (>30% drop) compared to last month.</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light small text-uppercase">
                                <tr>
                                    <th class="ps-4">Article</th>
                                    <th class="text-end pe-4">Change</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($decayData as $data)
                                    <tr>
                                        <td class="ps-4">
                                            <h6 class="mb-0 small fw-bold text-dark">{{ Str::limit($data['title'], 40) }}</h6>
                                        </td>
                                        <td class="text-end pe-4">
                                            @if($data['change'] < 0)
                                                <span class="text-danger fw-bold"><i class="bi bi-arrow-down-short"></i>
                                                    {{ abs($data['change']) }}%</span>
                                            @else
                                                <span class="text-success fw-bold"><i class="bi bi-arrow-up-short"></i>
                                                    {{ $data['change'] }}%</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-muted small">No significant changes
                                            detected.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. High Bounce / Exit Rate -->
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">High Bounce Pages</h6>
                    </h6>
                    <span class="badge bg-warning text-dark rounded-pill">Optimization Needed</span>
                </div>
                <div class="bg-light px-4 py-3 border-bottom border-light">
                    <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> Pages where >50% users leave
                        immediately. "Related Articles" widget will appear here.</p>
                </div>
                <div class="card-body">
                    @if(count($highBounceArticles) > 0)
                        <div class="alert alert-warning border-0 bg-warning bg-opacity-10 rounded-3 mb-3">
                            <i class="bi bi-exclamation-triangle me-2"></i> These pages have >50% exit rate. We've auto-injected
                            the "Related Articles" widget.
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($highBounceArticles as $article)
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <span class="small fw-bold">{{ Str::limit($article->title, 40) }}</span>
                                    <a href="{{ route('articles.show', $article->id) }}" target="_blank"
                                        class="btn btn-sm btn-light rounded-pill"><i class="bi bi-eye"></i></a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-shield-check fs-1 text-success opacity-50 mb-3"></i>
                            <h6 class="fw-bold text-secondary">All Good!</h6>
                            <p class="small text-muted mb-0">No pages flagged with critical bounce rates.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 3. Search Insights -->
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">Search Insights (Zero Result Analysis)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="bg-light px-4 py-3 border-bottom border-light">
                        <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> Keywords users search for.
                            "Content Gap" means 0 results found—write about these!</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light small text-uppercase">
                                <tr>
                                    <th class="ps-4">Keyword</th>
                                    <th>Total Searches</th>
                                    <th>Failed Searches (0 Results)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($searchLogs as $log)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $log->query }}</td>
                                        <td>{{ $log->total }}</td>
                                        <td>
                                            @if($log->zero_results > 0)
                                                <span class="text-danger fw-bold">{{ $log->zero_results }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($log->zero_results > ($log->total / 2))
                                                <span class="badge bg-danger-subtle text-danger rounded-pill">Content Gap</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success rounded-pill">Covered</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted small">No search data yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection