<?php

namespace danb\Lastfm;

interface DaoInterface
{
    public function getTopArtistsByCountry($country, $limit, $page);
    public function getTopTracksByArtist($mbid, $limit, $page);
}
