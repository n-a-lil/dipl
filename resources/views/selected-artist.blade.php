<div class="row">
    <div class="col-md-6">
        <div class="p-3 border bg-white mb-4">
            <div class="text-center artist-card" data-id="{{ $artist->id }}">
                <div class="position-relative">
                    @if($artist->user->avatar ?? false)
                        <img src="{{ $artist->user->avatar }}" 
                             alt="{{ $artist->name }}" 
                             class="rounded-circle" 
                             width="200" height="200">
                    @else
                        <div class="rounded-circle bg-secondary mx-auto d-flex align-items-center justify-content-center" 
                             style="width: 200px; height: 200px;">
                            <i class="bi bi-person-fill text-white" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                </div>
                <p class="mt-2 fw-bold" onclick="loadArtist('{{ $artist->id }}')" style="font-size: 24px;">{{ $artist->name }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="p-3 border bg-white">
            <h4 class="mb-3">Популярные треки</h4>
            <div class="list-group">
                @foreach($tracks as $track)
                    <div class="list-group-item d-flex justify-content-between align-items-center track-card"
                         data-src="{{ asset($track->file_path) }}" 
                         data-id="{{ $track->id }}"
                         data-title="{{ $track->title }}"
                         data-artist="{{ $artist->name }}"
                         data-cover="{{ asset($track->image) }}">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset($track->image) }}" 
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