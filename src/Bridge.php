<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.1
 * @license MIT
 */
final class Bridge
{
	public static function go($connector, $param)
	{
		shell_exec("nohup /usr/bin/php ".BASEPATH."/connector/".$connector." ".implode(" ", $param)." 2>&1 &");
	}
}