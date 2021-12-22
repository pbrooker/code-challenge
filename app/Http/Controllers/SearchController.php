<?php

namespace App\Http\Controllers;

use App\Services\SpotifyService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function search(Request $request, SpotifyService $spotifyService)
    {
        $query = $request->get('query');

        // default to search for three types as per challenge scope
        $search = $spotifyService->search($query, ['album', 'artist', 'track']);

        $resultViews = $this->renderResults($search);

        return view('search', ['searchTerm' => $query], ['resultViews' => $resultViews]);
    }

    private function renderResults($results): array
    {
        $resultViews = [];
        foreach ($results as $type => $result) {
            $resultViews[$type] = view('partials._result-list', ['type' => \ucfirst($type), 'items' => $this->processItems($result->items, $type)])->render();
        }
        return $resultViews;
    }

    private function processItems($items, $type)
    {
        $processedItems = [];
        foreach ($items as $item) {
            $indexImageUrl =  "https://via.placeholder.com/60"; // set default image if no image is returned with item
            if (!empty($item->images) || $type == 'tracks' && !empty($item->album->images)) {
                $images = $type != 'tracks' ? $item->images : $item->album->images;
                foreach ($images as $image) {
                    if ($image->height < 300) {
                        $indexImageUrl = $image->url;
                        break;
                    }
                }
            }

            $processedItems[] = [
                'id' => $item->id,
                'name' => $item->name,
                'type' => $item->type,
                'imageUrl' =>   $indexImageUrl
            ];
        }
        return $processedItems;
    }
}
