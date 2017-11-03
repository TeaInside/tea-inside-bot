<?php

namespace Telegram\Bot\Abstraction;

use Telegram\Bot\Bot;

abstract class CommandFoundation
{

    /**
     * @var \Bot\Bot
     */
    private $b;

    /**
     * Constructor.
     *
     * @param \Bot\Bot $bot
     */
    abstract public function __construct(Bot $bot);
}