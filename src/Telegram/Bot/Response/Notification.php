<?php

namespace Telegram\Bot\Response;

use DB;
use Telegram\Bot\Bot;

class Notification
{
	public function __construct(Bot $b)
	{
		$this->b = $b;
	}

	public function run()
	{
		if ($this->shouldReport()) {
			$this->notify();
		}
	}

	private function isKnownUser()
	{
		return true;
	}

	private function shouldReport()
	{
		var_dump($this->b->entities);
		return $this->isKnownUser();
	}

	private function notify()
	{

	}
}