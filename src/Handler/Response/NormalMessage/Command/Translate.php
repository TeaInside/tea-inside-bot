<?php

namespace Handler\Response\NormalMessage\Command;

use Telegram as B;
use Handler\MainHandler;

class Translate
{	
	private $h;

	public function __construct(MainHandler $handler)
	{
		$this->h = $handler;
	}

	public function __run()
	{
		B::sendMessage(
			[
				"text" => "test router success!",
				"chat_id" => $this->h->chat_id
			]
		);
	}
}