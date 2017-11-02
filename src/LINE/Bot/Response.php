<?php

namespace LINE\Bot;

use LINE\Bot\Bot;

class Response
{

	/**
	 * @var \LINE\Bot\Bot
	 */
	private $b;

	/**
	 * Constructor.
	 *
	 * @param \LINE\Bot\Bot $bot
	 */
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

	public function run()
	{

	}
}

