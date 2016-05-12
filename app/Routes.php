<?php

namespace danb\Lastfm\Http;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \danb\Lastfm\DaoStub;
use \danb\Lastfm\Dao;
use \danb\Lastfm\Http\PaginatorFactory;
use \danb\Lastfm\Http\App;
use JasonGrimes\Paginator;

/**
 * Configures slim application routes to expose functionality in danb\Lastfm
 * package.
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

        $app->get('/country[/{country}/{page}]', function (Request $request, Response $response, $args) {
            $dao = App::getInstance()->getDao();
            $ok = true;
            $error = false;

            $country = isset($args['country']) ? $args['country'] : null;
            if (!$country) {
                $country = isset($request->getQueryParams()['country']) ?
                    $request->getQueryParams()['country'] : null;
            }
            if (!$country) {
                $ok = false;
                $error = true;
            }
            $page = isset($args['page']) ? $args['page'] : null;
            if (!$page) $page = 1;

            $results = $dao->getTopArtistsByCountry($country, 5, $page);
            if (!isset($results['@attr'])) {
                $ok = false;
                $error = true;
            }
            $attr = $results['@attr'];

            $paginator = PaginatorFactory::useLastfmParams($attr, "/country/$country/(:num)");

            return $this->view->render($response, 'searchByCountry.twig', array(
                'ok' => $ok,
                'error' => $error,
                'rows' => $results['artist'],
                'attr' => $attr,
                'paginator' => $paginator
            ));
        });

        $app->get('/artist/{mbid}/top', function (Request $request, Response $response, $args) {
            $dao = App::getInstance()->getDao();
            $mbid = $args['mbid'];
            $results = $dao->getTopTracksByArtist($mbid);
            $ok = true;
            return $this->view->render($response, 'topTracks.twig', array(
                'ok' => $ok,
                'rows' => $results['track'],
                'attr' => $results['@attr']
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
