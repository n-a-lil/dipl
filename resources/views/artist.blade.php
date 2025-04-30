<div class="p-3 border bg-white">
    <h2 class="mb-3" onclick="loadArtistRatings({{ $artist->id }})">{{ $artist->name }}</h2>
    <p>{{ $artist->bio }}</p>

    <!-- Кнопки переключения с теми же ID, что и в других разделах -->
    <div class="mb-4">
        <button id="btn-track" class="btn btn-primary me-2" 
                onclick="loadArtistTracks({{ $artist->id }})">Треки</button>
        <button id="btn-albums" class="btn btn-secondary me-2" 
                onclick="loadArtistAlbums({{ $artist->id }})">Альбомы</button>
    </div>

    <div id="artist-content">
        <!-- Контент будет загружаться здесь -->
    </div>
</div>