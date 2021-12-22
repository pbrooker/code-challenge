<div class="col-md">
    <div class="card ">
        <img class="card-img-top" src="{{ $detail['image'] }}" alt="{{ $detail['name'] }}" style="max-height: 300px;">
        <div class="card-body">
            <h5 class="card-title">{{ $detail['name'] }}</h5>
            <p class="card-text">Label: {{ $detail['label'] }}</p>
            <p class="card-text">Album Type: {{ $detail['album_type'] }}</p>
            <p class="card-text">Release Date: {{ $detail['release_date'] }}</p>
            <p class="card-text">Total Tracks: {{ $detail['total_tracks'] }}</p>
            <p class="card-text"># Markets: {{ $detail['markets'] }}</p>
            <p class="card-text">Popularity: {{ $detail['popularity'] }}</p>
            <p class="card-text">Artists:</p>
            <ul>
                @forelse ($detail['artists'] as $artist)
                    <li><a class="text-blue" href="{{ $artist['url'] }}">{{ $artist['name'] }}</a></li>
                @empty
                    <li>N/A</li>
                @endforelse
            </ul>
            <p class="card-text">Genres:</p>
            <ul>
                @forelse ($detail['genres'] as $genre)
                    <li>{{ $genre }}</li>
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
            <h5>Album Tracks</h5>
        </div>
        <div class="card-body">
            @forelse($detail['tracks'] as $track)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><a class="text-blue" href="{{ $track['url'] }}">{{ $track['name'] }}</a></h5>
                        <p class="card-text">Artists:</p>
                        @forelse($track['artists'] as $artist)
                            <p class="card-text"><a class="text-blue" href="{{ $artist['url'] }}">{{ $artist['name'] }}</a></p>
                        @empty
                            <p class="card-text">N/A</p>
                        @endforelse
                        <p class="card-text">Track #: {{ $track['track_number'] }}</p>
                        <p class="card-text">Duration: {{ $track['duration'] }}</p>
                        <p class="card-text">Explicit: {{ ($track['explicit']) ? "Yes" : "No" }}</p>
                    </div>
                </div>
            @empty
                <p>N/A</p>
            @endforelse
        </div>
    </div>
</div>


