<?php

namespace LINE\Bot;

final class Bot
{

	/**
	 * @var array
	 */
	public $input = [];

	/**
	 * @param string $data
	 */
	public function __construct($data)
	{
		$this->input = json_decode($data, true);
	}

	public function run()
	{
		
	}
}