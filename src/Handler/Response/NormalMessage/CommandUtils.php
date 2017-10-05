<?php

namespace Handler\Response\NormalMessage;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class CommandUtils
{
	public static function firstWorld($text, $word, $caseSensitive = false)
	{
		$a = explode(" ", $text, 2);
		return $caseSensitive ? $a[0] === $word : strtolower($a[0]) === $word;
	}
}