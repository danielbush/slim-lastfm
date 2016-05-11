<?php

namespace danb\Lastfm;

/**
 * Stub for a data access object (DAO) that will retrieve data from Lastfm.
 */
class DaoStub implements DaoInterface
{
    public function __construct()
    {
    }

    /**
     * Stub for http://www.last.fm/api/show/geo.getTopArtists.
     *
     * @return array $result
     *
     * $result['artists'] is indexed array of artist data
     * $result['artists'][$n] is an assoc array of artist data
     * $result['attr'] is assoc array of metadata
     */
    public function getTopArtistsByCountry($country, $limit = 5, $page = 1)
    {
        $result = array();
        $result['artists'] = array_map(function ($num) {
            return $this->makeArtist("Artist $num");
        }, range(1, $limit));
        $result['attr'] = $this->makePagination();
        $result['attr']['country'] = "Australia"; // ucfirst
        return $result;
    }

    /**
     * Stub for http://www.last.fm/api/show/artist.getTopTracks.
     *
     * @return array $result
     *
     */
    public function getTopTracksByArtist($mbid, $limit = 5, $page = 1)
    {
        $result = array();
        $result['track'] = array_map(function ($num) {
            return $this->makeTrack("track $num");
        }, range(1, $limit));
        $result['attr'] = $this->makePagination();
        $result['attr']['artist'] = "Artist Name";
        return $result;
    }

    /**
     * Return some made up pagination data as would be returned by lastfm.
     */
    private function makePagination()
    {
        $attr = <<<EOF
          {
            "total": "1046383",
            "totalPages": "209277",
            "perPage": "5",
            "page": "1"
          }
EOF;
        return json_decode($attr, true);
    }

    /**
     * Make track data as would be returned by lastfm artist.getTopTracks with
     * some modifications.
     */
    private function makeTrack($trackName)
    {
        $track = <<<EOF
          {
            "@attr": {
              "rank": "1"
            },
            "image": [
              {
                "size": "small",
                "#text": "http:\/\/img2-ak.lst.fm\/i\/u\/34s\/917546c2369a42e3a46ba2ad9dca9e73.png"
              },
              {
                "size": "medium",
                "#text": "http:\/\/img2-ak.lst.fm\/i\/u\/64s\/917546c2369a42e3a46ba2ad9dca9e73.png"
              },
              {
                "size": "large",
                "#text": "http:\/\/img2-ak.lst.fm\/i\/u\/174s\/917546c2369a42e3a46ba2ad9dca9e73.png"
              },
              {
                "size": "extralarge",
                "#text": "http:\/\/img2-ak.lst.fm\/i\/u\/300x300\/917546c2369a42e3a46ba2ad9dca9e73.png"
              }
            ],
            "artist": {
              "url": "http:\/\/www.last.fm\/music\/David+Bowie",
              "mbid": "5441c29d-3602-4898-b1a1-b77fa23b8e50",
              "name": "David Bowie"
            },
            "streamable": "0",
            "url": "http:\/\/www.last.fm\/music\/David+Bowie\/_\/Ziggy+Stardust",
            "mbid": "b1b29af7-2190-4d0f-9aa8-fe397105679c",
            "listeners": "706796",
            "playcount": "4127845",
            "name": "$trackName"
          }
EOF;
        $track = json_decode($track, true);
        // Rewrite '#text' - it's awkward to use.
        $track['attr'] = $track['@attr'];
        $track['image'] = array_map(function ($img) {
            $img['src'] = $img['#text'];
            return $img;
        }, $track['image']);
        return $track;
    }

    /**
     * Make artist data as would be returned by lastfm geo.getTopArtists with
     * some modifications.
     */
    private function makeArtist($artistName)
    {
        $artist = <<<EOF
          {
            "image": [
              {
                "size": "small",
                "#text": "http:\/\/img2-ak.lst.fm\/i\/u\/34s\/917546c2369a42e3a46ba2ad9dca9e73.png"
              },
              {
                "size": "medium",
                "#text": "http:\/\/img2-ak.lst.fm\/i\/u\/64s\/917546c2369a42e3a46ba2ad9dca9e73.png"
              },
              {
                "size": "large",
                "#text": "http:\/\/img2-ak.lst.fm\/i\/u\/174s\/917546c2369a42e3a46ba2ad9dca9e73.png"
              },
              {
                "size": "extralarge",
                "#text": "http:\/\/img2-ak.lst.fm\/i\/u\/300x300\/917546c2369a42e3a46ba2ad9dca9e73.png"
              },
              {
                "size": "mega",
                "#text": "http:\/\/img2-ak.lst.fm\/i\/u\/917546c2369a42e3a46ba2ad9dca9e73.png"
              }
            ],
            "streamable": "0",
            "url": "http:\/\/www.last.fm\/music\/David+Bowie",
            "mbid": "5441c29d-3602-4898-b1a1-b77fa23b8e50",
            "listeners": "3084016",
            "name": "$artistName"
          }
EOF;
        $artist = json_decode($artist, true);
        // Rewrite '#text' - it's awkward to use.
        $artist['image'] = array_map(function ($img) {
            $img['src'] = $img['#text'];
            return $img;
        }, $artist['image']);
        return $artist;
    }
}
