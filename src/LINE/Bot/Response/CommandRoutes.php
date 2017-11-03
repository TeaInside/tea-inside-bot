<?php

namespace LINE\Bot\Response;

use LINE;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.1
 * @license MIT
 */
trait CommandRoutes
{
	private function writeRoutes()
	{
		$st = explode(" ", $this->b->text, 2);
		
		$this->route(function() use ($st){
			var_dump($st); $st[0] = strtolower($st[0]);
			return $st[0] === "/google" or $st[0] === "/g";
		}, function() use ($st) {
			$st = new \Plugins\SearchEngine\GoogleSearch\GoogleSearch($st[1]);
			$st = $st->exec();
			$r = ""; $i=1;
			foreach($st as $z) {
				$r.= ($i++).". ".$z['heading']."\n".$z['url']."\n".$z['description']."\n\n";
			}
			var_dump($r);
			$r = trim($r);
			foreach(str_split($r, 1999) as $q)
			 $msg[] = [
			 		"type" => "text",
			 	  "text" => $q
			 ];
			$r = empty($r)?"Not found!":$r;
			print LINE::push(
				[
					"to" => $this->b->chat_id,
					"messages" => $msg
				]
			)['content'];
		});
		
		$this->route(function()use($st){
			return $st[0] === "/tl";
		}, function() use($st){
			 
			 $st = explode(" ", $st[1], 3);
			 isset($st[1],$st[2]) and
$st = new \Plugins\Translator\GoogleTranslate\GoogleTranslate($st[2], $st[0], $st[1]);
$st = $st->exec();
print LINE::push(
				[
					"to" => $this->b->chat_id,
					"messages" => [
						[
							"type" => "text",
							"text" => $st
						]
					]
				]
			)['content'];
		});
		
	}
}