<?php

namespace Handler\Response;

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
	 * Constructor.
	 * @param string $lowerText
	 * @param string $absText
	 */
	public function __construct($lowerText, $absText, $sudo = false)
	{
		$this->lowerText    = strtolower($lowerText);
		$this->absText 		= $absText;
		$this->sudo 		= $sudo;
	}

	/**
	 * Exec.
	 */
	public function exec()
	{
		if (substr($this->lowerText, 0, 5) == "<?php") {
			$lang = "php";
		}

		return isset($lang) ? 
				( $this->is_secure($lang) ? $this->exec() : false ) :
					(null);
	}

	/**
	 * @param string $par
	 */
	private function is_secure($par = null)
	{
		if ($this->sudo) {
			return true;
		}
		switch ($par) {
			case 'php':
				$st = new PHPSecurity($this->absText);
				$this->executor = "\\App\\Virtualizor\\Lang\\PHP";
				break;
			default:
				return false;
				break;
		}
		return $st->is_secure();
	}

	/**
	 * @param Exec
	 */
	private function exec()
	{
		$st = new $this->executor($this->absText);
		$st = trim($st->exec());
		return $st === "" ? "~" : $st;
	}
}