<?php

namespace LINE\Bot\Response;

use LINE;

trait CommandRoutes
{
	private function writeRoutes()
	{
		$st = explode(" ", $this->b->text, 2);
		
		$this->route(function() use ($st){
			var_dump($st);
			return $st[0] === "/google";
		}, function() use ($st) {
			$st = new \Plugins\SearchEngine\GoogleSearch\GoogleSearch($st[1]);
			$st = $st->exec();
			$r = ""; $i=1;
			foreach($st as $z) {
				$r.= ($i++).". ".$z['heading']."\n".$z['url']."\n".$z['description']."\n\n";
			}
			var_dump($r);
			$r = trim($r);
			$r = empty($r)?"Not found!":$r;
			print LINE::push(
				[
					"to" => $this->b->chat_id,
					"messages" => [
						[
							"type" => "text",
							"text" => $r
						]
					]
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