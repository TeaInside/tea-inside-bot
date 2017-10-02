<?php

namespace System\Contracts\App\Virtualizor;

interface LangContract
{
    /**
     * @param string $code
     */
    public function __construct($code);

    /**
     * Exec code.
     */
    public function exec();
}
