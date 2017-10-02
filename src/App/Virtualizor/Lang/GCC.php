<?php

namespace App\Virtualizor\Lang;

use App\Virtualizor\Compiler;
use System\Contracts\App\Virtualizor\LangContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class GCC extends Compiler implements LangContract
{
	/**
	 * @var string
	 */
	private $cCode;

	/**
	 * @var string
	 */
	private $hash;

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var string
	 */
	private $errorInfo;

	/**
	 * Constructor.
	 *
	 * @param string $cCode
	 */
	public function __construct($cCode)
	{
		$this->cCode = $cCode;
		$this->hash  = sha1($cCode);
		$this->file  = VIRTUALIZOR_DIR."/c/".$this->hash.".c";
	}

	/**
	 * Init file.
	 */
	private function __init()
	{
		if (! is_dir(VIRTUALIZOR_DIR."/c")) {
			$exe = shell_exec("mkdir -p ".VIRTUALIZOR_DIR."/c");
			if (! is_dir(VIRTUALIZOR_DIR."/c")) {
				throw new \Exception($exe, 1);
			}
		}
		if (! file_exists($this->file)) {
			$handle = fopen($this->file, "w");
			fwrite($handle, $this->cCode);
			fclose($handle);
		}
		if (file_exists($this->file)) {
			return true;
		} else {
			$this->errorInfo = "Error create file.";
			return false;
		}
	}

	/**
	 * Compile it.
	 */
	private function __compile()
	{
		$check = shell_exec("gcc --version || echo 0");
		if ($check == 0) {
			$this->errorInfo = "GCC not installed!";
			return false;
		}

		$compile = shell_exec("gcc ".$this->file." -o ".VIRTUALIZOR_DIR."/c/".$this->hash." 2>&1");
		if ($compile) {
			$this->errorInfo = $compile;
			return false;
		}
		return true;
	}

	/**
	 * Run.
	 */
	private function __exec()
	{
		$exec = shell_exec(VIRTUALIZOR_DIR."/c/".$this->hash);
		if ($exec) {
			return $exec;
		} else {
			return "~";
		}
	}

	/**
	 * Executor.
	 */
	public function exec()
	{
		if ($this->__init()) {
			$this->__compile();
			if (! $this->errorInfo) {
				return $this->__exec();
			} else {
				return $this->errorInfo;
			}
		} else {
			return $this->errorInfo;
		}
	}
}