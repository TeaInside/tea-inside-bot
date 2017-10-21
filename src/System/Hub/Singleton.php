<?php

namespace System\Hub;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
trait Singleton
{	
	/**
	 * @var self
	 */
	private static $instance;

	/**
	 * Get instance.
	 */
	public function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new self(...func_get_args());
		}
		return self::$instance;
	}

	/**
	 * Prevent cloning instance.
	 */
	final private function __clone()
	{
	}
}