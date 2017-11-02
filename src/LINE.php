<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.1
 * @license MIT
 */
 final class LINE
 {	
 	
 	/**
 	 * @param string $method
 	 * @param array  $param
 	 * @return string
 	 */
 	public static function __callStatic($method, $param)
 	{
 		$ch = curl_exec($param[0]);
 	}

 	public static function push($data)
 	{
 		return self::__exec();
 	}

 	private function __exec($url, $opt = null)
 	{
 		$ch = curl_init($url);
 		$__opt = [
 			CURLOPT_RETURNTRANSFER => true,
 			CURLOPT_SSL_VERIFYPEER => false,
 			CURLOPT_SSL_VERIFYHOST => false,
 			CURLOPT_BINARYTRANSFER => true,
 			CURLOPT_HTTPHEADER 	   => [
 				"Authorization: Bearer ".CHANNEL_ACCESS_TOKEN,
 				"Content-Type: application/json"
 			]
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