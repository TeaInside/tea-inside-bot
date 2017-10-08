<?php

namespace App\Brainly;

use Curl;

class Brainly
{
	const BRAINLY_API = "https://brainly.co.id/api/28/api_tasks/suggester";

	/**
	 * @var string
	 */
	private $hash;

	/**
	 * @var string
	 */
	private $query;

	/**
	 * @var string
	 */
	private $file;

	/**
	 * Constructor.
	 *
	 * @param string $query
	 */
	public function __construct($query)
	{
		$this->query = $query;
		$this->hash  = sha1($query);
		$this->file  = data."/brainly/cache/".$this->hash.".json";
	}

	private function __init()
	{
		is_dir(data."/brainly") or shell_exec("mkdir -p ".data."/brainly");
		is_dir(data."/brainly/cache") or shell_exec("mkdir -p ".data."/brainly/cache");
		if (file_exists($this->file)) {
			$this->result = json_decode(file_get_contents($this->file), true);
		}
	}
}