<?php

namespace Telegram\Bot;

use Telegram\Lang;
use Telegram\Bot\Response\Command;
use Telegram\Bot\Response\Virtualizor;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class Response
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
    public function __construct(Bot $bot)
    {
        $this->b = $bot;
    }

    public function run()
    {
        if (! $this->virtualizor()) {
            Lang::init($this->b, "ID");
            if (! $this->command()) {
                return false;
            }
        }
        return true;
    }

    private function virtualizor()
    {
        $st = new Virtualizor($this->b);
        return $st->run();
    }

    private function command()
    {
        $st = new Command($this->b);
        return $st->run();
    }
}