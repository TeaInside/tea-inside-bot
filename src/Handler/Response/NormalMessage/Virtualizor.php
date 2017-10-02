<?php

namespace Handler\Response\NormalMessage;

defined("VIRTUALIZOR_DIR") or die("VIRTUALIZOR_DIR not defined yet!\n");
defined("VIRTUALIZOR_URL") or die("VIRTUALIZOR_URL not defined yet!\n");

use App\Virtualizor\Security\PHP as PHPSecurity;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Virtualizor
{
	/** 
	 * @var string
	 */
	private $text;

	/**
	 * @var string
	 */
	private $absText;

	/**
	 * @var bool
	 */
	private $sudo;

	/**
	 * @var string
	 */
	private $executor;

	/**
	 * @var string
	 */
	private $lang;

	/**
	 * @var ???
	 */
	private $skip_security;

	/**
	 * Constructor.
	 * @param string $lowerText
	 * @param string $absText
	 */
	public function __construct($lowerText, $absText, $sudo = false)
	{
		$this->lowerText    = strtolower($lowerText);
		$this->absText 		= $absText;
		$this->sudo 		= $sudo;
		$this->skip_security= new class(){
			public function is_secure()
			{
				return true;
			}
		};
	}

	/**
	 * Exec.
	 */
	public function exec()
	{
		if (substr($this->lowerText, 0, 5) == "<?php") {
			$lang = "php";
		} elseif (substr($this->lowerText, 0, 3) == "<?c") {
			$this->absText = substr($this->absText, 3);
			$lang = "gcc";
		}

		return isset($lang) ? 
				( $this->is_secure($lang) ? $this->__exec() : false ) :
					(null);
	}

	/**
	 * @return string
	 */
	public function getLang()
	{
		return $this->lang;
	}

	/**
	 * @param string $par
	 */
	private function is_secure($par = null)
	{
		$this->lang = $par;
		$this->getExecutor();
		if ($this->sudo) {
			return true;
		}
		switch ($par) {
			case 'php':
				$st = new PHPSecurity($this->absText);
				break;
			case 'gcc':
				$st = $this->skip_security;
				break;
			default:
				return false;
				break;
		}
		return $st->is_secure();
	}

	private function getExecutor()
	{
		switch ($this->lang) {
			case 'php':
				$this->executor = "\\App\\Virtualizor\\Lang\\PHP";
				break;
			case 'gcc':
				$this->executor = "\\App\\Virtualizor\\Lang\\GCC";
				break;
			default:
				break;
		}
	}

	/**
	 * Private executor.
	 */
	private function __exec()
	{
		$class = $this->executor;
		$st = new $class($this->absText);
		$st = trim($st->exec());
		return $st === "" ? "~" : $st;
	}
}