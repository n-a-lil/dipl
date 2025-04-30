<div class="p-3 border bg-white">
    <div class="text-center album-card" 
         data-id="{{ $album->id }}"
         data-artist="{{ $album->artist->name ?? 'Неизвестный артист' }}"
         data-cover="{{ asset($album->cover_image) }}"
         data-artist-id="{{ $album->artist->id ?? '' }}">
        <div class="position-relative" style="max-width: 300px; margin: 0 auto;">
            <img src="{{ asset($album->cover_image) }}" 
                 alt="{{ $album->title }}" 
                 class="rounded album-cover" 
                 width="250" height="250">
            <button class="btn-play-album btn btn-primary rounded-circle position-absolute" 
                    style="width: 60px; height: 60px; bottom: 10px; right: 10px;"
                    onclick="playFirstTrackOfAlbum(event, {{ $album->id }})">
                ♬
            </button>
        </div>
        <h2 class="mt-3">{{ $album->title }}</h2>
        <p class="text-muted fs-5">
            @if($album->artist)
                <span class="text-dark" onclick="loadArtist('{{ $album->artist->id }}')">
                    {{ $album->artist->name }}
                </span>
            @else
                <span class="text-danger">Неизвестный артист</span>
            @endif
        </p>
        <p class="text-warning fs-4">
            ⭐ {{ number_format($averageRating ?? 0, 1) }}
            <small class="text-muted">({{ $album->ratings->count() }} оценок)</small>
        </p>
        @if($userRating)
            <p class="fs-5">Ваша оценка: <span class="text-warning">{{ $userRating->rating }}</span></p>
        @endif
        <div class="text-muted fs-5">
            <i class="bi bi-music-note-list"></i> {{ $album->tracks->count() }} треков
        </div>
    </div>

    <div class="mt-4">
        <h3>Треки в альбоме</h3>
        <div class="list-group">
            @foreach($album->tracks as $track)
                <div class="list-group-item d-flex justify-content-between align-items-center track-card"
                     data-src="{{ asset($track->file_path) }}" 
                     data-id="{{ $track->id }}"
                     data-title="{{ $track->title }}"
                     data-artist="{{ $album->artist->name }}"
                     data-cover="{{ $album->cover_image ?? asset($track->image) }}">
                    <div class="d-flex align-items-center">
                        <img src="{{ $album->cover_image ?? asset($track->image) }}" 
                             alt="{{ $track->title }}" 
                             class="rounded me-3"
                             width="50" height="50">
                        <div>
                            <strong>{{ $track->title }}</strong>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn-play btn btn-sm btn-outline-primary me-2">
                            <i class="bi bi-play-fill"></i>
                        </button>
                        <div class="listen-count text-muted small me-2">
                            <i class="bi bi-headphones"></i> {{ $track->listen_count }}
                        </div>
                        <div class="track-actions">
                            <span class="actions-toggle" onclick="toggleActions(event, 'track-actions-{{ $track->id }}')">⋯</span>
                            <div class="actions-menu" id="track-actions-{{ $track->id }}">
                                <div onclick="showPlaylistSelection({{ $track->id }})">В плейлист</div>
                                <div onclick="loadTrackCard('{{$track->id}}')">Карточка трека</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>