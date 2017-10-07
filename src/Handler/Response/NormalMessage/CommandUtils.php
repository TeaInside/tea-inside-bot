<?php

namespace Handler\Response\NormalMessage;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class CommandUtils
{
    public static function fW($text, $word, $caseSensitive = false)
    {
        $a = explode(" ", $text, 2);
        $b = explode("@", $a[0], 2);
        if (count($b) > 1) {
        	$a[0] = $b[0];
        }
        return $caseSensitive ? $a[0] === $word : strtolower($a[0]) === $word;
    }
}
