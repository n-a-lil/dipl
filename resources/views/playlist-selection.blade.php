<div id="playlistModal" class="modal-container">
    <div class="modal-content bg-white p-4 rounded">
        <h3>Выберите плейлист</h3>
        <div class="playlist-list mt-3" id="playlistList">
            @foreach($playlists as $playlist)
                <div class="playlist-item d-flex justify-content-between align-items-center p-2 border-bottom">
                    <span>{{ $playlist->name }}</span>
                    <button class="btn btn-sm btn-primary js-select-playlist" 
                            data-playlist="{{ $playlist->id }}"
                            data-track="{{ $trackId }}">
                        Выбрать
                    </button>
                </div>
            @endforeach
        </div>
        <button class="btn btn-secondary mt-3 js-close-modal">Закрыть</button>
    </div>
</div>