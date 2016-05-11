<?php

namespace danb\Lastfm;

use GuzzleHttp\Client;

class Dao implements DaoInterface
{
    public function __construct($base_uri, $api_key)
    {
        $this->base_uri = $base_uri;
        $this->api_key = $api_key;
        $this->request = new Request($this->base_uri, $this->api_key);
    }

    public function getTopArtistsByCountry($country, $limit = 5, $page = 1)
    {
        return $this->request->get(array(
            'method' => 'geo.gettopartists',
            'country' => $country,
            'api_key' => $this->api_key,
            'format' => 'json',
            'limit' => $limit,
            'page' => $page
        ));
    }

    public function getTopTracksByArtist($mbid, $limit = 5, $page = 1)
    {
        return $this->request->get(array(
            'method' => 'artist.gettoptracks',
            'mbid' => $mbid,
            'api_key' => $this->api_key,
            'format' => 'json',
            'limit' => $limit,
            'page' => $page
        ));
    }
}
