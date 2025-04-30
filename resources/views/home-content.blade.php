<div class="p-3 border bg-white">
    <h2 class="mb-3 d-flex justify-content-between align-items-center">
        Топ 10 треков
    </h2>
    <div class="d-flex flex-wrap gap-4">
        @foreach($topTracks as $track)
            @if($track)
                <div class="text-center track-card" 
                     data-src="{{ asset($track->file_path) }}" 
                     data-id="{{ $track->id }}"
                     data-title="{{ $track->title }}"
                     data-artist="{{ $track->artist->name ?? 'Неизвестный артист' }}"
                     data-cover="{{ asset($track->image) }}">
                    <div class="position-relative">
                        <img src="{{ asset($track->image) }}" 
                             alt="{{ $track->title }}" 
                             class="rounded track-cover" 
                             width="160" height="160">
                        <button class="btn-play btn btn-primary rounded-circle position-absolute" 
                                style="width: 48px; height: 48px; bottom: 10px; right: 10px;">
                            ♬
                        </button>
                    </div>
                    <p class="mt-2 fw-bold" style="font-size: 18px;">{{ $track->title }}</p>
                    <p class="text-muted" style="font-size: 16px;">
                        @if($track->artist)
                            <span class="text-dark" onclick="loadArtist('{{ $track->artist->id }}')">
                                {{ $track->artist->name }}
                            </span>
                        @else
                            <span class="text-danger">Неизвестный артист</span>
                        @endif
                    </p>
                    <p class="text-warning" style="font-size: 16px;">
                        ⭐ {{ number_format($track->ratings_avg_rating ?? 0, 1) }}
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
            @endif
        @endforeach
    </div>

    <h2 class="mb-3 d-flex justify-content-between align-items-center">
        Топ 10 альбомов
    </h2>
    <div class="d-flex flex-wrap gap-4">
        @foreach($topAlbums as $album)
            @if($album)
            <div class="text-center album-card position-relative" 
                    data-id="{{ $album->id }}"
                    data-first-track-id="{{ $album->tracks->first()->id ?? '' }}"
                    data-first-track-src="{{ asset($album->tracks->first()->file_path ?? '') }}"
                    data-first-track-title="{{ $album->tracks->first()->title ?? '' }}"
                    data-first-track-artist="{{ $album->artist->name ?? 'Неизвестный артист' }}"
                    data-first-track-cover="{{ asset($album->cover_image) }}">
                    <div class="position-relative">
                        <img src="{{ asset($album->cover_image) }}" 
                            alt="{{ $album->title }}" 
                            class="rounded album-cover" 
                            width="200" height="200"
                            style="cursor: pointer;"
                            onclick="loadAlbumTracks({{ $album->id }})">
                        <button class="btn-play-album btn btn-primary rounded-circle position-absolute" 
                                style="width: 48px; height: 48px; bottom: 10px; right: 10px;"
                                onclick="playFirstTrackOfAlbum(event, {{ $album->id }})">
                            ♬
                        </button>
                    </div>
                    <p class="mt-2 fw-bold" onclick="loadAlbumTracks({{ $album->id }})">{{ $album->title }}</p>
                    <p class="text-muted">{{ $album->artist->name ?? 'Неизвестный артист' }}</p>
                    <p class="text-warning" style="font-size: 16px;">
                        ⭐ {{ number_format($album->ratings_avg_rating ?? 0, 1) }}
                    </p>
                    <p class="text-muted small">{{ $album->tracks->count() }} треков</p>
                </div>
            @endif
        @endforeach
    </div>

    <h2 class="mt-5 mb-3">Топ 10 рецензий</h2>
    <div class="d-flex flex-wrap gap-4">
        @foreach($topReviews as $review)
            @if($review)
                <div class="border p-3 bg-light rounded" style="width: 24%;">
                    @if ($review->user)
                        <h5 class="fw-bold">{{ $review->user->username }}</h5>
                    @endif

                    <p class="text-muted mb-1">{{ $review->track->title ?? 'Без названия' }}</p>
                    <p>"{{ Str::limit($review->text ?? '', 100) }}"</p>

                    <p class="text-danger fw-bold" onclick="likeReview({{ $review->id }})">
                        <span id="heart-icon-{{ $review->id }}" class="{{ ($review->likes_count ?? 0) > 0 ? 'liked' : '' }}">
                            ❤
                        </span> 
                        <span id="like-count-{{ $review->id }}">{{ $review->likes_count ?? 0 }}</span>
                    </p>
                </div>
            @endif
        @endforeach
    </div>
</div>