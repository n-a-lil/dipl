<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
<div class="bg-light py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <button id="btn-home" class="btn btn-primary me-2" onclick="loadHome()">Главная</button>
            <button id="btn-history" class="btn btn-secondary me-2" onclick="loadHistoryTracks()">История</button>
            <button id="btn-all" class="btn btn-secondary me-2" onclick="showAll()">Все</button>
            <button id="btn-my" class="btn btn-secondary me-2" onclick="My()">Мое</button>
            <button id="btn-upload" class="btn btn-secondary me-2" onclick="showUpload()">Загрузить</button>
            <button id="btn-ratingtrack" class="btn btn-secondary me-2" onclick="openRatingModal()">Оценить трек</button>
            <button id="btn-ratingalbum" class="btn btn-secondary me-2" onclick="openAlbumRatingModal()">Оценить альбом</button>
            <button id="btn-playlists" class="btn btn-secondary me-2" onclick="playlists()">Плейлисты</button>
        </div>
        <div>
            @if(session('username'))
                <span class="me-3" id="user-profile" style="cursor: pointer;" onclick="loadProfile()">
                    Hello, {{ session('username') }}!
                </span>
                <a href="{{ route('auth.logout') }}" class="btn btn-success btn-sm">Logout</a>
            @else
                <a href="{{ route('auth.form') }}" class="btn btn-primary btn-sm">Login/Register</a>
            @endif
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="universal-search" class="form-control" placeholder="Поиск...">
            <div id="universal-search-results" class="mt-2"></div>
        </div>
    </div>
</div>

<!-- Основной контент -->
<div class="container mt-4">
    <div id="content">Загрузка...</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
<div id="mini-player" class="mini-player" style="display: none;">
    <div class="player-content">
        <img id="mini-cover" src="" class="mini-cover">
        <div class="track-info">
            <div id="mini-title" class="mini-title">No track selected</div>
            <div id="mini-artist" class="mini-artist">Unknown artist</div>
        </div>
        <div class="player-controls">
            <button id="prev-btn" class="control-btn">⏮</button>
            <button id="play-btn" class="control-btn">▶</button>
            <button id="next-btn" class="control-btn">⏭</button>
        </div>
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
    </div>
</div>
</body>
</html>