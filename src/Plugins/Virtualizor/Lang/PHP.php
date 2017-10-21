<?php

namespace Plugins\Virtualizor\Lang;

use Curl;
use Plugins\Virtualizor\Interpreter;
use Contracts\Plugins\Virtualizor\Executable;

final class PHP extends Interpreter implements Executable
{	

	/**
	 * @var string
	 */
	private $code;

	/**
	 * @var string
	 */
	priavte $hash;

	/**
	 * @var string
	 */
	private $errorMessage;

	/**
	 * Constructor.
	 *
	 * @param string $code
	 */
	public function __construct($code)
	{
		$this->code = $code;
		$this->hash = sha1($code);
	}

	public function init()
	{
		if (! defined(PHP_VIRTUAL_DIR)) {
			$this->errorMessage = "PHP_VIRTUAL_DIR is not defined yet!";
			return false;
		}

		if (! defined(PHP_VIRTUAL_URL)) {
			$this->errorMessage = "PHP_VIRTUAL_URL is not defined yet!";
			return false;
		}

		is_dir(PHP_VIRTUAL_DIR) or shell_exec("mkdir -p ".PHP_VIRTUAL_DIR);

		if (! is_dir(PHP_VIRTUAL_DIR)) {
			$this->errorMessage = "Cannot create directory ".PHP_VIRTUAL_DIR;
			return false;
		}

		if (! file_exists(PHP_VIRTUAL_DIR."/".$this->hash.".php")) {
			$handle = fopen(PHP_VIRTUAL_DIR."/".$this->hash.".php", "w");
			fwrite($handle, $this->code);
			fclose($handle);
			if (! file_exists(PHP_VIRTUAL_DIR."/".$this->hash.".php")) {
				$this->errorMessage = "Cannot create file ".PHP_VIRTUAL_DIR."/".$this->hash.".php";
				return false;
			}
		}
		return true;
	}

	public function exec()
	{
		$st = new Curl(PHP_VIRTUAL_URL."/".$this->hash.".php");
		$st->set_opt(
			[
				CURLOPT_TIMEOUT 	   => 5,
				CURLOPT_CONNECTTIMEOUT => 5
			]
		);
		$st  = $st->exec();
		$err = $st->error and $st = $err;
		return $st;
	}

	public function errorInfo()
	{
		return $this->errorMessage;
	}
}