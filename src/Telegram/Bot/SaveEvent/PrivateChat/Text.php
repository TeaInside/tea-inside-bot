<?php

namespace Bot\SaveEvent\PrivateChat;

use DB;
use Telegram\Bot\Bot;
use Telegram\Contracts\SaveEvent;

class Text implements SaveEvent
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

    /**
     * Save event.
     */
    public function save()
    {
        $st = DB::prepare("INSERT INTO `private_messages` (`msg_uniq`, `user_id`, `message_id`, `reply_to_message_id`, `type`, `created_at`) VALUES (:msg_uniq, :user_id, :message_id, :reply_to_message_id, :type, :created_at);");
        pc(
            $st->execute(
                [
                ":msg_uniq"     => ($uniq = $this->b->msgid."|".$this->b->chat_id),
                ":user_id"        => $this->b->user_id,
                ":message_id"    => $this->b->msgid,
                ":reply_to_message_id" => (isset($this->b->replyto['message_id']) ? $this->b->replyto['message_id'] : null),
                ":type"            => "text",
                ":created_at"    => date("Y-m-d H:i:s")
                ]
            ), $st
        );
        $st = DB::prepare("INSERT INTO `private_messages_data` (`msg_uniq`, `text`, `file`) VALUES (:msg_uniq, :txt, NULL)");
        pc(
            $st->execute(
                [
                ":msg_uniq" => $uniq,
                ":txt"        => $this->b->text
                ]
            ), $st
        );
    }
}