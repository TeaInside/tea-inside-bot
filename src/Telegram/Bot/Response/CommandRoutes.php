<?php

namespace Telegram\Bot\Response;

use Telegram as B;

trait CommandRoutes
{
    private function buildCMDRoutes()
    {
        $st = explode(" ", $this->b->lowertext, 2);
        $st = explode("@", $st[0]);


        /**
         * Shell exec
         */
        $this->set(
            function () use ($st) {
        
                return
                $st[0] === "/sh"       ||
                $st[0] === "!sh"      ||
                $st[0] === "~sh"      ||
                $st[0] === "sh"       ||
                $st[0] === "/shexec" ||
                $st[0] === "!shexec" ||
                $st[0] === "~shexec" ||
                $st[0] === "shexec";
            },
            "ShellExec@run"
        );


        /**
         * Ping bot.
         */
        $this->set(
            function () use ($st) {
        
                return
                $st[0] === "/ping"   ||
                $st[0] === "!ping"      ||
                $st[0] === "~ping"      ||
                $st[0] === "ping";
            },
            function () {
                $start = microtime(true);
                $st = json_decode(
                    B::sendMessage(
                        [
                        "text"                     => "Pong!",
                        "chat_id"               => $this->b->chat_id,
                        "reply_to_message_id" => $this->b->msgid
                        ]
                    )['content'],
                    true
                );
                isset($st['result']['message_id']) and B::editMessageText(
                    [
                    "chat_id" => $this->b->chat_id,
                    "message_id" => $st['result']['message_id'],
                    "text" => "Pong!\n".((time() - $this->b->date) + round(microtime(true) - $start, 2))." s"
                    ]
                );
            }
        );


        /**
         * Ban user
         */
        $this->set(
            function () use ($st) {
        
                return
                $st[0] === "/ban"    ||
                $st[0] === "!ban"      ||
                $st[0] === "~ban";
            },
            "AdminHammer@ban"
        );


        /**
         * Google search.
         */
        $this->set(
            function () use ($st) {
        
                return
                $st[0] === "/google" ||
                $st[0] === "!google" ||
                $st[0] === "~google";
            },
            "SearchEngine@googleSearch"
        );


        /**
         * Translate
         */
        $this->set(
            function () use ($st) {
        
                return
                $st[0] === "/tl"           ||
                $st[0] === "!tl"          ||
                $st[0] === "~tl"          ||
                $st[0] === "/translate"    ||
                $st[0] === "!translate" ||
                $st[0] === "~translate";
            },
            "Translator@googleTranslate"
        );
        

        /**
         * Translate replied message
         */
        $this->set(
            function () use ($st) {
        
                return
                $st[0] === "/tlr"       ||
                $st[0] === "!tlr"          ||
                $st[0] === "~tlr"          ||
                $st[0] === "/trl"        ||
                $st[0] === "!trl"         ||
                $st[0] === "~trl";
            },
            "Translator@rgoogleTranslate"
        );

        /**
         * Init kulgram
         */
        $this->set(
            function () {
        
                return
                strpos($this->b->lowertext, "topik saat ini") !== false ||
                strpos($this->b->lowertext, "topik hari ini") !== false ||
                strpos($this->b->lowertext, "materi hari ini") !== false ||
                strpos($this->b->lowertext, "materi kulgram hari ini") !== false ||
                strpos($this->b->lowertext, "topik kulgram hari ini") !== false;
            },
            "KulgramWriter@init"
        );

        /**
         * Init kulgram
         */
        $this->set(
            function () {
        
                return
                strpos($this->b->lowertext, "mulai nyatet") !== false ||
                strpos($this->b->lowertext, "mulai catatan") !== false ||
                strpos($this->b->lowertext, "mulai nyatat") !== false;
            },
            "KulgramWriter@start"
        );

        /**
         * Init kulgram
         */
        $this->set(
            function () {
        
                return
                strpos($this->b->lowertext, "berhenti nyatat") !== false ||
                strpos($this->b->lowertext, "berhenti nyatet") !== false ||
                strpos($this->b->lowertext, "hentikan catatan") !== false;
            },
            "KulgramWriter@stop"
        );

        $this->set(
            function () {
        
                return
                strpos($this->b->lowertext, "berhenti nyatat") !== false ||
                strpos($this->b->lowertext, "berhenti nyatet") !== false ||
                strpos($this->b->lowertext, "hentikan catatan") !== false;
            },
            "KulgramWriter@stop"
        );

        $this->set(
            function () use ($st) {
        
                return $this->b->chattitle == "SOLID SQUARE";
            },
            function () {
                \Bridge::go(
                    "line",
                    ["\"".urlencode(
                        json_encode(
                            [
                            "to" => "Ce20228a1f1f98e6cf9d6f6338603e962",
                            "messages" => [
                            [
                            "type" => "text",
                            "text" => $this->b->name."\n\n".$this->b->text
                            ]
                            ]
                            ]
                        )
                    )."\""]
                );
            }
        );
    }
}
