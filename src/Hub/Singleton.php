<?php

namespace Hub;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
trait Singleton
{
	private static $instance;

	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new self(...func_get_args());
		}
		return self::$instance;
	}

	private function __clone()
	{
	}
}