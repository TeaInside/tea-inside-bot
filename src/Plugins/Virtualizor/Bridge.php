<?php

namespace Plugins\Virtualizor;

use Plugins\Virtualizor\Compiler;
use Plugins\Virtualizor\Interpreter;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 * 
 * Virtualizor brigde.
 */
final class Bridge
{
    

    /**
     * @var array
     */
    private static $map = [
    "php" => "\\Plugins\\Virtualizor\\Lang\\PHP"
    ];

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $lang;

    /**
     * Constructor
     *
     * @param string $code
     * @param string $lang
     */
    public function __construct($code, $lang)
    {
        $this->code = $code;
        $this->lang = $lang;
    }

    private function initLangInstance()
    {
        return new self::$map[$this->lang]($this->code);
    }

    public function exec()
    {
        if (isset(self::$map[$this->lang])) {
            $st = $this->initLangInstance();
            if ($st->init()) {
                if ($st instanceof Compiler) {
                    if ($st->compile()) {
                        $st = $st->exec();
                        return $st==="" ? "~" : $st;
                    } else {
                        return $st->errorInfo();
                    }
                } elseif ($st instanceof Interpreter) {
                    $st = $st->exec();
                    return $st==="" ? "~" : $st;
                }
            } else {
                return $st->errorInfo();
            }
        } else {
            return "Plugin not found!";
        }
    }    
}