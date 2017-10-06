<?php

namespace Handler\Response\Foundation;

use Handler\MainHandler;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
abstract class CommandFactory
{
    /**
     * @var Handler\MainHandler
     */
    private $h;

    /**
     * Constructor.
     *
     * @param Handler\MainHandler $handler
     */
    abstract public function __construct(MainHandler $handler);

    /**
     * Run
     */
    abstract public function __run();
}
