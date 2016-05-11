<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use GuzzleHttp\Client;
use PHPUnit_Framework_Assert as Assert;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
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

    /**
     * @Then I should see links with href matching :arg1 for each name
     */
    public function iShouldSeeLinksWithHrefMatching($arg1)
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $links = $page->findAll('css', 'td.name a');
        $ok = true;
        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            if (!preg_match($arg1, $href)) {
                $ok = false;
                break;
            }
        }
        Assert::assertTrue($ok, "At least one link did not have expect href: '$href'");
    }

    /**
     * @Then I should see country pagination links
     */
    public function iShouldSeeCountryPaginationLinks()
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $links = $page->findAll('css', 'ul.pagination li a');
        $ok = false;
        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            if (preg_match('#/country/.*/[0-9]#', $href)) {
                $ok = true;
                break;
            }
        }
        Assert::assertTrue($ok, "Couldn't find pagination link.");
    }
}
