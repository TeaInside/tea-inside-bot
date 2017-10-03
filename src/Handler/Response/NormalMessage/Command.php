<?php

namespace Handler\Response\NormalMessage;

use Handler\MainHandler;
use Handler\Response\NormalMessage\CommandRoutes;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Command
{
	/**
	 * @var Handler\MainHandler
	 */
	private $h;

	/**
	 * @var ???
	 */
	private $route;

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
	 * Check and declare route instance.
	 */
	private function checkRoute()
	{
		$st = new CommandRoutes($this->h);
		if ($st->needResponse()) {
			$this->route = $st->route;
			return true;
		}
		return false;
	}

	/**
	 * Public executor.
	 */
	public function exec()
	{
		if ($this->checkRoute()) {
			return $this->route->__run();
		}
		return false;
	}
}