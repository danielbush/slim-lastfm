<?php

namespace spec\danb\Lastfm;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LastfmDaoSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('danb\Lastfm\LastfmDao');
    }
}
