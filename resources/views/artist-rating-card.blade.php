<div class="p-3 border bg-white">
    <div class="text-center">
        <h2>Рейтинги артиста: {{ $artist->name }}</h2>
        
        <div class="rating-summary mb-4">
            <p class="text-warning fs-1">
                ⭐ {{ $averageRating }}
            </p>
            <p class="text-muted">
                На основе {{ $totalRatings }} оценок
            </p>
        </div>

        <div class="rated-items">
            <h4 class="mb-3">Оцененные работы</h4>
            
            @if($trackRatings->isEmpty() && $albumRatings->isEmpty())
                <p>Пока нет оценок работ этого артиста</p>
            @else
                <div class="list-group">
                    @foreach($trackRatings as $rating)
                        @if($rating->track)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $rating->track->title }}</strong>
                                    <div class="text-muted small">Трек</div>
                                </div>
                                <div>
                                    <span class="text-warning">{{ $rating->rating }}</span>
                                    <small class="text-muted ms-2">
                                        {{ $rating->created_at->format('d.m.Y') }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @foreach($albumRatings as $rating)
                        @if($rating->album)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $rating->album->title }}</strong>
                                    <div class="text-muted small">Альбом</div>
                                </div>
                                <div>
                                    <span class="text-warning">{{ $rating->rating }}</span>
                                    <small class="text-muted ms-2">
                                        {{ $rating->created_at->format('d.m.Y') }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>