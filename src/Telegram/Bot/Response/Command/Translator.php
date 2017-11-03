<?php

namespace Telegram\Bot\Response\Command;

use Telegram as B;
use Telegram\Bot\Bot;
use Telegram\Bot\Abstraction\CommandFoundation;
use Telegram\Plugins\Translator\GoogleTranslate\GoogleTranslate;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Translator extends CommandFoundation
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

    public function googleTranslate()
    {
        $segment = explode(" ", $this->b->text, 4);
        if (isset($segment[1], $segment[2], $segment[3])) {
            try {
                $msg = new GoogleTranslate($segment[3], $segment[1], $segment[2]);
                $msg = htmlspecialchars($msg->exec());
                $msg = $msg==="" ? "~" : $msg;    
            } catch (\Exception $e) {
                $msg = "Language not found!";
            }
        } else {
            $msg = "Penulisan format translate salah!\n\nBerikut ini adalah penulisan yang benar :\n<pre>/tl [from] [to] [string]</pre>\n\nContoh :\n<pre>/tl id en Apa kabar?</pre>";
        }
        return B::sendMessage(
            [
            "chat_id" => $this->b->chat_id,
            "reply_to_message_id" => $this->b->msgid,
            "text" => $msg,
            "parse_mode" => "HTML"
            ]
        );
    }

    public function rgoogleTranslate()
    {
        $segment = explode(" ", $this->b->text, 4);
        if (isset($segment[1], $segment[2]) && isset($this->b->replyto['text'])) {
            try {
                $msg = new GoogleTranslate($this->b->replyto['text'], $segment[1], $segment[2]);
                $msg = htmlspecialchars($msg->exec());
                $msg = $msg==="" ? "~" : $msg;    
            } catch (\Exception $e) {
                $msg = "Language not found!";
            }
            return B::sendMessage(
                [
                "chat_id" => $this->b->chat_id,
                "reply_to_message_id" => $this->b->replyto['message_id'],
                "text" => $msg,
                "parse_mode" => "HTML"
                ]
            );
        }         
    }
}