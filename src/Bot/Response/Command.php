<?php

namespace Bot\Response;

use Closure;
use Bot\Bot;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class Command
{

	/**
	 * @var \Bot\Bot
	 */
	private $b;

	/**
	 * @var array
	 */
	private $cmd = [];

	/**
	 * Constructor.
	 *
	 * @param \Bot\Bot $bot
	 */
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

	private function set(Closure $cond, $action)
	{
		$this->cmd[] = [$cond, $action];
	}

	private function buildCMDRoutes()
	{
		$this->set(function()
		{
			return true;
		}, "ShellExec@run");
	}

	private function isCommandAction()
	{
		$this->buildCMDRoutes();
		foreach ($this->cmd as $val) {
			if ($val[0]()) {
				if ($val[1] instanceof Closure) {
					$val[1]();
				} else {
					$a = explode("@", $val[1]);
					$a[0] = "Bot\\Response\\Command\\".$a[0];
					$st = new $a[0]($this->b);
					$st->{$a[1]}();
				}
				return true;
			}
		}
	}

	public function run()
	{
		return $this->isCommandAction();
	}
}