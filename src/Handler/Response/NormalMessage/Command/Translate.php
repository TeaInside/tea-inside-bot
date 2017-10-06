<?php

namespace Handler\Response\NormalMessage\Command;

use Telegram as B;
use Handler\MainHandler;
use System\Contract\CommandContract;
use Handler\Response\Foundation\CommandFactory;
use App\Translator\GoogleTranslate\GoogleTranslate;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Translate extends CommandFactory implements CommandContract
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
        $x = explode(" ", $this->h->text, 4);
        $from = $x[1];
        $to   = $x[2];
        $text = $x[3];
        $st = new GoogleTranslate($text, $from, $to);
        B::sendMessage(
            [
                "text" => $st->exec(),
                "chat_id" => $this->h->chat_id,
                "reply_to_message_id" => $this->h->msgid,
                "disable_web_page_preview" => true
            ]
        );
    }
}
