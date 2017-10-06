<?php

namespace Handler\SaveEvent\Group;

use Handler\MainHandler;
use System\Contract\EventContract;

final class Text implements EventContract
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

    /**
     * Save event.
     */
    public function save()
    {
    }
}
