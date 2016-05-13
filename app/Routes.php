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
            $country = isset($request->getQueryParams()['country']) ?
                $request->getQueryParams()['country'] : null;

            if (is_null($country)) {
                return $this->view->render($response, 'searchByCountry.twig', array());
            }
            return $response->withRedirect("/country/{$country}/1");
        });

        $app->get('/country/{country}/{page:[0-9]+}', function (
            Request $request,
            Response $response,
            $args
        ) {
            $dao = App::getInstance()->getDao();
            $ok = true;
            $error = false;
            $country = trim($args['country']);
            $page = (int)$args['page'];
            $page = ($page === 0) ? 1 : $page;

            if (!checkCountryParam($country)) {
                return $this->view->render($response, 'searchByCountry.twig', array(
                    'ok' => false,
                    'error' => true,
                ));
            }

            $results = $dao->getTopArtistsByCountry($country, 5, $page);
            if (is_null($results)) {
                return $this->view->render($response, 'searchByCountry.twig', array(
                    'ok' => false,
                    'error' => true,
                ));
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

        $app->get('/artist/{mbid:[0-9A-Fa-f-]+}/top', function (Request $request, Response $response, $args) {
            $dao = App::getInstance()->getDao();
            $mbid = $args['mbid'];
            $results = $dao->getTopTracksByArtist($mbid);
            if (is_null($results)) {
                // TODO: put a flash in with error message.
                return $response->withRedirect('/');
            }
            return $this->view->render($response, 'topTracks.twig', array(
                'ok' => true,
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

/**
 * Sanity check country name input.
 *
 * TODO: probably should put it in a class since we're autoloading everything.
 */
function checkCountryParam($country)
{
    if (strlen($country) > 50) {
        return false;
    }
    return preg_match('/^[\s\w-)(]+$/', $country);

}
