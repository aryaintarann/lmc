@extends('layouts.admin')

@section('header', 'Create Service')

@section('content')
    <div class="card">
        <span class="input-group-text"><i id="icon-preview" class="bi bi-activity text-primary"></i></span>
        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon"
            value="{{ old('icon', 'bi-activity') }}" readonly required>
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#iconModal">Change
            Icon</button>
    </div>
    @error('icon')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    <!-- Icon Picker Modal -->
    <div class="modal fade" id="iconModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Icon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="iconSearch" class="form-control mb-3" placeholder="Search icons...">
                    <div id="iconGrid" class="row g-2" style="max-height: 400px; overflow-y: auto;">
                        <!-- Icons will be injected here via JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const icons = [
                // Medical & Health
                'bi-activity', 'bi-heart-pulse', 'bi-lungs', 'bi-virus', 'bi-capsule', 'bi-prescription2',
                'bi-bandaid', 'bi-hospital', 'bi-clipboard-pulse', 'bi-heart-fill', 'bi-heart', 'bi-person-heart',
                'bi-thermometer-half', 'bi-thermometer-high', 'bi-droplet', 'bi-droplet-fill', 'bi-bezier',
                'bi-clipboard-check', 'bi-file-medical', 'bi-journal-medical', 'bi-plus-circle-fill',
                'bi-people', 'bi-person', 'bi-person-gear', 'bi-eyeglasses', 'bi-ear', 'bi-gender-ambiguous',
                'bi-gender-female', 'bi-gender-male', 'bi-meta', 'bi-body-text',

                // General Interface
                'bi-check-circle', 'bi-check-circle-fill', 'bi-check-lg', 'bi-x-circle', 'bi-x-circle-fill', 'bi-x-lg',
                'bi-dash-circle', 'bi-dash-circle-fill', 'bi-plus-circle', 'bi-plus-circle-fill', 'bi-plus-lg',
                'bi-info-circle', 'bi-info-circle-fill', 'bi-info-lg', 'bi-question-circle', 'bi-question-circle-fill',
                'bi-exclamation-circle', 'bi-exclamation-circle-fill', 'bi-exclamation-triangle', 'bi-exclamation-triangle-fill',
                'bi-bell', 'bi-bell-fill', 'bi-bell-slash', 'bi-bell-slash-fill', 'bi-calendar', 'bi-calendar-check',
                'bi-calendar-event', 'bi-calendar-fill', 'bi-calendar-plus', 'bi-calendar-range', 'bi-calendar-week',
                'bi-clock', 'bi-clock-fill', 'bi-clock-history', 'bi-alarm', 'bi-alarm-fill', 'bi-stopwatch',
                'bi-envelope', 'bi-envelope-fill', 'bi-envelope-open', 'bi-envelope-open-fill', 'bi-envelope-plus',
                'bi-telephone', 'bi-telephone-fill', 'bi-telephone-inbound', 'bi-telephone-outbound', 'bi-phone',
                'bi-phone-fill', 'bi-house', 'bi-house-fill', 'bi-house-door', 'bi-house-door-fill', 'bi-building',
                'bi-building-fill', 'bi-shop', 'bi-shop-window', 'bi-bank', 'bi-bag', 'bi-bag-fill', 'bi-bag-check',
                'bi-cart', 'bi-cart-fill', 'bi-cart-check', 'bi-cart-plus', 'bi-gear', 'bi-gear-fill', 'bi-gear-wide',
                'bi-tools', 'bi-wrench', 'bi-hammer', 'bi-trash', 'bi-trash-fill', 'bi-archive', 'bi-archive-fill',
                'bi-pencil', 'bi-pencil-fill', 'bi-pencil-square', 'bi-share', 'bi-share-fill', 'bi-save', 'bi-save-fill',

                // Objects & Miscellaneous
                'bi-award', 'bi-award-fill', 'bi-badge-ad', 'bi-badge-ar', 'bi-badge-cc', 'bi-badge-hd', 'bi-badge-tm',
                'bi-bookmark', 'bi-bookmark-fill', 'bi-bookmark-star', 'bi-book', 'bi-book-fill', 'bi-briefcase',
                'bi-briefcase-fill', 'bi-card-checklist', 'bi-card-heading', 'bi-card-image', 'bi-card-list',
                'bi-card-text', 'bi-chat', 'bi-chat-dots', 'bi-chat-fill', 'bi-chat-left', 'bi-chat-right',
                'bi-chat-square', 'bi-chat-square-dots', 'bi-chat-square-text', 'bi-circle', 'bi-circle-fill',
                'bi-cloud', 'bi-cloud-arrow-down', 'bi-cloud-arrow-up', 'bi-cloud-check', 'bi-cloud-download',
                'bi-cloud-fill', 'bi-cloud-plus', 'bi-cloud-slash', 'bi-cloud-upload', 'bi-code', 'bi-code-slash',
                'bi-code-square', 'bi-compass', 'bi-compass-fill', 'bi-cone', 'bi-cone-striped', 'bi-controller',
                'bi-cpu', 'bi-cpu-fill', 'bi-credit-card', 'bi-credit-card-2-back', 'bi-credit-card-2-front',
                'bi-cup', 'bi-cup-fill', 'bi-cup-straw', 'bi-currency-dollar', 'bi-currency-euro', 'bi-currency-exchange',
                'bi-cursor', 'bi-cursor-fill', 'bi-cursor-text', 'bi-database', 'bi-database-fill', 'bi-database-check',
                'bi-diagram-2', 'bi-diagram-3', 'bi-diamond', 'bi-diamond-fill', 'bi-dice-1', 'bi-dice-6',
                'bi-display', 'bi-display-fill', 'bi-download', 'bi-easel', 'bi-easel-fill', 'bi-egg', 'bi-egg-fill',
                'bi-emoji-smile', 'bi-emoji-smile-fill', 'bi-emoji-sunglasses', 'bi-eye', 'bi-eye-fill', 'bi-eye-slash',
                'bi-file-earmark', 'bi-file-earmark-check', 'bi-file-earmark-code', 'bi-file-earmark-diff',
                'bi-file-earmark-medical', 'bi-file-earmark-pdf', 'bi-file-earmark-text', 'bi-film', 'bi-filter',
                'bi-fingerprint', 'bi-flag', 'bi-flag-fill', 'bi-flower1', 'bi-flower2', 'bi-folder', 'bi-folder-fill',
                'bi-folder-plus', 'bi-funnel', 'bi-funnel-fill', 'bi-gem', 'bi-geo', 'bi-geo-alt', 'bi-gift',
                'bi-gift-fill', 'bi-globe', 'bi-globe2', 'bi-graph-down', 'bi-graph-up', 'bi-grid', 'bi-grid-fill',
                'bi-headphones', 'bi-headset', 'bi-hexagon', 'bi-hexagon-fill', 'bi-hourglass', 'bi-hourglass-bottom',
                'bi-hourglass-split', 'bi-hourglass-top', 'bi-image', 'bi-image-fill', 'bi-images', 'bi-inbox',
                'bi-inbox-fill', 'bi-journal', 'bi-journal-bookmark', 'bi-journal-check', 'bi-key', 'bi-key-fill',
                'bi-lamp', 'bi-lamp-fill', 'bi-laptop', 'bi-laptop-fill', 'bi-layers', 'bi-layers-fill', 'bi-layout-sidebar',
                'bi-layout-text-window', 'bi-layout-three-columns', 'bi-lightbulb', 'bi-lightbulb-fill', 'bi-lightbulb-off',
                'bi-lightning', 'bi-lightning-fill', 'bi-link', 'bi-link-45deg', 'bi-list', 'bi-list-check',
                'bi-list-nested', 'bi-list-ol', 'bi-list-task', 'bi-list-ul', 'bi-lock', 'bi-lock-fill', 'bi-unlock',
                'bi-map', 'bi-map-fill', 'bi-megaphone', 'bi-megaphone-fill', 'bi-menu-app', 'bi-menu-button',
                'bi-mic', 'bi-mic-fill', 'bi-mic-mute', 'bi-moon', 'bi-moon-fill', 'bi-moon-stars', 'bi-mouse',
                'bi-music-note', 'bi-music-note-beamed', 'bi-music-note-list', 'bi-newspaper', 'bi-palette',
                'bi-palette-fill', 'bi-paperclip', 'bi-paragraph', 'bi-patch-check', 'bi-patch-check-fill',
                'bi-patch-plus', 'bi-patch-question', 'bi-pause', 'bi-pause-circle', 'bi-peace', 'bi-pen',
                'bi-pin', 'bi-pin-fill', 'bi-pin-map', 'bi-play', 'bi-play-circle', 'bi-play-fill', 'bi-plug',
                'bi-power', 'bi-printer', 'bi-printer-fill', 'bi-puzzle', 'bi-puzzle-fill', 'bi-qr-code',
                'bi-receipt', 'bi-reply', 'bi-reply-all', 'bi-robot', 'bi-rss', 'bi-rss-fill', 'bi-scissors',
                'bi-search', 'bi-share', 'bi-shield', 'bi-shield-check', 'bi-shield-fill', 'bi-shield-lock',
                'bi-shift', 'bi-shift-fill', 'bi-shop', 'bi-shuffle', 'bi-signpost', 'bi-signpost-split',
                'bi-sim', 'bi-skip-backward', 'bi-skip-forward', 'bi-skype', 'bi-slack', 'bi-slash',
                'bi-sliders', 'bi-smartwatch', 'bi-snow', 'bi-snow2', 'bi-snow3', 'bi-sort-alpha-down',
                'bi-sort-alpha-up', 'bi-sort-down', 'bi-sort-numeric-down', 'bi-sort-numeric-up', 'bi-sort-up',
                'bi-soundwave', 'bi-speaker', 'bi-speedometer', 'bi-speedometer2', 'bi-square', 'bi-square-fill',
                'bi-star', 'bi-star-fill', 'bi-star-half', 'bi-stickies', 'bi-stop', 'bi-stop-circle',
                'bi-stoplights', 'bi-stopwatch', 'bi-stopwatch-fill', 'bi-suit-club', 'bi-suit-diamond',
                'bi-suit-heart', 'bi-suit-spade', 'bi-sun', 'bi-sun-fill', 'bi-sunglasses', 'bi-table',
                'bi-tablet', 'bi-tag', 'bi-tag-fill', 'bi-tags', 'bi-tags-fill', 'bi-telegram', 'bi-text-center',
                'bi-text-left', 'bi-text-paragraph', 'bi-text-right', 'bi-textarea', 'bi-thermometer',
                'bi-three-dots', 'bi-three-dots-vertical', 'bi-ticket', 'bi-ticket-fill', 'bi-toggle-off',
                'bi-toggle-on', 'bi-tools', 'bi-tornado', 'bi-trash', 'bi-trash-fill', 'bi-tree', 'bi-tree-fill',
                'bi-trophy', 'bi-trophy-fill', 'bi-truck', 'bi-truck-flatbed', 'bi-tv', 'bi-tv-fill',
                'bi-umbrella', 'bi-upload', 'bi-vector-pen', 'bi-view-list', 'bi-view-stacked', 'bi-vinyl',
                'bi-vinyl-fill', 'bi-wallet', 'bi-wallet2', 'bi-wallet-fill', 'bi-watch', 'bi-water',
                'bi-wifi', 'bi-wifi-off', 'bi-window', 'bi-wrench', 'bi-x', 'bi-x-diamond', 'bi-x-octagon',
                'bi-x-square', 'bi-zoom-in', 'bi-zoom-out'
            ];

            const iconGrid = document.getElementById('iconGrid');
            const iconInput = document.getElementById('icon');
            const iconPreview = document.getElementById('icon-preview');
            const iconSearch = document.getElementById('iconSearch');
            const modalElement = document.getElementById('iconModal');
            const modal = new bootstrap.Modal(modalElement);

            function renderIcons(filter = '') {
                iconGrid.innerHTML = '';
                icons.filter(icon => icon.includes(filter.toLowerCase())).forEach(icon => {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-sm-4 col-md-3 col-lg-2';
                    col.innerHTML = `
                                                <div class="p-3 text-center border rounded icon-option" style="cursor: pointer;" onclick="selectIcon('${icon}')">
                                                    <i class="${icon} fs-3 text-primary mb-2"></i>
                                                    <div class="small text-truncate" style="font-size: 0.7rem;">${icon.replace('bi-', '')}</div>
                                                </div>
                                            `;
                    iconGrid.appendChild(col);
                });
            }

            window.selectIcon = function (iconClass) {
                iconInput.value = iconClass;
                iconPreview.className = `${iconClass} text-primary`;
                // Trigger close button click to ensure modal cleans up properly
                modalElement.querySelector('.btn-close').click();
            };

            iconSearch.addEventListener('input', (e) => renderIcons(e.target.value));

            // Initial render
            renderIcons();
        });
    </script>

    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary me-2">Cancel</a>
        <button type="submit" class="btn btn-primary">Create Service</button>
    </div>
    </form>
    </div>
    </div>
@endsection