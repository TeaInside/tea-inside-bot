<?php

namespace App\Virtualizor\Lang;

use App\Virtualizor\Compiler;
use System\Contracts\App\Virtualizor\LangContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Java extends Compiler implements LangContract
{

	/**
	 * Constructor.
	 *
	 * @param string $javaCode
	 */
	public function __construct($javaCode)
	{
	}
}