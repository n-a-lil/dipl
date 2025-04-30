<div class="p-3 border bg-white">
    @if(isset($artistId))
        <button class="btn btn-secondary mb-3" onclick="backToArtistAlbums({{ $artistId }})">← Назад к альбомам артиста</button>
    @else
        <button class="btn btn-secondary mb-3" onclick="backToAlbums()">← Назад к альбомам</button>
    @endif
    
    <h2 class="mb-3">{{ $album->title }}</h2>
    <p class="text-muted mb-3">Исполнитель: {{ $album->artist->name }}</p>
    
    <div class="d-flex flex-wrap gap-4">
        @foreach($tracks as $track)
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
            <p class="text-muted" style="font-size: 16px;">{{ $track->artist->name }}</p>
            <div class="listen-count text-muted small">
                <i class="bi bi-headphones"></i> {{ $track->listen_count }} прослушиваний
            </div>
            <div class="track-actions">
                <span class="actions-toggle" onclick="toggleActions(event, 'actions-{{ $track->id }}')">⋯</span>
                <div class="actions-menu" id="actions-{{ $track->id }}">
                    <div onclick="loadTrackCard('{{$track->id}}')">Карточка трека</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>