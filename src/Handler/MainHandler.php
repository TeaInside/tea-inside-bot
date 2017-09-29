<?php

namespace Handler;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class MainHandler
{
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
}