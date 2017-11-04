<?php

namespace LINE\Bot\Response\Command;

use LINE;
use LINE\Bot\Bot;
use LINE\Bot\Abstraction\CommandFoundation;

class Jadwal extends CommandFoundation
{
	/**
	 * @var \LINE\Bot\Bot
	 */
	private $b;
	
	/**
	 * Constructor.
	 *
	 * @param \LINE\Bot\Bot $bot
	 */
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
		$this->jadwal = [
			"senin" => [
				"Upacara",
				"Bahasa Jawa",
				"Bahasa Jawa",
				"Agama",
				"Istirahat",
				"B.Inggris",
				"B.Inggris",
				"Fisika",
				"Istirahat",
				"Fisika",
				"Seni Musik",
				"Seni Musik"
			],
			"selasa" => [
				"Ekonomi",
				"Ekonomi",
				"Matematika Minat",
				"Matematika Minat",
				"Istirahat",
				"Kimia",
				"Kimia",
				"B.Indonesia",
				"Istirahat",
				"B.Indonesia",
				"Kewirausahaan",
				"Kewirausahaan"
			],
			"rabu" => [
				"Matematika Wajib",
				"Matematika Wajib",
				"Fisika",
				"Fisika",
				"Istirahat",
				"Biologi",
				"Biologi",
				"Ekonomi",
				"Istirahat",
				"Ekonomi",
				"Sejarah",
				"Sejarah"
			],
			"kamis" => [
				"Agama",
				"Agama",
				"B.Indonesia",
				"B.Indonesia",
				"Istirahat",
				"PKN",
				"PKN",
				"Biologi",
				"Istirahat",
				"Biologi",
				"Matematika Minat",
				"Matematika Minat"
			],
			"jumat" => [
				"Kimia",
				"Kimia",
				"BK",
				"Penjaskes",
				"Istirahat",
				"Penjaskes",
				"Penjaskes",
				"Istirahat",
				"Sholat Jum'at",
				"Matematika Wajib",
				"Matematika Wajib"
			],
			"sabtu" => [
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama"
			],
			"minggu" => [
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama",
				"Nguli bersama"
			]
		];
	}

	public function exe()
	{
		$r = explode(" ", $this->b->lowertext, 3);
		if (isset($r[1])) {
			$ld = [
				"senin" 	=> ["senen"],
				"selasa"	=> ["seloso"],
				"rabu"		=> ["rebo"],
				"kamis"		=> ["kemis"],
				"jumat"		=> ["jum'at","jum\"at"],
				"sabtu"		=> ["sebtu"],
				"minggu"	=> []
			];
			foreach ($ls as $key => $val) {
				if ($r[1] === $key) {
					return $this->jadwal[$key];
				} else {
					foreach ($val as $val) {
						if ($r[1] === $val) {
							return $this->jadwal[$key];
						}
					}
				}
			}
		}
		return false;
	}

	public function run()
	{
		if ($ex = $this->exe()) {
			$r = ""; $i = 1;
			foreach ($ex as $val) {
				$r .= ($i++).". ".$val."\n";
			}
			LINE::push(
				[
					"to" 		=> $this->b->chat_id,
					"messages"	=> [
						[
							"type" 	=> "text",
							"text"	=> $r
						]
					]
				]
			);
		}
	}
}
