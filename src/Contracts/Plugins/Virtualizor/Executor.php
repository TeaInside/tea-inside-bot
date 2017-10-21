<?php

namespace Contracts\Plugins\Virtualizor;

interface Compiler
{
	public function __construct($code);

	public function exec();
}