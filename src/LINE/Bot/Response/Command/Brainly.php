<?php

namespace LINE\Bot\Response\Command;

use LINE;
use LINE\Bot\Bot;
use Plugins\Brainly\Brainly as BrainlyPlugin;
use LINE\Bot\Abstraction\CommandFoundation;

class Brainly extends CommandFoundation
{
	/**
	 * @var \LINE\Bot\Bot $bot
	 */
	private $b;

	/**
	 * Constructor
	 *
	 * @param \LINE\Bot\Bot $bot
	 */
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

	public function ask()
	{
		$st = explode(" ", $this->lowertext, 2);
		if (isset($st[1])) {
			$st = new BrainlyPlugin(
					trim($st[1])
				);
			$st->limit(10);
			$st = $st->exec(); $r = ""; $i = 1;
			$ll = function ($str) {
				return trim(strip_tags(
							html_entity_decode(
								str_replace("<br />", "\n", $str),
								ENT_QUOTES,
								"UTF-8"
							)
						)
					);
			};
			foreach ($st as $val) {
				$r .=  ($i++).". ".$ll($val['content'])."\nJawaban : "."\n".
					$ll($val['responses'][0]['content'])."\n\n";
			}
			$r = trim($r);
			$data = [];
			foreach (str_split($r, 1999) as $val) {
				$data[] = [
					"type" => "text",
					"text" => $val
				];
			}
			LINE::push(
				[
					"to" => $this->b->chat_id,
					"messages" => $data
				]
			);
		}
	}
}