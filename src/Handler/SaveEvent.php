<?php

namespace Handler;

use Handler\MainHandler;

final class SaveEvent
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
    public function __construct(MainHandler $handler)
    {
        $this->h = $handler;
    }

    public function save()
    {
        
    }
}
