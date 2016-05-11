<?php

namespace danb\Lastfm;

use GuzzleHttp\Client;

class Dao implements DaoInterface
{
    public function __construct(string $base_uri, string $api_key)
    {
        $this->base_uri = $base_uri;
        $this->api_key = $api_key;
        $this->request = new Request($this->base_uri, $this->api_key);
    }

    public function getTopArtistsByCountry(string $country, int $limit = 5, int $page = 1)
    {
        $this->request->get(array(
            'method' => 'geo.gettopartists',
            'country' => $country,
            'api_key' => $this->api_key,
            'format' => 'json',
            'limit' => $limit,
            'page' => $page
        ));
    }
    public function getTopTracksByArtist(string $mbid, int $limit = 5, int $page = 1)
    {
        $this->request->get(array(
            'method' => 'artist.gettoptracks',
            'mbid' => $mbid,
            'api_key' => $this->api_key,
            'format' => 'json',
            'limit' => $limit,
            'page' => $page
        ));
    }
}
