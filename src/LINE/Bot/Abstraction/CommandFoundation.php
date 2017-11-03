<?php

namespace LINE\Bot\Abstraction;

use LINE\Bot\Bot;

abstract class CommandFoundation
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
}