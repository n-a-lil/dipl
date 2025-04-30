<div class="p-3 border bg-white">
    <h2 class="mb-3">Альбомы {{ $artist->name }}</h2>
    
    @if($albums->isEmpty())
        <p>У этого артиста пока нет альбомов.</p>
    @else
        <div class="d-flex flex-wrap gap-4">
            @foreach($albums as $album)
                <div class="text-center album-card position-relative" 
                     data-id="{{ $album->id }}"
                     data-first-track-id="{{ $album->tracks->first()->id ?? '' }}"
                     data-first-track-src="{{ asset($album->tracks->first()->file_path ?? '') }}"
                     data-first-track-title="{{ $album->tracks->first()->title ?? '' }}"
                     data-first-track-artist="{{ $artist->name }}"
                     data-first-track-cover="{{ asset($album->cover_image) }}">
                    <div class="position-relative">
                        <img src="{{ asset($album->cover_image) }}" 
                             alt="{{ $album->title }}" 
                             class="rounded album-cover" 
                             width="200" height="200"
                             style="cursor: pointer;"
                             onclick="loadArtistAlbumTracks({{ $album->id }}, {{ $artist->id }})">
                        <button class="btn-play-album btn btn-primary rounded-circle position-absolute" 
                                style="width: 48px; height: 48px; bottom: 10px; right: 10px;"
                                onclick="playFirstTrackOfAlbum(event, {{ $album->id }}, false, {{ $artist->id }})">
                            ♬
                        </button>
                    </div>
                    <p class="mt-2 fw-bold" onclick="loadArtistAlbumTracks({{ $album->id }}, {{ $artist->id }})">{{ $album->title }}</p>
                    <p class="text-muted">{{ $album->tracks_count }} треков</p>
                </div>
            @endforeach
        </div>
    @endif
</div>