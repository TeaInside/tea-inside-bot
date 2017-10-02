<?php

namespace Handler;

use Telegram as B;
use Handler\MainHandler;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Response
{
	/**
	 * @var Handler\MainHandler
	 */
	private $h;

	/**
	 * Constructor.
	 * @param Handler\MainHandler $handler
	 */
	public function __construct(MainHandler $handler)
	{
		$this->h = $handler;
	}

	public function __invoke()
	{
		$this->__run();
	}

	private function __run()
	{
		B::sendMessage(
			[
				"text" => "test",
				"chat_id" => $this->h->chat_id
			]
		);
	}
}