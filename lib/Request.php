<?php

namespace danb\Lastfm;

use GuzzleHttp\Client;

class Request
{
    public function __construct($base_uri, $api_key)
    {
        $this->client = new Client(array('base_uri' => $base_uri));
        $this->api_key = $api_key;
    }

    public function get(array $queryParams)
    {
        $response = $this->makeRequest($queryParams);
        $json = (string)$response->getBody();
        $response = $this->decodeResponse($json);
        $response = $this->tidyUp($response);
        return $response;
    }

    private function makeRequest(array $queryParams)
    {
        $response = $this->client->request('GET', null, array('query' => $queryParams));
        return $response;
    }

    private function decodeResponse($json)
    {
        return json_decode($json, true);
    }

    public function tidyUpKeys(array $arr)
    {
        if (isset($arr['#text'])) {
            $arr['text'] = $arr['#text'];
            unset($arr['#text']);
        }
        return $arr;
    }

    protected function tidyUp(array $response)
    {
        return $response;
    }
}
