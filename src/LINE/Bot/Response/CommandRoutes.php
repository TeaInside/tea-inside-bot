<?php

namespace LINE\Bot\Response;

use LINE;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.1
 * @license MIT
 */
trait CommandRoutes
{
    private function writeRoutes()
    {
        $st = explode(" ", $this->b->text, 2);
        
        $this->route(
            function () use ($st) {
                $st[0] = strtolower($st[0]);
                return 
                        $st[0] === "/google" ||
                        $st[0] === "!google" ||
                        $st[0] === "~google" ||
                        $st[0] === "/g"      ||
                        $st[0] === "!g"      ||
                        $st[0] === "~g";
            },
            "SearchEngine@googleSearch"
        );
        
        $this->route(
            function () use ($st) {
                return 
                        $st[0] === "/tl"    ||
                        $st[0] === "!tl"    ||
                        $st[0] === "~tl";
            },
            "Translator@googletranslate"
        );
        
    }
}
