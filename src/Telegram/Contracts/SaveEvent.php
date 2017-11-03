<?php

namespace Telegram\Contracts;

use Telegram\Bot\Bot;

interface SaveEvent
{
	/**
	 * Constructor.
	 *
	 * @param \Bot\Bot $bot
	 */
	public function __construct(Bot $bot);

	/**
	 * Save event.
	 */
	public function save();
}