<div class="p-3 border bg-white">
    <div class="text-center track-card" 
         data-src="{{ asset($track->file_path) }}" 
         data-id="{{ $track->id }}"
         data-title="{{ $track->title }}"
         data-artist="{{ $track->artist->name ?? 'Неизвестный артист' }}"
         data-cover="{{ asset($track->image) }}"
         data-artist-id="{{ $track->artist->id ?? '' }}">
        <div class="position-relative" style="max-width: 300px; margin: 0 auto;">
            <img src="{{ asset($track->image) }}" 
                 alt="{{ $track->title }}" 
                 class="rounded track-cover" 
                 width="250" height="250">
            <button class="btn-play btn btn-primary rounded-circle position-absolute" 
                    style="width: 60px; height: 60px; bottom: 10px; right: 10px;">
                ♬
            </button>
        </div>
        <h2 class="mt-3">{{ $track->title }}</h2>
        <p class="text-muted fs-5">
            @if($track->artist)
                <span class="text-dark" onclick="loadArtist('{{ $track->artist->id }}')">
                    {{ $track->artist->name }}
                </span>
            @else
                <span class="text-danger">Неизвестный артист</span>
            @endif
        </p>
        <p class="text-warning fs-4">
            ⭐ {{ number_format($averageRating ?? 0, 1) }}
            <small class="text-muted">({{ $track->ratings->count() }} оценок)</small>
        </p>
        @if($userRating)
            <p class="fs-5">Ваша оценка: <span class="text-warning">{{ $userRating->rating }}</span></p>
        @endif
        <div class="listen-count text-muted fs-5">
            <i class="bi bi-headphones"></i> {{ $track->listen_count }} прослушиваний
        </div>
    </div>

    <!-- Рецензии -->
    <div class="mt-5">
        <h3>Рецензии</h3>
        @if($reviews->isEmpty())
            <p>Пока нет рецензий</p>
        @else
            @foreach($reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5>{{ $review->user->username }}</h5>
                            <small class="text-muted">{{ $review->created_at->format('d.m.Y') }}</small>
                        </div>
                        <p class="card-text">{{ $review->text }}</p>
                        <div>
                            <span class="text-danger" style="cursor: pointer;" 
                                  onclick="likeReview({{ $review->id }})">
                                ❤ <span id="like-count-{{ $review->id }}">{{ $review->likes->count() }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        
    </div>
</div>