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

	public function __invoke()
	{
		return $this->__run();
	}

	private function __run()
	{
		if (! $this->virtualizor()) {

		}
		return false;
	}

	private function virtualizor()
	{
		$st = new Virtualizor($this->h->lowerText, in_array($this->userid, SUDOERS));
		if ($st = $st->exec()) {
			if ($st === false) {
				$st = Map::
			} else {
				
			}
		}
	}
}