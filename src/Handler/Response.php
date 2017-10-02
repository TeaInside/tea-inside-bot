<?php

namespace Handler;

use Telegram as B;
use Handler\MainHandler;
use Handler\Response\NormalMessage\Virtualizor;

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

	/**
	 * Invoke class instance.
	 */
	public function __invoke()
	{
		return $this->__run();
	}

	/**
	 * Private run.
	 */
	private function __run()
	{
		if (! $this->virtualizor()) {

		}
		return false;
	}

	/**
	 * Virtualizor.
	 */
	private function virtualizor()
	{
		$st = new Virtualizor($this->h->lowerText, $this->h->text, in_array($this->h->userId, SUDOERS));
		$st = $st->exec();
		if ($st === false) {
			$msg = "<b>Rejected for security reason!</b>";
		} elseif ($st !== null) {
			$msg = $st;
		} else {
			return false;
		}
		B::sendMessage(
			[
				"chat_id" 	 => $this->h->chat_id,
				"text"    	 => $msg,
				"parse_mode" => "HTML"
			]
		);
	}
}