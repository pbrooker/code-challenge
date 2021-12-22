<div class="col-md">
    <div class="card">
        <img class="card-img-top" src="{{ $detail['image'] }}" alt="{{ $detail['name'] }}" style="max-height: 300px;">
        <div class="card-body">
            <h5 class="card-title">{{ $detail['name'] }}</h5>
            <p class="card-text">Album: <a class="text-blue" href="{{ $detail['album_url'] }}">{{ $detail['album_name'] }}</a></p>
            <p class="card-text">Artists:</p>
            <ul>
                @forelse ($detail['artists'] as $artist)
                    <li><a class="text-blue" href="{{ $artist['url'] }}">{{ $artist['name'] }}</a></li>
                @empty
                    <li>N/A</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
<div class="col-md">
    <div class="card">
        <div class="card-header">
            <h5>Details</h5>
        </div>
        <div class="card-body">
            <p class="card-text">Track #: {{ $detail['track_number'] }}</p>
            <p class="card-text">Disk #: {{ $detail['disk_number'] }}</p>
            <p class="card-text">Duration: {{ $detail['duration'] }}</p>
            <p class="card-text">Explicit: {{ ($detail['explicit']) ? "Yes" : "No" }}</p>
            <p class="card-text">Popularity: {{ $detail['popularity'] }}</p>
        </div>
    </div>
</div>