<?php

namespace App\Http\Controllers;

use App\Services\SpotifyService;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function show(Request $request, SpotifyService $spotifyService)
    {
        $id = $request->id;
        $type = $request->type;
        $name = $request->name;

        try {
            $item = $spotifyService->getItem($type, $id);
            $detail = [];
            if ($item) {
                $details = $this->processItem($type, $item);
                $detail['name'] = $name;
                $detail['type'] = \rtrim(\ucfirst($type), 's'); // remove 's' from type as needed for api route, but not for view
                $detail['item_view'] = $this->renderDetail($type, $details);
            }
        } catch (\Exception $e) {
            $detail = [];
        }

        return view('show', ['detail' => $detail]);
    }

    private function renderDetail($type, $detail)
    {
        return view('partials.detail_partials._' . $type . '-detail', ['detail' => $detail]);
    }

    private function processItem(string $type, $item): array
    {
        $details = [];
        switch ($type) {
            case 'albums':
                $details = $this->processAlbum($item);
                break;
            case 'artists':
                $details = $this->processArtist($item);
                break;
            case 'tracks':
                $details = $this->processTrack($item);
                break;
        }

        return $details;
    }

    private function processAlbum($album): array
    {
        $image = "https://via.placeholder.com/300"; // set default image if no image is returned with item
        if (!empty($album->images)) {
            foreach ($album->images as $image) {
                if ($image->height >= 300) {
                    $image = $image->url;
                    break;
                }
            }
        }

        if (!empty($album->artists)) {
            $artists = [];
            foreach ($album->artists as $artist) {
                $artists[] = ['name' => $artist->name, 'url' => route('detail.show', ['type' => 'artists', 'id' => $artist->id, 'name' => $artist->name])];
            }
        }

        if (!empty($album->copyrights)) {
            $copyrights = [];
            foreach ($album->copyrights as $copyright) {
                $copyrights[] = $copyright->text;
            }
        }

        if (!empty($album->tracks)) {
            $tracks = [];
            foreach ($album->tracks->items as $track) {
                if (!empty($track->duration_ms)) {
                    $duration = \gmdate('i:s', $track->duration_ms / 1000);
                } else {
                    $duration = '0:00';
                }

                if (!empty($track->artists)) {
                    $trackArtists = [];
                    foreach ($track->artists as $artist) {
                        $trackArtists[] = ['name' => $artist->name, 'url' => route('detail.show', ['type' => 'artists', 'id' => $artist->id, 'name' => $artist->name])];
                    }
                }

                $tracks[] = [
                    'name' => $track->name,
                    'url' => route('detail.show', ['type' => 'tracks', 'id' => $track->id, 'name' => $track->name]),
                    'track_number' => $track->track_number,
                    'duration' => $duration,
                    'explicit' => $track->explicit,
                    'artists' => $trackArtists ?? ['N/A'],
                ];
            }
        }

        return [
            'name' => $album->name,
            'genres' => $album->genres ?? ['N/A'],
            'artists' => $artists ?? ['N/A'],
            'markets' => \count($album->available_markets) ?? 0,
            'image' => $image ?? null,
            'tracks' => $tracks ?? ['N/A'],
            'label' => $album->label ?? 'N/A',
            'popularity' => $album->popularity ?? 0,
            'release_date' => $album->release_date ?? 'N/A',
            'total_tracks' => $album->total_tracks ?? 0,
            'album_type' => $album->album_type ?? 'N/A',
        ];
    }

    private function processArtist($artist): array
    {
        $image = "https://via.placeholder.com/300"; // set default image if no image is returned with item
        if (!empty($artist->images)) {
            foreach ($artist->images as $image) {
                if ($image->height >= 300) {
                    $image = $image->url;
                    break;
                }
            }
        }

        return [
            'name' => $artist->name,
            'genres' => $artist->genres ?? ['N/A'],
            'popularity' => $artist->popularity ?? 'N/A',
            'followers' => $artist->followers->total ?? 'N/A',
            'image' => $image ?? null,
        ];
    }

    private function processTrack($track): array
    {
        if (!empty($track->album)) {
            $albumName = $track->album->name;
            $albumUrl = route('detail.show', ['type' => 'albums', 'id' => $track->album->id, 'name' => $track->album->name]);
            if (!empty($track->album->images)) {
                foreach ($track->album->images as $image) {
                    if ($image->height >= 300) {
                        $image = $image->url;
                        break;
                    }
                }
            }
        }

        if (!empty($track->duration_ms)) {
            $duration = \gmdate('i:s', $track->duration_ms / 1000);
        } else {
            $duration = '0:00';
        }

        if (!empty($track->artists)) {
            $trackArtists = [];
            foreach ($track->artists as $artist) {
                $trackArtists[] = ['name' => $artist->name, 'url' => route('detail.show', ['type' => 'artists', 'id' => $artist->id, 'name' => $artist->name])];
            }
        }

        return [
            'name' => $track->name,
            'track_number' => $track->track_number,
            'duration' => $duration,
            'explicit' => $track->explicit,
            'artists' => $trackArtists ?? ['N/A'],
            'disk_number' => $track->disc_number,
            'album_name' => $albumName ?? 'N/A',
            'album_url' => $albumUrl ?? 'N/A',
            'image' => $image ?? null,
            'popularity' => $track->popularity ?? 0,
        ];
    }
}