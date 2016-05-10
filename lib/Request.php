<?php

namespace danb\Lastfm;

use GuzzleHttp\Client;

class Request
{
    final public function __construct(string $base_uri, string $api_key)
    {
        $this->client = new Client(array('base_uri' => $base_uri));
        $this->api_key = $api_key;
    }

    final public function get(array $queryParams)
    {
        $json = $this->makeRequest($queryParams);
        $response = $this->decodeResponse($json);
        $response = $this->tidyUp($response);
        return $response;
    }

    private function makeRequest(array $queryParams)
    {
        $response = $this->client->request('GET', null, $queryParams);
        return $response;
    }

    private function decodeResponse(string $json)
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
