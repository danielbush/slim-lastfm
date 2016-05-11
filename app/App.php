<?php

namespace danb\Lastfm\Http;

use danb\Lastfm\Http\Routes;
use danb\Lastfm\Dao;
use Symfony\Component\Yaml\Parser;

/**
 * Represents a slim application.
 *
 * Instantiate and call #run to start the application.
 */
class App
{

    public $app;
    private $config;
    private static $instance;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * Initialise the slim application so that it is ready to server requests.
     *
     * You will need to call App#run after instantiating.
     */
    private function __construct()
    {
        $this->app = new \Slim\App();
        $this->configureTemplateEngine();
        $routes = new Routes();
        $routes->configure($this->app);
        // This isn't a good solution but there isn't time to handle this better.
        $this->getConfigOrDie();
    }

    /**
     * Try to load 'config.yml' in root of application or throw exception.
     *
     */
    private function getConfigOrDie()
    {
        $env = $this->getEnvironment();
        $yaml = new Parser();
        $this->config = $yaml->parse(file_get_contents('config.yml'));
        if (is_null($this->config)) {
            throw new \Exception("config.yml not found, use config.dist.yml.");
        }
        if (!isset($this->config[$env]['api_key'])) {
            throw new \Exception("api_key not found in config.yml.");
        }
        if (!isset($this->config[$env]['lastfm_url'])) {
            throw new \Exception("lastfm_url not found in config.yml.");
        }
    }

    /**
     * TODO: return our application environment (development, production, staging, test etc).
     */
    public function getEnvironment()
    {
        return 'development';
    }

    public function getDao()
    {
        return new Dao($this->getBaseUrl(), $this->getApiKey());
    }

    public function getApiKey()
    {
        $env = $this->getEnvironment();
        return $this->config[$env]['api_key'];
    }

    public function getBaseUrl()
    {
        $env = $this->getEnvironment();
        return $this->config[$env]['lastfm_url'];
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
