<?php

namespace Telegram\Exceptions;

use Exception;

class LanguageNotFoundException extends Exception
{
	public function __construct(...$a)
	{
		parent::__construct(...$a);
	}
}