<?php

namespace danb\Lastfm\Http;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \danb\Lastfm\LastfmDaoStub;

/**
 * Class for handling the configuration of Slim app routes.
 */
class Routes
{
    /**
     * Configures our main application routes.
     *
     * @param  \Slim\App $app The slim application.
     * @return \Slim\App Returns $app.
     */
    public static function configure(\Slim\App $app)
    {
        $app->get('/', function (Request $request, Response $response) {
            return $this->view->render($response, 'searchByCountry.twig');
        });

        $app->post('/', function (Request $request, Response $response) {
            $stub = new LastfmDaoStub();
            $country = "australia";
            $results = $stub->getTopArtistsByCountry($country);
            $ok = true;
            return $this->view->render($response, 'searchByCountry.twig', array(
                'ok' => $ok,
                'rows' => $results->artists,
                'attr' => $results->attr
            ));
        });

        $app->get('/ping', function (Request $request, Response $response) {
            $response = $response->withHeader('Content-Type', 'text/plain');
            $response->getBody()->write("pong");
            return $response;
        });

        return $app;
    }
}
