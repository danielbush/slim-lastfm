<?php

namespace danb\Lastfm;

interface DaoInterface
{
    public function getTopArtistsByCountry(string $country, int $limit, int $page);
    public function getTopTracksByArtist(string $mbid, int $limit, int $page);
}
