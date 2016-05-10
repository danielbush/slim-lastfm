<?php

namespace danb\Lastfm;

use GuzzleHttp\Client;

class Dao implements DaoInterface
{
    public function __construct(Client $client, string $api_key)
    {
        $this->client = $client;
        $this->api_key = $api_key;
    }

    public function getTopArtistsByCountry(string $country, int $limit = 5, int $page = 1)
    {
        $this->client->request('GET', null, array(
            'method' => 'geo.gettopartists',
            'country' => $country,
            'api_key' => $this->api_key,
            'format' => 'json',
            'limit' => $limit,
            'page' => $page
        ));
    }
}
