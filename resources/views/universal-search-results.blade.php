@if($tracks->isNotEmpty())
    <div class="search-category">
        <h6 class="text-muted mb-2">Треки</h6>
        <ul class="list-group">
            @foreach($tracks as $track)
                <li class="track-item list-group-item" data-id="{{ $track->id }}" data-type="track">
                    <div class="d-flex align-items-center">
                        <img src="{{ $track->image }}" 
                             alt="{{ $track->title }}" 
                             class="rounded me-3"
                             width="50" height="50">
                        <div>
                            <strong>{{ $track->title }}</strong>
                            <div class="text-muted small">{{ $track->artist->name }}</div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif

@if($artists->isNotEmpty())
    <div class="search-category mt-3">
        <h6 class="text-muted mb-2">Артисты</h6>
        <ul class="list-group">
            @foreach($artists as $artist)
                <li class="artist-item list-group-item" data-id="{{ $artist->id }}" data-type="artist">
                    <div class="d-flex align-items-center">
                        @if($artist->user->avatar ?? false)
                            <img src="{{ $artist->user->avatar }}" 
                                 alt="{{ $artist->name }}" 
                                 class="rounded me-3"
                                 width="50" height="50">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="bi bi-person-fill text-white fs-5"></i>
                            </div>
                        @endif
                        <div>
                            <strong>{{ $artist->name }}</strong>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif

@if($albums->isNotEmpty())
    <div class="search-category mt-3">
        <h6 class="text-muted mb-2">Альбомы</h6>
        <ul class="list-group">
            @foreach($albums as $album)
                <li class="album-item list-group-item" data-id="{{ $album->id }}" data-type="album">
                    <div class="d-flex align-items-center">
                        @if($album->cover_image)
                            <img src="{{ asset($album->cover_image) }}" 
                                 alt="{{ $album->title }}" 
                                 class="rounded me-3"
                                 width="50" height="50">
                        @else
                            <div class="rounded bg-secondary d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="bi bi-disc text-white"></i>
                            </div>
                        @endif
                        <div>
                            <strong>{{ $album->title }}</strong>
                            <div class="text-muted small">{{ $album->artist->name }}</div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif

@if($tracks->isEmpty() && $artists->isEmpty() && $albums->isEmpty())
    <div class="text-muted p-3">Ничего не найдено</div>
@endif