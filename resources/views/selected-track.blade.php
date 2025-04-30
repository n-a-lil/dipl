<div class="p-3 border bg-white">
    <div class="d-flex align-items-center">
        <img src="{{ $track->image }}" 
             alt="{{ $track->title }}" 
             class="track-image rounded me-3"
             width="80" height="80">
        <div class="track-info">
            <strong>{{ $track->title }}</strong>
            <small>{{ $track->artist->name }}</small> 
        </div>
    </div>
</div>