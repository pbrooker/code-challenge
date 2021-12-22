<div class="col-md">
    <div class="card">
        <img class="card-img-top" src="{{ $detail['image'] }}" alt="{{ $detail['name'] }}" style="max-height: 300px;">
        <div class="card-body">
            <h5 class="card-title">{{ $detail['name'] }}</h5>
        </div>
    </div>
</div>
<div class="col-md">
    <div class="card">
        <div class="card-header">
            <h5>Details</h5>
        </div>
        <div class="card-body">
            <p class="card-text">Genres:</p>
            <ul>
                @forelse ($detail['genres'] as $genre)
                    <li>{{ $genre }}</li>
                @empty
                    <li>N/A</li>
                @endforelse
            </ul>
            <p class="card-text">Popularity: {{ $detail['popularity'] }}</p>
            <p class="card-text">Followers: {{ $detail['followers'] }}</p>
        </div>
    </div>
</div>