<?php

namespace Handler\Response\Foundation;

use Handler\MainHandler;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
abstract class CommandFactory
{
    abstract public function __construct(MainHandler $handler);
    
    abstract public function __run();
}
