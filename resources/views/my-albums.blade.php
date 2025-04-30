<div class="p-3 border bg-white">
    <h2 class="mb-3">Мои альбомы</h2>
    
    @if(empty($albums))
        <p>Вы еще не создали ни одного альбома.</p>
    @else
        <div class="d-flex flex-wrap gap-4">
            @foreach($albums as $album)
                <div class="text-center album-card position-relative" 
                     data-id="{{ $album->id }}"
                     data-first-track-id="{{ $album->tracks->first()->id ?? '' }}"
                     data-first-track-src="{{ asset($album->tracks->first()->file_path ?? '') }}"
                     data-first-track-title="{{ $album->tracks->first()->title ?? '' }}"
                     data-first-track-artist="{{ $album->artist->name ?? '' }}"
                     data-first-track-cover="{{ asset($album->cover_image) }}">
                    <div class="position-relative">
                        <img src="{{ asset($album->cover_image) }}" 
                             alt="{{ $album->title }}" 
                             class="rounded album-cover" 
                             width="200" height="200"
                             style="cursor: pointer;"
                             onclick="loadMyAlbumTracks({{ $album->id }})">
                            <button class="btn-play-album btn btn-primary rounded-circle position-absolute" 
                                    style="width: 48px; height: 48px; bottom: 10px; right: 10px;"
                                    onclick="playFirstTrackOfAlbum(event, {{ $album->id }}, true)">
                                ♬
                            </button>
                    </div>
                    <p class="mt-2 fw-bold" onclick="loadMyAlbumTracks({{ $album->id }}, true)">{{ $album->title }}</p>
                    <p class="text-muted">{{ $album->tracks->count() }} треков</p>
                </div>
            @endforeach
        </div>
    @endif
</div>