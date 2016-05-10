<?php

namespace spec\danb\Lastfm;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp\Client;

class LastfmDaoSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client, 'api-key-value');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('danb\Lastfm\LastfmDao');
    }

    function it_can_correctly_request_top_artists_by_country(Client $client)
    {
        $client->request('GET', null, $this->paramsForTopArtistsByCountry())
               ->shouldBeCalled();
        $this->getTopArtistsByCountry('australia', 5, 1);

        $client->request('GET', null, $this->paramsForTopArtistsByCountry(7, 99, 'foo'))
               ->shouldBeCalled();
        $this->getTopArtistsByCountry('foo', 7, 99);
    }

    function it_should_default_to_limit_5_and_page_1(Client $client)
    {
        $client->request('GET', null, $this->paramsForTopArtistsByCountry(5, 1))
               ->shouldBeCalled();
        $this->getTopArtistsByCountry('australia');
    }

    private function paramsForTopArtistsByCountry(
        $limit = 5,
        $page = 1,
        $country = 'australia',
        $api_key = 'api-key-value'
    ) {
        return array(
            'method' => 'geo.gettopartists',
            'country' => $country,
            'api_key' => $api_key,
            'format' => 'json',
            'limit' => $limit,
            'page' => $page
        );
    }
}
