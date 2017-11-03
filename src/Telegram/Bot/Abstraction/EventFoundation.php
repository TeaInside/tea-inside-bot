<?php

namespace Telegram\Bot\Abstraction;

use Telegram\Bot\Bot;
use Exception;

abstract class EventFoundation
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

    private function trackEvent()
    {
        throw new Exception("The EventFoundation::trackEvent method must override");        
    }
}