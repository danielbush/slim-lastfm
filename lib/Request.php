<?php

namespace danb\Lastfm;

use GuzzleHttp\Client;

class Request
{
    public function __construct(string $base_uri, string $api_key)
    {
        $this->client = new Client(array('base_uri' => $base_uri));
        $this->api_key = $api_key;
    }

    final public function get()
    {
        $json = $this->makeRequest();
        $response = $this->decodeResponse($json);
        return $response;
    }

    protected function makeRequest()
    {
    }

    public function decodeResponse(string $json)
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
}
