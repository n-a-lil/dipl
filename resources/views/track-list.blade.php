@foreach($tracks as $track)
    <li class="track-item list-group-item" data-id="{{ $track->id }}">
        <div class="d-flex align-items-center">
            <img src="{{ $track->image}}" 
                 alt="{{ $track->title }}" 
                 class="track-image rounded me-3"
                 width="60" height="60">
            <div class="track-info">
                <strong>{{ $track->title }}</strong>
                <small>{{ $track->artist->name}}</small>
            </div>
        </div>
    </li>
@endforeach