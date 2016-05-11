<?php

namespace spec\danb\Lastfm;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp\Client;
use danb\Lastfm\Request;

class DaoSpec extends ObjectBehavior
{
    function let(Request $request)
    {
        $this->beConstructedWith('https://base_uri', 'api-key-value');
        $this->request = $request;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('danb\Lastfm\Dao');
        $this->shouldImplement('danb\Lastfm\DaoInterface');
    }

    function it_can_correctly_request_top_artists_by_country(Request $request)
    {
        $request->get($this->paramsForTopArtistsByCountry(7, 99, 'foo'))
                ->shouldBeCalled();
        $this->getTopArtistsByCountry('foo', 7, 99);
    }

    function it_can_correctly_request_top_tracks_by_artist(Request $request)
    {
        $mbid = 'abcd-123';
        $request->get($this->paramsForTopTracksByArtist($mbid, 7, 99))
                ->shouldBeCalled();
        $this->getTopTracksByArtist($mbid, 7, 99);
    }

    function it_should_return_the_result_from_Request(Request $request)
    {
        $request->get($this->paramsForTopArtistsByCountry(7, 99, 'US'))
                ->willReturn(array("some" => "result"))
                ->shouldBeCalled();
        $this->getTopArtistsByCountry('US', 7, 99)->shouldBe(array("some" => "result"));

        // Below should probably be a separate test.
        // PHPSpec is presumably suggesting to us here that we are violating SRP
        // in our Dao class.

        $mbid = 'abcd-123';
        $request->get($this->paramsForTopTracksByArtist($mbid, 7, 99))
                ->willReturn(array("some" => "result"))
                ->shouldBeCalled();
        $this->getTopTracksByArtist($mbid, 7, 99)->shouldBe(array("some" => "result"));
    }

    function it_should_default_to_limit_5_and_page_1(Request $request)
    {
        $request->get($this->paramsForTopArtistsByCountry(5, 1))
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

    private function paramsForTopTracksByArtist($mbid, $limit, $page, $api_key = 'api-key-value')
    {
        return array(
            'method' => 'artist.gettoptracks',
            'mbid' => $mbid,
            'api_key' => $api_key,
            'format' => 'json',
            'limit' => $limit,
            'page' => $page
        );
    }
}
