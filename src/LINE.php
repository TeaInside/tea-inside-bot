<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.1
 * @license MIT
 */
 final class LINE
 {	
 	
 	public static function profile($userid)
 	{
 		return self::__exec("https://api.line.me/v2/bot/profile/{$userid}");
 	}

 	public static function push($data)
 	{
 		return self::__exec(
 			"https://api.line.me/v2/bot/message/push",
 			[
 				CURLOPT_POST => true,
 				CURLOPT_POSTFIELDS => json_encode($data)
 			]
 		);
 	}

 	private static function __exec($url, $opt = null)
 	{
 		$ch = curl_init($url);
 		$__opt = [
 			CURLOPT_RETURNTRANSFER => true,
 			CURLOPT_SSL_VERIFYPEER => false,
 			CURLOPT_SSL_VERIFYHOST => false,
 			CURLOPT_BINARYTRANSFER => true,
 			CURLOPT_CONNECTTIMEOUT => 10,
 			CURLOPT_HTTPHEADER 	   => [
 				"Authorization: Bearer ".CHANNEL_ACCESS_TOKEN,
 				"Content-Type: application/json"
 			],
 			CURLOPT_TIMEOUT => 10
 		];
 		if (is_array($opt)) {
 			foreach ($opt as $key => $value) {
 				$__opt[$key] = $value;
 			}
 		}
 		curl_setopt_array($ch, $__opt);
 		$out = curl_exec($ch);
 		$no = curl_errno($ch) and $out = "Error ({$no}) : ".curl_error($ch);
 		$info = curl_getinfo($ch);
 		curl_close($ch);
 		return [
 			"content" => $out,
 			"info" => $info
 		];
 	}
 }