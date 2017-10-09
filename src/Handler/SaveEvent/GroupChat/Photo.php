<?php

namespace Handler\SaveEvent\GroupChat;

use DB;
use Handler\MainHandler;
use System\Contracts\EventContract;

final class Photo implements EventContract
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
     * Save event.
     */
    public function save()
    {
        $st = DB::prepare("INSERT INTO `group_messages` (`msg_uniq`, `userid`, `group_id`, `message_id`, `reply_to_message_id`, `type`, `created_at`) VALUES (:msg_uniq, :userid, :group_id, :message_id, :reply_to_message_id, :type, :created_at);");
        pc($st->execute(
            [
                ":msg_uniq"             => ($uniq = $this->h->msgid."|".$this->h->chat_id),
                ":userid"               => $this->h->userid,
                ":group_id"             => $this->h->chat_id,
                ":message_id"           => $this->h->msgid,
                ":reply_to_message_id"  => (isset($this->replyto) ? $this->replyto['message_id'] : null),
                ":type"                 => "photo",
                ":created_at"           => date("Y-m-d H:i:s")
            ]
        ), $st);
        $st = DB::prepare("INSERT INTO `group_messages_data` (`msg_uniq`, `text`, `file`) VALUES (:msg_uniq, :txt, :file);");
        pc($st->execute(
            [
                ":msg_uniq" => $uniq,
                ":txt"      => $this->h->text,
                ":file"     => $this->h->photo['file_id']
            ]
        ), $st);
        return true;
    }
}
