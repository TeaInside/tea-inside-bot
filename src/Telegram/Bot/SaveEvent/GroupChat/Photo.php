<?php

namespace Telegram\Bot\SaveEvent\GroupChat;

use DB;
use Telegram\Bot\Bot;
use Telegram\Contracts\SaveEvent;

class Photo implements SaveEvent
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
	{ var_dump("save photo");
		$this->b = $bot;
	}

	/**
	 * Save event.
	 */
	public function save()
	{
		$st = DB::prepare("INSERT INTO `group_messages` (`msg_uniq`, `user_id`, `group_id`, `message_id`, `reply_to_message_id`, `type`, `created_at`) VALUES (:msg_uniq, :user_id, :group_id, :message_id, :reply_to_message_id, :type, :created_at);");
		pc($st->execute(
			[
				":msg_uniq" 	=> ($uniq = $this->b->msgid."|".$this->b->chat_id),
				":user_id"		=> $this->b->user_id,
				":group_id"		=> $this->b->chat_id,
				":message_id"	=> $this->b->msgid,
				":reply_to_message_id" => (isset($this->b->replyto['message_id']) ? $this->b->replyto['message_id'] : null),
				":type"			=> "photo",
				":created_at"	=> date("Y-m-d H:i:s")
			]
		), $st);
		$st = DB::prepare("INSERT INTO `group_messages_data` (`msg_uniq`, `text`, `file`) VALUES (:msg_uniq, :txt, :file);");
		$f = end($this->b->photo);
		pc($st->execute(
			[
				":msg_uniq" => $uniq,
				":txt"		=> $this->b->text,
				":file" => $f['file_id']
			]
		), $st);
	}
}
