<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    /**
     * Test we're up and running.
     */
    public function ping()
    {
        $this->say("pong");
    }

    /**
     * Start dev server in the foreground.
     */
    public function serverStart($port = 8000)
    {
        $this->taskExec("php -S localhost:{$port} -t public/")
             ->run();
    }

    /**
     * Run end-to-end / acceptance tests.
     */
    public function testAcceptance()
    {
        chdir('public/');
        $this->taskServer(8001) // this is also hardcoded in behat
             ->background()
             ->run();
        chdir('..');
        $this->taskExec("vendor/bin/behat")
             ->run();
    }
}
