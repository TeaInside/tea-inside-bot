<?php

namespace Handler\Response\NormalMessage;

use Lang;
use Closure;
use Telegram as B;
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
		Lang::init("id");
		Lang::initMainHandler($this->h);
		$this->route(function(){
			return
				CMDUtil::firstWorld($this->h->lowerText, "/translate") ||
				CMDUtil::firstWorld($this->h->lowerText, "!translate") ||
				CMDUtil::firstWorld($this->h->lowerText, "~translate");
		}, "\\Handler\\Response\\NormalMessage\\Command\\Translate");
		$this->route(function(){
			return
				$this->h->lowerText === "/start";
		}, "\\Handler\\Response\\NormalMessage\\Command\\Start");
		return isset($this->run);
	}

	private function route(Closure $a, $route)
	{
		if (isset($this->run)) {
			return false;
		}
		if (((bool) $a())) {
			$this->run = $route;
			return true;
		}
		return false;
	}

	public function needResponse()
	{
		return $this->init_routes();
	}
}
