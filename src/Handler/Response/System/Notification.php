<?php

namespace Handler\Response\System;

use DB;
use PDO;
use Telegram as B;
use Handler\MainHandler;

final class Notification
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
}