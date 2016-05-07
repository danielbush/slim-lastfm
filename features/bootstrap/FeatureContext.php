<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use GuzzleHttp\Client;
use PHPUnit_Framework_Assert as Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $httpClient;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->httpClient = new Client(array('base_uri' => 'http://localhost:8001'));
    }


    /**
     * @When an http client gets \/ping
     */
    public function anHttpClientGetsPing()
    {
        $this->response = $this->httpClient->get('/ping');
    }

    /**
     * @Then a pong will be received
     */
    public function aPongWillBeReceived()
    {
        Assert::assertEquals('pong', (string)$this->response->getBody());
    }

}
