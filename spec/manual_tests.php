<?php
/**
 * Test Dao and guzzle manually against real service.
 */

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use danb\Lastfm\Dao;

function usage()
{
    $thisFile = basename(__FILE__);
    echo "Usage:" . PHP_EOL;
    echo "php $thisFile <your-api-key>" . PHP_EOL;
}

if (!isset($argv[1])) {
    usage();
    exit(1);
}
$api_key = $argv[1];
$base_uri = 'http://ws.audioscrobbler.com/2.0';

function testGuzzle($base_uri, $api_key)
{
    $client = new Client(array(
        'base_uri' => $base_uri,
        'timeout' => 5.0
    ));
    print_r((string)$client->getConfig('base_uri'));
    $response = $client->request('GET', null, array(
        'query' => array(
            'method' => 'geo.gettopartists',
            'country' => 'australia',
            'api_key' => $api_key,
            'format' => 'json',
            'limit' => 5
        )
    ));

    print_r((string)$response->getBody());
}

function testDao($base_uri, $api_key)
{
    $dao = new Dao($base_uri, $api_key);

    echo '------------------------------------------------------------';
    echo PHP_EOL;
    echo 'getTopArtistsByCountry' . PHP_EOL;
    $result = $dao->getTopArtistsByCountry('australia', 5, 1);
    print_r($result);
    echo PHP_EOL;

    echo '------------------------------------------------------------';
    echo PHP_EOL;
    echo 'getTopTracksByArtist' . PHP_EOL;
    $result = $dao->getTopTracksByArtist('c8b03190-306c-4120-bb0b-6f2ebfc06ea9', 5, 1);
    print_r($result);
}


//testGuzzle($base_uri, $api_key);
testDao($base_uri, $api_key);
echo PHP_EOL;
echo PHP_EOL;
