<?php

namespace Bot;

use Telegram as B;

final class Bot
{

	/**
	 * @var array
	 */
	private $input = [];

	/**
	 * Constructor.
	 *
	 * @param string $input
	 */
	public function __construct($input)
	{
		$this->input = json_decode($input, true);
	}

	private function parseEvent()
	{
		if (isset($this->input['message']['text'])) {
			# code...
		}
	}

	public function run()
	{

	}
}