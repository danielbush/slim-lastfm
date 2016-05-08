<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;

$container = $app->getContainer();

// Set up twig templating.
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('app/views', array(
        'cache' => 'tmp/cache/templates',
        'debug' => true, // TODO: environment / SLIM_MODE
        'autoreload' => true
    ));
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
    return $view;
};

$app->get('/', function (Request $request, Response $response) {
    return $this->view->render($response, 'searchByCountry.twig');
});

$app->post('/', function (Request $request, Response $response) {
    return $this->view->render($response, 'searchByCountry.twig', array(
        'results' => true
    ));
});

$app->get('/ping', function (Request $request, Response $response) {
    $response = $response->withHeader('Content-Type', 'text/plain');
    $response->getBody()->write("pong");
    return $response;
});

$app->run();
