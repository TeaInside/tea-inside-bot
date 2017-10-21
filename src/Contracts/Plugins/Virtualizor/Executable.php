<?php

namespace Contracts\Plugins\Virtualizor;

interface Executable
{
	public function __construct($code);

	public function exec();
}