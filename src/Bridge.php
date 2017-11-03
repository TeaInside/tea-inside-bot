<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.1
 * @license MIT
 */
final class Bridge
{
	/**
	 * @param string $connector
	 * @param array  $param
	 * @param bool   $background
	 * @return string|null
	 */
    public static function go($connector, $param, $background = false)
    {
    	if ($background) {
    		$cmd = "nohup ".PHP_BINARY." ".BASEPATH."/connector/".$connector."/bridge.php ".implode(" ", $param)." 2>&1 &";
    	} else {
    		$cmd = PHP_BINARY." ".BASEPATH."/connector/".$connector."/bridge.php ".implode(" ", $param)." 2>&1";
    	}
        return shell_exec($cmd);
    }
}
