<?php

use \danb\Lastfm\Http\App;

chdir('..');
require 'vendor/autoload.php';
$app = App::getInstance();
$app->run();
