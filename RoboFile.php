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
}
