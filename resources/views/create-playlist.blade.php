<div class="p-3 border bg-white">
    <h2 class="mb-3">Создание нового плейлиста</h2>
    
    <div id="playlist-form">
        <div class="mb-3">
            <label for="playlist-name" class="form-label">Название плейлиста</label>
            <input type="text" class="form-control" id="playlist-name">
        </div>
        <div class="mb-3">
            <label for="playlist-image" class="form-label">Обложка плейлиста</label>
            <input type="file" class="form-control" id="playlist-image">
        </div>
        <div class="d-flex justify-content-end gap-2">
            <button class="btn btn-secondary" onclick="playlists()">Отмена</button>
            <button class="btn btn-primary" onclick="createPlaylist()">Создать</button>
        </div>
    </div>
</div>