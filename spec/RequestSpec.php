<?php

namespace spec\danb\Lastfm;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;

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

    function it_can_decode_json_responses(Client $client, Response $response)
    {
        $this->beConstructedWith('http://base-uri', 'api-key-value');
        $this->client = $client; // Put our mock in.
        $client->request('GET', null, array('query' => array()))
               ->willReturn($response);
        $response->getBody()->willReturn('{"some": "response"}');
        $this->get(array())
             ->shouldBe(array('some' => 'response'));
    }

    function it_can_tidy_up_lastfm_hash_text_keys()
    {
        $this->tidyUpKeys(array('#text' => 'some text', 'other' => 456))
             ->shouldBeLike(array('text' => 'some text', 'other' => 456));
    }

    function it_should_use_args_as_query_params(Client $client, Response $response)
    {
        $this->beConstructedWith('http://base-uri', 'api-key-value');
        $this->client = $client; // Put our mock in.
        $client->request('GET', null, array('query' => array('method' => 'method1')))
               ->shouldBeCalled()
               ->willReturn($response);
        $response->getBody()->willReturn('{"some": "response"}');
        $this->get(array('method' => 'method1'));
    }
}
