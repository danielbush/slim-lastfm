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

    /**
     * TODO: might be better to create Artist class (ie a model) and get it to parse the xml.
     * Then we just have a list of Artists to render.
     * We could generate this list by taking the output below.
     *
     * @return array
     */
    public function getTopArtistsByCountry($country, $limit = 5, $page = 1)
    {
        $response = $this->request->get(array(
            'method' => 'geo.gettopartists',
            'country' => $country,
            'api_key' => $this->api_key,
            'format' => 'json',
            'limit' => $limit,
            'page' => $page
        ));
        if (isset($response['topartists'])) {
            return $response['topartists'];
        }
        return null;
    }

    public function getTopTracksByArtist($mbid, $limit = 5, $page = 1)
    {
        $response = $this->request->get(array(
            'method' => 'artist.gettoptracks',
            'mbid' => $mbid,
            'api_key' => $this->api_key,
            'format' => 'json',
            'limit' => $limit,
            'page' => $page
        ));
        if (isset($response['toptracks'])) {
            return $response['toptracks'];
        }
        return null;
    }
}
