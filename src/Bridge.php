<?php

final class Bridge
{
	public static function go($connector, $param)
	{
		shell_exec($a = "nohup /usr/bin/php ".BASEPATH."/connector/".$connector." ".implode(" ", $param)." 2>&1 &");
		print $a."\n";
	}
}