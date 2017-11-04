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
        $st = explode(" ", $this->b->lowertext, 2);
        
        $this->route(
            function () use ($st) {
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

        $this->route(
            function () use ($st) {
                if (isset($st[1])) {
                    $r = explode(" ", $st[1]);
                    if (count($r) > 2) {
                        return false;
                    }
                }
                return
                        $st[0] === "jadwal"     ||
                        $st[0] === "/jadwal"    ||
                        $st[0] === "!jadwal"    ||
                        $st[0] === "~jadwal"    ||
                        $st[0] === "-jadwal";
            },
            "Jadwal@run"
        );
        
        $this->route(
            function () use ($st) {
                return
                        $st[0] === "ask"        ||
                        $st[0] === "/ask"       ||
                        $st[0] === "!ask"       ||
                        $st[0] === "~ask"       ||
                        $st[0] === "#ask";
            },
            "Brainly@ask"
        );
    }
}
