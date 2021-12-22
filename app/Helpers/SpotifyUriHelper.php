<?php

namespace App\Helpers;

// note: a little overkill, but it's a good example of how to use helpers that could potentially be used in other places
class SpotifyUriHelper
{
    public static function ArtistUrl(string $artistId): string
    {
        return 'artists/' . $artistId;
    }

    public static function AlbumUrl(string $albumId): string
    {
        return 'albums/' . $albumId;
    }

    public static function TrackUrl(string $trackId): string
    {
        return 'tracks/' . $trackId;
    }
}