<?php

namespace Handler;

use Handler\Response;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class MainHandler
{
	/**
	 * @var string
	 */
	private $chattype;

	/**
	 * @var string
	 */
	private $text;

	/**
	 * Constructor.
	 * @param string $input
	 */
	public function __construct($input)
	{
		if ($input) {
			$this->input = json_decode($input, true);
		} else {
			$this->input = json_decode(file_get_contents("php://input"), true);
		}
	}

	/**
	 * Run app.
	 */
	public function run()
	{
		$this->parseEvent();
	}

	/**
	 * Parse Webhook Event.
	 */
	private function parseEvent()
	{
		if (isset($this->input['message']['text'])) {
			$this->chattype = "text";
			$this->
		}
	}
}