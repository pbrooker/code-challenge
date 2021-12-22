<?php

namespace App\Services;

use App\Helpers\SpotifyUriHelper;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class SpotifyService
{
    const LIMIT = 20;
    const  OFFSET = 0;
    const MARKET = "CA";
    const SPOTIFY_API_URL = 'https://api.spotify.com/v1/';
    const SPOTIFY_TOKEN_URL = 'https://accounts.spotify.com/api/token';
    protected $spotifyClientId;
    protected $spotifyClientSecret;
    protected $bearerToken;
    protected $clientToken;
    protected $clientTokenExpires;

    public function __construct($spotifyClientId = null, $spotifyClientSecret = null)
    {
        $this->spotifyClientId = $spotifyClientId ?? config('services.spotify.client_id');
        $this->spotifyClientSecret = $spotifyClientSecret ?? config('services.spotify.client_secret');
    }

    /**
     * Get the client credentials.
     *
     * @return self
     * @throws \Exception
     */
    protected function getClientCredentialsToken(): self
    {
        $guzzleClient = new GuzzleClient();

        try {
            $request = $guzzleClient->request('POST', self::SPOTIFY_TOKEN_URL, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accepts' => 'application/json',
                    'Authorization' => 'Basic ' . \base64_encode($this->spotifyClientId . ':' . $this->spotifyClientSecret),
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);
        } catch (ClientException $e) {
            throw new \Exception('An error occurred retrieving the client credentials.', \json_decode($e->getResponse()->getBody()->getContents()));
        }

        $response = \json_decode($request->getBody());
        $this->clientToken = $response->access_token;

        try {
            $interval = new \DateInterval('PT' . $response->expires_in.'S');
            $this->clientTokenExpires = (new \DateTime())->add($interval);
        } catch (\Exception $e) {
            throw new \Exception('An error occurred retrieving the client credentials.', json_decode($e->getMessage()));
        }

        return $this;
    }

    /**
     * make Spotify api request. Return the response.
     *
     * @return self
     * @throws \Exception
     */
    public function searchRequest(string $endpoint, string $method, array $data = []): \stdClass
    {
        if (($this->clientTokenExpires && new \DateTime() > $this->clientTokenExpires) || !$this->clientTokenExpires) {
            try {
                $this->getClientCredentialsToken();
            } catch (\Exception $e) {
                throw new \Exception('An error occurred retrieving the client credentials.', json_decode($e->getMessage()));
            }
        }

        $guzzleClient = new GuzzleClient();

        if (!empty($data)) {
            $endpoint .= '?' . \http_build_query($data);
        }

        try {
            $request = $guzzleClient->request($method, self::SPOTIFY_API_URL . $endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accepts' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->clientToken,
                ],
            ]);
        } catch (ClientException $e) {
            throw new \Exception('Spotify returned other than 200 OK.', json_decode($e->getMessage()));
        }

        return json_decode($request->getBody());
    }

    /**
     * Get a specific item by type
     * @param string $type
     * @param string $id
     * @return \stdClass|null
     * @throws \Exception
     */
    public function getItem(string $type, string $id)
    {
        switch ($type) {
            case 'albums':
                $endpoint = SpotifyUriHelper::AlbumUrl($id);
                break;
            case 'artists':
                $endpoint = SpotifyUriHelper::ArtistUrl($id);
                break;
            case 'tracks':
                $endpoint = SpotifyUriHelper::TrackUrl($id);
                break;
            default:
                return null;
        }

        return $this->searchRequest($endpoint, 'GET');
    }


    /**
     * assemble and perform a search request
     *
     * @param string $query
     * @param array $types
     * @param int $limit
     * @param int $offset
     *
     * @return \stdClass
     */
    public function search(string $query, array $types = ['track', 'artist', 'album' ], int $limit = self::LIMIT, int $offset = self::OFFSET): \stdClass
    {
        // Note, given the scope of this challenge, pagination was not included. However, if it had been, my approach would have been to
        // implement an ajax based pagination system on each of the individual search result types, and replace the contents of that div with the
        // new results.
        return $this->searchRequest('search', 'GET', [
            'q' => $query,
            'type' => \implode(",", $types),
            'limit' => $limit,
            'offset' => $offset,
            'market' => self::MARKET,
        ]);
    }
}