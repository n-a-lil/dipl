<h3 class="mb-3">Редактировать плейлист</h3>
<form id="editPlaylistForm" onsubmit="event.preventDefault(); updatePlaylist({{ $playlist->id }});">
    @csrf
    <div class="mb-3">
        <label class="form-label">Название</label>
        <input type="text" class="form-control" name="name" value="{{ $playlist->name }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Обложка</label>
        <input type="file" class="form-control" name="image">
        @if($playlist->image)
            <div class="mt-2">
                <small>Текущая обложка:</small>
                <img src="{{ asset('storage/' . $playlist->image) }}" class="img-thumbnail mt-2" style="max-width: 150px;">
            </div>
        @endif
    </div>
    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" onclick="hideEditModal()">Отмена</button>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>