<?php

namespace System\Contracts\App\Virtualizor;

interface SecurityContract
{	
	/**
	 * @param string $code
	 */
	public function __construct($code);

	/**
	 * @return bool
	 */
	public function is_secure();
}