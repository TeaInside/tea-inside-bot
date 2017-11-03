<?php

namespace Plugins\Virtualizor;

use Exception;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 *
 * Intepreter parent.
 */
abstract class Interpreter
{
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
        throw new Exception("The Intepreter::init method must override!");
    }
}