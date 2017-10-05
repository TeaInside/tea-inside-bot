<?php

namespace Handler\Response\NormalMessage\Command;

use Telegram as B;
use Handler\MainHandler;
use Handler\Response\Foundation\CommandFactory;
use App\Translator\GoogleTranslate\GoogleTranslate;

class TranslateRepliedMessage extends CommandFactory
{	
	private $h;

	public function __construct(MainHandler $handler)
	{
		$this->h = $handler;
	}

	public function __run()
	{
		if (isset($this->h->replyto['text'])) {
			$x = explode(" ", $this->h->text, 4);
			$from = $x[1];
			$to   = $x[2];
			$st = new GoogleTranslate($this->h->replyto['text'], $from, $to);
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
}