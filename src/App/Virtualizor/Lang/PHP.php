<?php

namespace App\Virtualizor\Lang;

use Curl;
use System\Contracts\App\Virtualizor\LangContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */

class PHP implements LangContract
{
	/**
	 * @var string
	 */
	private $phpCode;

	/**
	 * @var string
	 */
	private $hash;

	/**
	 * @var string
	 */
	private $file;

	/**
	 * Constructor.
	 * @param string $phpCode
	 */
	public function __construct($phpCode)
	{
		$this->phpCode = $phpCode;
		$this->hash	   = sha1($phpCode);
		$this->file	   = VIRTUALIZOR_DIR."/php/".$this->hash.".php";
	}

	/**
	 * Init php file.
	 */
	private function __init()
	{
		if (! is_dir(VIRTUALIZOR_DIR."/php/")) {
			$exe = shell_exec("mkdir -p ".VIRTUALIZOR_DIR."/php/ 2>&");
			if (! is_dir(VIRTUALIZOR_DIR."/php/")) {
				throw new \Exception($exe, 1);
			}
		}
		if (! file_exists($this->file)) {
			$handle = fopen($this->file, "w");
			fwrite($handle, $this->phpCode);
			fclose($handle);
		}
	}

	/**
	 * Exec php code.
	 */
	public function exec()
	{
		$this->__init();
		$ch = new Curl(VIRTUALIZOR_URL."/php/".$this->hash.".php");
		$ch->set_opt(
			[
				CURLOPT_TIMEOUT => 5,
				CURLOPT_CONNECTTIMEOUT => 5
			]
		);
		$out = $ch->exec();
		$ch->errno and $out = $ch->error;
		return $out;
	}
}