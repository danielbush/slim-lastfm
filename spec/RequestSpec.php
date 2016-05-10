<?php

namespace spec\danb\Lastfm;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp\Client;

class RequestSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('http://base-uri', 'api-key-value');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('danb\Lastfm\Request');
    }

    function it_should_have_a_guzzle_http_client()
    {
        $this->client->shouldHaveType('GuzzleHttp\\Client');
    }

    function it_should_set_base_uri_on_guzzle_client()
    {
        $this->client
             ->getConfig('base_uri') // Guzzle api
             ->__toString() // psr-7 api / magic method
             ->shouldBe('http://base-uri');
    }

    function it_should_store_api_key()
    {
        $this->api_key->shouldBe('api-key-value');
    }

    function it_can_decode_json_responses()
    {
        $this->decodeResponse('{"key1": [1, 2, 3]}')
             ->shouldBe(array('key1' => array(1, 2, 3)));
    }

    function it_can_tidy_up_lastfm_hash_text_keys()
    {
        $this->tidyUpKeys(array('#text' => 'some text', 'other' => 456))
             ->shouldBeLike(array('text' => 'some text', 'other' => 456));
    }

}
