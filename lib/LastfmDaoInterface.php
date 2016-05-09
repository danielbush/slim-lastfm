<?php

namespace danb\Lastfm;

interface LastfmDaoInterface
{
    public function getTopArtistsByCountry(string $country, int $limit, int $page);
}
