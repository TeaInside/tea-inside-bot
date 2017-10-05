<?php

namespace Handler\Response\NormalMessage\Command;

use Lang;
use Telegram as B;
use Handler\MainHandler;
use Handler\Response\Foundation\CommandFactory;

class Start extends CommandFactory
{
	/**
	 * @var Handler\MainHandler
	 */
	private $h;

	/**
	 * Constructor.
	 *
	 * @param Handler\MainHandler
	 */
	public function __construct(MainHandler $handler)
	{
		$this->h = $handler;
	}

	/**
	 * Run.
	 */
	public function __run()
	{
		B::sendMessage(
			[
				"chat_id" => $this->h->chat_id,
				"text"    => Lang::system("/start"),
				"reply_to_message_id" => $this->h->msgid
			]
		);
	}
}