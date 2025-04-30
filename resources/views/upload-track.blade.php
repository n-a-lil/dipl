<div class="p-3 border bg-white">
    <h2>Загрузить трек</h2>
    <form id="uploadForm" enctype="multipart/form-data" onsubmit="event.preventDefault(); addTrack();">
    @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Название трека</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Жанр</label>
            <select class="form-control" id="genre" name="genre_id" required>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="audio_file" class="form-label">Аудиофайл</label>
            <input type="file" class="form-control" id="audio_file" name="audio_file" accept="audio/*" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Обложка трека</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Загрузить</button>
        </form>
    <div id="uploadStatus" class="mt-3"></div>
</div>
