<?php

namespace Handler\Response\NormalMessage;

use Handler\MainHandler;

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
	 * Constructor.
	 *
	 * @param Handler\MainHandler
	 */
	public function __construct(MainHandler $handler)
	{
		$this->h = $handler;
	}
}