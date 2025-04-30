<div class="p-3 border bg-white">
    <h2 class="mb-3 d-flex justify-content-between align-items-center">{{ $playlist->name }}</h2>
    
    <div class="d-flex flex-wrap gap-4">
        @foreach($playlist->tracks as $track)
        <div class="text-center track-card" 
             data-src="{{ asset($track->file_path) }}" 
             data-id="{{ $track->id }}"
             data-title="{{ $track->title }}"
             data-artist="{{ $track->artist->name }}"
             data-cover="{{ asset($track->image) }}">
            <div class="position-relative">
                <img src="{{ asset($track->image) }}" alt="{{ $track->title }}" 
                    class="rounded track-cover" width="160" height="160">
                <button class="btn-play btn btn-primary rounded-circle position-absolute" 
                        style="width: 48px; height: 48px; bottom: 10px; right: 10px;">
                    ♬
                </button>
            </div>
            <p class="mt-2 fw-bold" style="font-size: 18px;">{{ $track->title }}</p>
            <p class="text-muted" style="font-size: 16px;">
                <span class="text-dark" onclick="loadArtist('{{ $track->artist->id }}')">
                    {{ $track->artist->name }}
                </span>
            </p>
            <div class="listen-count text-muted small">
                    <i class="bi bi-headphones"></i> {{ $track->listen_count }} прослушиваний
            </div>
            <div class="track-actions">
                <span class="actions-toggle" onclick="toggleActions(event, 'actions-{{ $track->id }}')">⋯</span>
                <div class="actions-menu" id="actions-{{ $track->id }}">
                    <div onclick="loadTrackCard('{{$track->id}}')">Карточка трека</div>
                    <div onclick="removeTrack({{ $playlist->id }}, {{ $track->id }})">Удалить</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>