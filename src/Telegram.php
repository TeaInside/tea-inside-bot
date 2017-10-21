<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.1
 * @license MIT
 */
 final class Telegram
 {	
 	
 	/**
 	 * @param string $method
 	 * @param array  $param
 	 * @return string
 	 */
 	public static function __callStatic($method, $param)
 	{
 		if (isset($param[1]) and $param[1] === "GET") {
 			$ch = new Curl("https://api.telegram.org/bot".TOKEN."/".$method."?".http_build_query($param[0]));
 		} else {
 			$ch = new Curl("https://api.telegram.org/bot".TOKEN."/".$method);
 			$ch->post(http_build_query($param[0]));
 		}
 		$out = $ch->exec();
 		$err = $ch->error and $out = $err;
 		return $out;
 	}
 }