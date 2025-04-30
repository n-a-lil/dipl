<div class="p-3 border bg-white">
    @foreach($genres as $genre)
        <h2 class="mb-3">{{ $genre->name }}</h2>
        <div class="d-flex flex-wrap gap-4">
            @foreach($genre->tracks as $track)
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
                            width="160" height="160">
                        <button class="btn-play btn btn-primary rounded-circle position-absolute" 
                                style="width: 48px; height: 48px; bottom: 10px; right: 10px;">
                            <i class="bi bi-play-fill">♬</i>
                        </button>
                    </div>
                    <p class="mt-2 fw-bold" style="font-size: 18px;">{{ $track->title }}</p>
                    <p class="text-muted" style="font-size: 16px;">
                        @if(isset($track->artist))
                            <span class="text-dark" onclick="loadArtist('{{ $track->artist->id }}')">
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
            @endforeach
        </div>
    @endforeach
</div>