<?php

namespace System\Contracts;

use Handler\MainHandler;

interface EventContract
{
    public function __construct(MainHandler $handler);

    public function save();
}
