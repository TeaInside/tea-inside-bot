<?php

namespace Bot\Response;

trait CommandRoutes
{
	private function buildCMDRoutes()
	{
		$this->set(function()
		{
		}, "ShellExec@run");
	}
}