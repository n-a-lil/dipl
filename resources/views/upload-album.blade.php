<div class="p-3 border bg-white">
    <h2>Загрузить альбом</h2>
    <form id="uploadAlbumForm" enctype="multipart/form-data" onsubmit="event.preventDefault(); addAlbum();">
    @csrf
        <div class="mb-3">
            <label for="album_title" class="form-label">Название альбома</label>
            <input type="text" class="form-control" id="album_title" name="album_title" required>
        </div>
        <div class="mb-3">
            <label for="genre_id" class="form-label">Жанр</label>
            <select class="form-control" id="genre_id" name="genre_id" required>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Обложка альбома</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="tracks" class="form-label">Треки (минимум 2)</label>
            <input type="file" class="form-control" id="tracks" name="tracks[]" accept="audio/*" multiple required>
        </div>
        <button type="submit" class="btn btn-primary">Загрузить альбом</button>
        </form>
    <div id="uploadStatus" class="mt-3"></div>
</div>
