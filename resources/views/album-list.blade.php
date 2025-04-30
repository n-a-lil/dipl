@foreach($albums as $album)
    <li class="album-item list-group-item" data-id="{{ $album->id }}">
        <div class="d-flex align-items-center">
            <img src="{{ $album->cover_image }}" 
                 alt="{{ $album->title }}" 
                 class="album-image rounded me-3"
                 width="60" height="60">
            <div class="album-info">
                <strong>{{ $album->title }}</strong>
                <small>{{ $album->artist->name }}</small>
            </div>
        </div>
    </li>
@endforeach