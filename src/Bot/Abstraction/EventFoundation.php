<?php

namespace Bot\Abstraction;

use Bot\Bot;
use Exception;

abstract class EventFoundation
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
	final public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

	public function trackEvent()
	{
		throw new Exception("The EventFoundation::trackEvent method must override");		
	}
}