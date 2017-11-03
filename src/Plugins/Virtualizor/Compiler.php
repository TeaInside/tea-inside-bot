<?php

namespace Plugins\Virtualizor;

use Exception;

/**
 * Compiler parent.
 */
abstract class Compiler
{

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * Constructor.
     *
     * @param string $code
     */
    abstract public function __construct($code);

    /**
     * Constructor.
     *
     * @return string
     */
    abstract public function exec();

    /**
     * @return string
     */
    abstract public function errorInfo();

    /**
     * Init code.
     */
    public function init()
    {
        throw new Exception("The Compiler::init method must override!");
    }

    /**
     * Compile code.
     */
    public function compile()
    {
        throw new Exception("The Compiler::compile method must override!");
    }
}
