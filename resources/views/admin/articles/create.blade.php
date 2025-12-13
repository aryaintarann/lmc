@extends('layouts.admin')

@section('header', 'Create Article')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Keyword Helper Section (Styled) -->
                <div class="card mb-4 border-0 shadow-sm" style="background: linear-gradient(to right, #ffffff, #f8f9fa);">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <h6 class="card-title fw-bold mb-0" style="color: var(--primary-color);">SEO Keyword
                                    Assistant</h6>
                                <small class="text-muted">Boost your article visibility with real-time trends.</small>
                            </div>
                        </div>

                        <div class="input-group mb-4">
                            <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-2" id="keywordTopic"
                                placeholder="Enter topic (e.g. 'Demam Berdarah')..." style="height: 45px;">
                            <button class="btn btn-primary px-4" type="button" id="btnGetKeywords"
                                style="background: var(--primary-color); border: none;">
                                <i class="bi bi-magic me-2"></i> Get Suggestions
                            </button>
                        </div>

                        <!-- Suggestions Tabs (Premium Segmented Control) -->
                        <div class="d-flex justify-content-center mb-4">
                            <div class="nav nav-pills bg-light p-1 rounded-pill" id="suggestionTabs" role="tablist"
                                style="border: 1px solid #e0e0e0;">
                                <div class="nav-item" role="presentation">
                                    <button
                                        class="nav-link active rounded-pill px-4 py-2 small fw-bold d-flex align-items-center gap-2"
                                        id="sug-id-tab" data-bs-toggle="pill" data-bs-target="#sug-id" type="button"
                                        role="tab" style="transition: all 0.3s ease;">
                                        <span style="font-size: 1.2em;">🇮🇩</span> Indonesia
                                    </button>
                                </div>
                                <div class="nav-item" role="presentation">
                                    <button
                                        class="nav-link rounded-pill px-4 py-2 small fw-bold d-flex align-items-center gap-2"
                                        id="sug-en-tab" data-bs-toggle="pill" data-bs-target="#sug-en" type="button"
                                        role="tab" style="transition: all 0.3s ease;">
                                        <span style="font-size: 1.2em;">🇺🇸</span> Global
                                    </button>
                                </div>
                            </div>
                        </div>

                        <style>
                            /* Custom Tab State Override */
                            #suggestionTabs .nav-link {
                                color: #6c757d;
                            }

                            #suggestionTabs .nav-link.active {
                                background-color: white !important;
                                color: var(--primary-color) !important;
                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                            }
                        </style>

                        <div class="tab-content" id="suggestionTabContent" style="min-height: 100px;">
                            <!-- ID Content -->
                            <div class="tab-pane fade show active" id="sug-id" role="tabpanel">
                                <div id="keywordSuggestionsID" class="d-flex flex-wrap gap-2 mb-3 justify-content-center">
                                    <small class="text-muted fst-italic"><i class="bi bi-search"></i> Enter a topic and
                                        search to see localized trends.</small>
                                </div>
                                <div id="titleContainerID" class="d-none mt-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-grow-1 border-bottom"></div>
                                        <h6 class="text-uppercase small fw-bold mx-3 mb-0"
                                            style="color: var(--primary-color); letter-spacing: 1px;">
                                            Smart Title Ideas
                                        </h6>
                                        <div class="flex-grow-1 border-bottom"></div>
                                    </div>
                                    <div class="list-group list-group-flush small" id="titleListID"></div>
                                </div>
                            </div>
                            <!-- EN Content -->
                            <div class="tab-pane fade" id="sug-en" role="tabpanel">
                                <div id="keywordSuggestionsEN" class="d-flex flex-wrap gap-2 mb-3 justify-content-center">
                                    <small class="text-muted fst-italic"><i class="bi bi-search"></i> Enter a topic and
                                        search to see global trends.</small>
                                </div>
                                <div id="titleContainerEN" class="d-none mt-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-grow-1 border-bottom"></div>
                                        <h6 class="text-uppercase small fw-bold mx-3 mb-0"
                                            style="color: var(--primary-color); letter-spacing: 1px;">
                                            Smart Title Ideas
                                        </h6>
                                        <div class="flex-grow-1 border-bottom"></div>
                                    </div>
                                    <div class="list-group list-group-flush small" id="titleListEN"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Language Tabs -->
                <ul class="nav nav-tabs mb-3" id="langTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button"
                            role="tab" aria-controls="en" aria-selected="true">English (Default)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="id-tab" data-bs-toggle="tab" data-bs-target="#id" type="button"
                            role="tab" aria-controls="id" aria-selected="false">Indonesia</button>
                    </li>
                </ul>

                <div class="tab-content" id="langTabContent">
                    <!-- English Tab -->
                    <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                        <div class="mb-3">
                            <label for="title_en" class="form-label">Title (EN)</label>
                            <input type="text" class="form-control @error('title.en') is-invalid @enderror" id="title_en"
                                name="title[en]" value="{{ old('title.en') }}">
                            @error('title.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt_en" class="form-label">Excerpt (EN)</label>
                            <textarea class="form-control @error('excerpt.en') is-invalid @enderror" id="excerpt_en"
                                name="excerpt[en]" rows="2">{{ old('excerpt.en') }}</textarea>
                            <div class="form-text">Brief summary shown on listings.</div>
                            @error('excerpt.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content_en" class="form-label">Content (EN)</label>
                            <textarea class="form-control summernote @error('content.en') is-invalid @enderror"
                                id="content_en" name="content[en]" rows="10">{{ old('content.en') }}</textarea>
                            @error('content.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Indonesian Tab -->
                    <div class="tab-pane fade" id="id" role="tabpanel" aria-labelledby="id-tab">
                        <div class="mb-3">
                            <label for="title_id" class="form-label">Title (ID)</label>
                            <input type="text" class="form-control @error('title.id') is-invalid @enderror" id="title_id"
                                name="title[id]" value="{{ old('title.id') }}">
                            @error('title.id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt_id" class="form-label">Excerpt (ID)</label>
                            <textarea class="form-control @error('excerpt.id') is-invalid @enderror" id="excerpt_id"
                                name="excerpt[id]" rows="2">{{ old('excerpt.id') }}</textarea>
                            <div class="form-text">Ringkasan singkat untuk tampilan daftar.</div>
                            @error('excerpt.id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content_id" class="form-label">Content (ID)</label>
                            <textarea class="form-control summernote @error('content.id') is-invalid @enderror"
                                id="content_id" name="content[id]" rows="10">{{ old('content.id') }}</textarea>
                            @error('content.id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Shared Fields -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Article Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                            accept="image/*">
                        <div class="form-text">Upload an image for the article (Max 2MB).</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="date" class="form-control @error('published_at') is-invalid @enderror"
                            id="published_at" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}">
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Article</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Summernote config
            $('.summernote').summernote({
                // ... (keep existing config if any)
                placeholder: 'Write your content here...',
                tabsize: 2,
                height: 400
            });

            // Keyword Suggestion Logic
            const btnGet = document.getElementById('btnGetKeywords');
            const inputTopic = document.getElementById('keywordTopic');

            // Containers ID
            const containerID = document.getElementById('keywordSuggestionsID');
            const titleContainerID = document.getElementById('titleContainerID');
            const titleListID = document.getElementById('titleListID');

            // Containers EN
            const containerEN = document.getElementById('keywordSuggestionsEN');
            const titleContainerEN = document.getElementById('titleContainerEN');
            const titleListEN = document.getElementById('titleListEN');

            function renderSuggestions(data, container, titleCont, titleList, targetTitleInputId) {
                container.innerHTML = '';
                titleList.innerHTML = '';
                titleCont.classList.add('d-none');

                // Keywords
                if (data.suggestions && data.suggestions.length > 0) {
                    // Add explanatory text
                    const infoText = document.createElement('div');
                    infoText.className = 'w-100 text-center text-muted small mb-3';
                    infoText.innerHTML = '<i class="bi bi-info-circle me-1"></i> These are top trending related searches from Google. Click any keyword to copy.';
                    container.appendChild(infoText);

                    data.suggestions.forEach(keyword => {
                        const badge = document.createElement('span');
                        // Premium Badge Style
                        badge.className = 'badge rounded-pill border fw-normal px-3 py-2 me-1 mb-1 shadow-sm';
                        badge.style.backgroundColor = '#fff';
                        badge.style.color = 'var(--primary-color)';
                        badge.style.borderColor = '#e9ecef';
                        badge.style.cursor = 'pointer';
                        badge.style.transition = 'all 0.2s';

                        // Hover effect handled via CSS or simple JS
                        badge.onmouseover = function () {
                            this.style.backgroundColor = 'var(--primary-color)';
                            this.style.color = '#fff';
                        };
                        badge.onmouseout = function () {
                            if (this.innerText !== 'Copied!') {
                                this.style.backgroundColor = '#fff';
                                this.style.color = 'var(--primary-color)';
                            }
                        };

                        badge.innerText = keyword;
                        badge.title = 'Click to copy';
                        badge.onclick = function () {
                            navigator.clipboard.writeText(keyword);
                            const originalText = this.innerText;

                            // Copied State
                            this.innerText = 'Copied!';
                            this.style.backgroundColor = 'var(--accent-warm)';
                            this.style.color = '#fff';
                            this.style.borderColor = 'var(--accent-warm)';

                            setTimeout(() => {
                                this.innerText = originalText;
                                this.style.backgroundColor = '#fff';
                                this.style.color = 'var(--primary-color)';
                                this.style.borderColor = '#e9ecef';
                            }, 1000);
                        };
                        container.appendChild(badge);
                    });
                } else {
                    container.innerHTML = '<small class="text-danger">No suggestions found.</small>';
                }

                // Titles
                if (data.titles && data.titles.length > 0) {
                    titleCont.classList.remove('d-none');
                    data.titles.forEach(title => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action py-1';
                        item.innerText = title;
                        item.onclick = function () {
                            document.getElementById(targetTitleInputId).value = title;
                            // Flash effect
                            this.classList.add('active');
                            setTimeout(() => this.classList.remove('active'), 300);
                        };
                        titleList.appendChild(item);
                    });
                }
            }

            btnGet.addEventListener('click', function () {
                const topic = inputTopic.value.trim();
                if (!topic) return;

                // Loading State
                btnGet.disabled = true;
                btnGet.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';
                containerID.innerHTML = '<small class="text-muted">Fetching...</small>';
                containerEN.innerHTML = '<small class="text-muted">Fetching...</small>';

                fetch(`{{ route('admin.keywords.suggest') }}?topic=${encodeURIComponent(topic)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Render ID
                        if (data.id) {
                            renderSuggestions(data.id, containerID, titleContainerID, titleListID, 'title_id');
                        }
                        // Render EN
                        if (data.en) {
                            renderSuggestions(data.en, containerEN, titleContainerEN, titleListEN, 'title_en');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        containerID.innerHTML = '<small class="text-danger">Error.</small>';
                        containerEN.innerHTML = '<small class="text-danger">Error.</small>';
                    })
                    .finally(() => {
                        btnGet.disabled = false;
                        btnGet.innerText = 'Get Suggestions';
                    });
            });
        });
    </script>
@endsection