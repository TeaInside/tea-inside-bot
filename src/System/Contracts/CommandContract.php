<?php

namespace System\Contracts;

use Handler\MainHandler;

interface CommandContract
{
    /**
     * Constructor.
     *
     * @param Handler\MainHandler $handler
     */
    public function __construct(MainHandler $handler);

    /**
     * Run command.
     */
    public function __run();
}
