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
		$this->route(function(){
			return
			CMDUtil::firstWorld($this->h->lowerText, "/translate") ||
			CMDUtil::firstWorld($this->h->lowerText, "!translate") ||
			CMDUtil::firstWorld($this->h->lowerText, "~translate");
		}, "\\Handler\\Response\\NormalMessage\\Command\\Translate");

		return isset($this->route);
	}

	private function route($a, $route)
	{
		if (isset($this->route)) {
			return false;
		}
		if (((bool) (($a instanceof Closure) ? $a() : $a))) {
			var_dump("masuk");
			$this->route = $route;
			return true;
		}
		var_dump("gak masuk");
		return false;
	}

	public function needResponse()
	{
		return $this->init_routes();
	}
}
