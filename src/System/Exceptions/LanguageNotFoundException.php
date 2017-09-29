<?php

namespace System\Exceptions;

use Exception;

class LanguageNotFoundException extends Exception
{
	public function __construct(...$param)
	{
		parent::__construct(...$param);
	}
}