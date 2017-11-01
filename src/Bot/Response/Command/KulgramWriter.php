<?php

namespace Bot\Response\Command;

use Bot\Bot;
use Telegram as B;
use Bot\Abstraction\CommandFoundation;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class KulgramWriter extends CommandFoundation
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
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

	public function init()
	{
		$st = new \Plugins\KulgramWriter\Actions\Init($this->b);
		$st->run();
	}

	public function start()
	{
		$st = new \Plugins\KulgramWriter\Actions\Start($this->b);
		$st->run();
	}
}