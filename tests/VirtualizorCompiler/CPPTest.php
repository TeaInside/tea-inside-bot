<?php

namespace VirtualizorCompiler;

use App\Virtualizor\Lang\CPP;
use PHPUnit\Framework\TestCase;

class CPPTest extends TestCase
{
	public function test1()
	{
		$code = "
#include <iostream>
using namespace std;

int main() 
{
    cout << \"hello world\";
    return 0;
}
		";
		$aa = new CPP($code);
		$this->assertTrue($aa->exec() == "hello world");
	}
}
