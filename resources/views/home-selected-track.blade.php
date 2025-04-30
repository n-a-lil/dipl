<div class="row">
    <div class="col-md-6">
        <div class="p-3 border bg-white mb-4">
            <div class="d-flex justify-content-center">
                <div class="text-center track-card" 
                     data-src="{{ asset($track->file_path) }}" 
                     data-id="{{ $track->id }}"
                     data-title="{{ $track->title }}"
                     data-artist="{{ $track->artist->name ?? 'Неизвестный артист' }}"
                     data-cover="{{ asset($track->image) }}"
                     data-artist-id="{{ $track->artist->id ?? '' }}">
                    <div class="position-relative">
                        <img src="{{ asset($track->image) }}" alt="{{ $track->title }}" 
                            class="rounded track-cover" 
                            width="200" height="200">
                        <button class="btn-play btn btn-primary rounded-circle position-absolute" 
                                style="width: 48px; height: 48px; bottom: 15px; right: 15px;">
                            <i class="bi bi-play-fill">♬</i>
                        </button>
                    </div>
                    <p class="mt-2 fw-bold" style="font-size: 20px;">{{ $track->title }}</p>
                    <p class="text-muted" style="font-size: 18px;">
                        @if(isset($track->artist))
                            <span class="text-dark" onclick="loadArtist('{{ $track->artist->id }}')" style="cursor: pointer;">
                                {{ $track->artist->name }}
                            </span>
                        @else
                            <span class="text-danger">Неизвестный артист</span>
                        @endif
                    </p>
                    <div class="listen-count text-muted small">
                        <i class="bi bi-headphones"></i> {{ $track->listen_count }} прослушиваний
                    </div>
                    <div class="track-actions">
                        <span class="actions-toggle" onclick="toggleActions(event, 'actions-{{ $track->id }}')">⋯</span>
                        <div class="actions-menu" id="actions-{{ $track->id }}">
                            <div onclick="showPlaylistSelection({{ $track->id }})">Добавить в плейлист</div>
                            <div onclick="loadTrackCard('{{$track->id}}')">Карточка трека</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="p-3 border bg-white">
            <h4 class="mb-3" onclick="loadArtist('{{ $track->artist->id }}')" style="cursor: pointer;">Другие треки {{ $track->artist->name ?? 'этого артиста' }}</h4>
            <div class="list-group">
                @foreach($artistTracks as $artistTrack)
                    <div class="list-group-item d-flex justify-content-between align-items-center track-card"
                         data-src="{{ asset($artistTrack->file_path) }}" 
                         data-id="{{ $artistTrack->id }}"
                         data-title="{{ $artistTrack->title }}"
                         data-artist="{{ $artistTrack->artist->name ?? 'Неизвестный артист' }}"
                         data-cover="{{ asset($artistTrack->image) }}"
                         data-artist-id="{{ $artistTrack->artist->id ?? '' }}">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset($artistTrack->image) }}"    
                                 alt="{{ $artistTrack->title }}" 
                                 class="rounded me-3"
                                 width="50" height="50">
                            <div>
                                <strong>{{ $artistTrack->title }}</strong>
                                <div class="text-muted small" onclick="loadArtist('{{ $track->artist->id }}')" style="cursor: pointer;">
                                    {{ $artistTrack->artist->name ?? 'Неизвестный артист' }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="listen-count text-muted small">
                                <i class="bi bi-headphones"></i> {{ $artistTrack->listen_count }} прослушиваний
                            </div>
                            <button class="btn-play btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-play-fill"></i>
                            </button>
                            <div class="track-actions">
                                <span class="actions-toggle" onclick="toggleActions(event, 'actions-list-{{ $artistTrack->id }}')">⋯</span>
                                <div class="actions-menu" id="actions-list-{{ $artistTrack->id }}">
                                    <div onclick="showPlaylistSelection({{ $artistTrack->id }})">Добавить в плейлист</div>
                                    <div onclick="loadTrackCard('{{$artistTrack->id}}')">Карточка трека</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>