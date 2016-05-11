<?php

namespace danb\Lastfm\Http;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \danb\Lastfm\DaoStub;
use \danb\Lastfm\Http\PaginatorFactory;
use JasonGrimes\Paginator;

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
    public function configure(\Slim\App $app)
    {
        $app->get('/', function (Request $request, Response $response) {
            return $this->view->render($response, 'searchByCountry.twig');
        });

        $app->get('/country[/{name}/{page}]', function (Request $request, Response $response, $args) {
            $stub = new DaoStub();
            $country = "australia";

            $results = $stub->getTopArtistsByCountry($country);
            $attr = $results['attr'];
            $ok = true;

            $paginator = PaginatorFactory::useLastfmParams($attr, "/country/$country/(:num)");

            return $this->view->render($response, 'searchByCountry.twig', array(
                'ok' => $ok,
                'rows' => $results['artists'],
                'attr' => $attr,
                'paginator' => $paginator
            ));
        });

        $app->get('/artist/{mbid}/top', function (Request $request, Response $response, $args) {
            $stub = new DaoStub();
            $mbid = "5441c29d-3602-4898-b1a1-b77fa23b8e50";
            $results = $stub->getTopTracksByArtist($mbid);
            $ok = true;
            return $this->view->render($response, 'topTracks.twig', array(
                'ok' => $ok,
                'rows' => $results['track'],
                'attr' => $results['attr']
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
