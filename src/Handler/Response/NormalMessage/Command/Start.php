<?php

namespace Handler\Response\NormalMessage\Command;

use Lang;
use Telegram as B;
use Handler\MainHandler;
use Handler\Response\Foundation\CommandFactory;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Start extends CommandFactory
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
     * Run command.
     */
    public function __run()
    {
        B::sendMessage(
            [
                "chat_id" => $this->h->chat_id,
                "text"    => Lang::system("/start"),
                "reply_to_message_id" => $this->h->msgid,
                "parse_mode" => "HTML"
            ]
        );
    }
}
