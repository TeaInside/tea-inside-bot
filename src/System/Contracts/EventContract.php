<?php

namespace System\Contract;

use Handler\MainHandler;

interface EventContract
{
    public function __construct(MainHandler $handler);

    public function save();
}
