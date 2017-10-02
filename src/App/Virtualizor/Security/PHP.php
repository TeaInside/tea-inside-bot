<?php

namespace App\Virtualizor\Security;

use System\Contracts\App\Virtualizor\SecurityContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class PHP implements SecurityContract
{	
	/**
	 * @var string
	 */
	private $phpCode;

	/**
	 * @var int
	 */
	private $restrictedToken = 0;

	/**
	 * @var string
	 */

	/**
	 * Constructor.
	 * @param string $code
	 */
	public function __construct($phpCode)
	{
		$this->phpCode = $phpCode;
	}

	/**
	 * Parse php code.
	 */
	private function parsePHPCode()
	{
	}

	/**
	 * @return bool
	 */
	public function is_secure()
	{
		$this->parsePHPCode();
		return $this->restrictedToken === 0;
	}
}

