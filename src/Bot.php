<?php

use Handler\MainHandler;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class Bot
{
    /**
     * @var Handler\MainHandler
     */
    private $main;

    /**
     * Constructor.
     * @param string $input
     */
    public function __construct($input)
    {
        $this->main = new MainHandler($input);
    }
    
    /**
     * Run app.
     */
    public function run()
    {
        $this->main->run();
    }
}
