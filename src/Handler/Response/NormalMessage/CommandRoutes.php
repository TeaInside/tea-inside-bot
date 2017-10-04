<?php

namespace Handler\Response\NormalMessage;

use Handler\MainHandler;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class CommandRoutes
{
	/**
	 * @var Handler\MainHandler
	 */
	private $h;

	/**
	 * @var array
	 */
	private $routes = [];

	/**
	 * @var object
	 */
	private $run;

	/**
	 * Constructor.
	 *
	 * @param Handler\MainHandler
	 */	
	public function __construct(MainHandler $handler)
	{
		$this->h = $handler;
		$a = explode(" ", $handler->lowertext, 2);
		$this->startWith = $a[0];
	}

	private function routes()
	{
		$this->routes = [
			"/translate" => "\\Handler\\Response\\NormalMessage\\Command\\Translate"
		];
	}

	public function needResponse()
	{
		foreach ($this->routes as $key => $val) {
			var_dump($key, $this->startWith);
			if ($this->startWith == $key) {
				$this->run = new $val($this->h);
				return true;
			}
		}
	}
}
