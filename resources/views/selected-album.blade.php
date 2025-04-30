<div class="row">
    <!-- Основной альбом -->
    <div class="col-md-6">
        <div class="p-3 border bg-white mb-4">
            <div class="text-center album-card position-relative" 
                 data-id="{{ $album->id }}"
                 data-first-track-id="{{ $album->tracks->first()->id ?? '' }}"
                 data-first-track-src="{{ asset($album->tracks->first()->file_path ?? '') }}"
                 data-first-track-title="{{ $album->tracks->first()->title ?? '' }}"
                 data-first-track-artist="{{ $album->artist->name ?? '' }}"
                 data-first-track-cover="{{ asset($album->cover_image) }}">
                <div class="position-relative" style="max-width: 200px; margin: 0 auto;">
                    @if($album->cover_image)
                        <img src="{{ asset($album->cover_image) }}" 
                             alt="{{ $album->title }}" 
                             class="rounded img-fluid" 
                             width="200" height="200">
                    @else
                        <div class="rounded bg-secondary d-flex align-items-center justify-content-center" 
                             style="width: 200px; height: 200px;">
                            <i class="bi bi-disc text-white" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                    <button class="btn-play-album btn btn-primary rounded-circle position-absolute" 
                                style="width: 48px; height: 48px; bottom: 10px; right: 10px;"
                                onclick="playFirstTrackOfAlbum(event, {{ $album->id }})">
                            ♬
                        </button>
                </div>
                <p class="mt-2 fw-bold" style="font-size: 24px;">{{ $album->title }}</p>
                <p class="text-muted" onclick="loadArtist('{{ $album->artist->id }}')" style="cursor: pointer;">
                    {{ $album->artist->name }}
                </p>
            </div>
        </div>
    </div>

    <!-- Треки альбома -->
    <div class="col-md-6">
        <div class="p-3 border bg-white">
            <h4 class="mb-3">Треки альбома</h4>
            <div class="list-group">
                @foreach($tracks as $track)
                    <div class="list-group-item d-flex justify-content-between align-items-center track-card"
                         data-src="{{ asset($track->file_path) }}" 
                         data-id="{{ $track->id }}"
                         data-title="{{ $track->title }}"
                         data-artist="{{ $album->artist->name }}"
                         data-cover="{{ $album->image ?? asset($track->image) }}">
                        <div class="d-flex align-items-center">
                            <img src="{{ $album->image ?? asset($track->image) }}" 
                                 alt="{{ $track->title }}" 
                                 class="rounded me-3"
                                 width="50" height="50">
                            <div>
                                <strong>{{ $track->title }}</strong>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn-play btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-play-fill"></i>
                            </button>
                            <div class="listen-count text-muted small">
                                <i class="bi bi-headphones"></i> {{ $track->listen_count }} прослушиваний
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
</div>