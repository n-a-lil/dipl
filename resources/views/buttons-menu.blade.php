<button class="btn btn-success btn-sm" onclick="showPlaylistSelection({{ $trackId }})">Добавить в плейлист</button>
@if(request()->is('my*'))
    <button class="btn btn-danger btn-sm" onclick="deleteTrack({{ $trackId }})">Удалить</button>
@endif