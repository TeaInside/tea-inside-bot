<?php

namespace Handler\Response\NormalMessage;

use Closure;
use Handler\MainHandler;
use Handler\Response\NormalMessage\CommandUtils as CMDUtil;

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
	public $run;

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
		$this->init_routes();
	}

	private function init_routes()
	{
		$this->route((
			CMDUtil::firstWorld($this->lowerText, "/translate") ||
			CMDUtil::firstWorld($this->lowerText, "!translate") ||
			CMDUtil::firstWorld($this->lowerText, "~translate")
		), "\\Handler\\Response\\NormalMessage\\Command\\Translate");
	}

	private function route($a, $route)
	{
		$flag = (bool) (($a instanceof Closure) ? $a() : $a);
		if ($flag) {
			$this->route = $route;
			return true;
		}
		return false;
	}

	public function needResponse()
	{
		return $this->init_routes();
	}
}
