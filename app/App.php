<?php

namespace danb\Lastfm\Http;

use danb\Lastfm\Http\Routes;

/**
 * Represents a slim application.
 *
 * Instantiate and call #run to start the application.
 */
class App
{

    public $app;

    /**
     * Initialise the slim application so that it is ready to server requests.
     *
     * You will need to call App#run after instantiating.
     */
    public function __construct()
    {
        $this->app = new \Slim\App();
        $this->configureTemplateEngine();
        Routes::configure($this->app);
    }

    /**
     * Start the Slim application.
     */
    public function run()
    {
        return $this->app->run();
    }

    protected function configureTemplateEngine()
    {
        $container = $this->app->getContainer();
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
    }

}
