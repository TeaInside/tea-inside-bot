<?php

namespace Telegram\Contracts\Plugins\Virtualizor;

interface Executable
{
	/**
	 * Constructor.
	 *
	 * @param string $code	
	 */
	public function __construct($code);

	/**
	 * @return string
	 */
	public function exec();
}