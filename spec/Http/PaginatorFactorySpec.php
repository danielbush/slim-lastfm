<?php

namespace spec\danb\Lastfm\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use JasonGrimes\Paginator;
use danb\Lastfm\Http\PaginatorFactory;
use PHPUnit_Framework_Assert as Assert; // TODO: probably should have just used phpunit

class PaginatorFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('danb\Lastfm\Http\PaginatorFactory');
    }

    function it_can_use_lastfm_pagination_params()
    {
        $params = array(
            "total" => "1046383",
            "totalPages" => "209277",
            "perPage" => "5",
            "page" => "1"
        );
        $response = PaginatorFactory::useLastfmParams($params, "/some/url/(:num)");
        Assert::assertEquals('JasonGrimes\Paginator', get_class($response));
        Assert::assertRegexp('/class.*pagination/', (string)$response);
    }

    function it_will_return_null_if_bad_params(Paginator $paginator)
    {
        $params = array(
            "totalPages" => "209277",
            "perPage" => "5",
            "page" => "1"
        );
        $response = PaginatorFactory::useLastfmParams($params, "/some/url/(:num)");
        Assert::assertNull($response);
        // TODO: other cases
    }
}
