<?php

namespace LINE\Bot\Response\Command;

use LINE;
use LINE\Bot\Bot;
use LINE\Bot\Abstraction\CommandFoundation;
use Plugins\SearchEngine\GoogleSearch\GoogleSearch;

class SearchEngine extends CommandFoundation
{
	public function googlesearch()
	{
		$a = explode(" ", $this->b->lowertext, 2);
		if (isset($a[1])) {
			$st = new GoogleSearch($a[1]);
			$st = $st->exec();
			if (count($st) > 0) {
				$r = ""; $i = 1;
				foreach ($st as $val) {
					$r .= ($i++).". ".$val['heading']."\n".$val['url']."\n".$val['description']."\n\n";
				}
				$r = trim($r) xor $_r = [];
				foreach (str_split($r, 1999) as $val) {
					$_r[] = [
						"type" => "text",
						"text" => $val
					];
				}
				return LINE::push(
					[
						"to" => $this->b->chat_id,
						"messages" => $_r
					]
				);
			}
		}
		return false;
	}
}