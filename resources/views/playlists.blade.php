<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
<div class="p-3 border bg-white">
    <h2 class="mb-3 d-flex justify-content-between align-items-center">
        Мои плейлисты
        <button class="btn btn-primary btn-sm" onclick="showCreatePlaylistForm()">
            <i class="bi bi-plus"></i> Создать плейлист
        </button>
    </h2>
    
    <div class="playlists-wrapper" id="playlists-list">
        <!-- Избранное (нельзя удалить) -->
        @foreach($playlists->where('is_favorites', true) as $playlist)
            <div class="playlist-entry favorites-playlist" data-id="{{ $playlist->id }}">
                <div class="playlist-content" onclick="loadPlaylistTracks({{ $playlist->id }})">
                    <div class="playlist-cover placeholder">
                        <i class="bi bi-heart-fill text-danger"></i>
                    </div>
                    <span class="playlist-name">{{ $playlist->name }}</span>
                </div>
            </div>
        @endforeach
        
        <!-- Обычные плейлисты -->
        @foreach($playlists->where('is_favorites', false) as $playlist)
            <div class="playlist-entry" data-id="{{ $playlist->id }}">
                <div class="playlist-content" onclick="loadPlaylistTracks({{ $playlist->id }})">
                    @if($playlist->image)
                        <img src="{{ asset('storage/' . $playlist->image) }}" alt="Обложка" class="playlist-cover">
                    @else
                        <div class="playlist-cover placeholder"></div>
                    @endif
                    <span class="playlist-name">{{ $playlist->name }}</span>
                </div>
                <div class="playlist-actions">
                    <button class="edit-playlist-btn" onclick="showEditPlaylistForm({{ $playlist->id }})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="delete-playlist-btn" onclick="deletePlaylist(event, {{ $playlist->id }})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div id="editPlaylistModal" class="modal-container" style="display: none;">
    <div class="modal-content bg-white p-4 rounded">
        <div id="edit-playlist-form-container"></div>
    </div>
</div>