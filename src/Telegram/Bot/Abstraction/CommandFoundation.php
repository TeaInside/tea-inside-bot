<?php

namespace Bot\Abstraction;

use Bot\Bot;

abstract class CommandFoundation
{

	/**
	 * @var \Bot\Bot
	 */
	private $b;

	/**
	 * Constructor.
	 *
	 * @param \Bot\Bot $bot
	 */
	abstract public function __construct(Bot $bot);
}