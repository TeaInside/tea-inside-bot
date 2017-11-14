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
            "LINEForwarder@run"
        );

        $this->set(
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

        $this->set(
            function() use ($st) {
                return
                    $st[0] === "jne" ||
                    $st[0] === "jnt";
            },
            "Kurir@check"
        );

        $this->set(
            function() use ($st) {
                return
                $st[0] === "/anime"      ||
                $st[0] === "!anime"      ||
                $st[0] === "~anime"      ||
                (!empty($this->b->replyto) and $this->b->replyto['text'] === "Anime apa yang kamu cari?" and $this->b->lowertext = "/anime ".$this->b->lowertext);
            },
            "Anime@animeSearch"
        );

        $this->set(
            function() use ($st) {
                return
                $st[0] === "/idan"      ||
                $st[0] === "!idan"      ||
                $st[0] === "~idan"      ||
                (!empty($this->b->replyto) and $this->b->replyto['text'] === "Sebutkan ID Anime!" and $this->b->lowertext = "/idan ".$this->b->lowertext);
            },
            "Anime@animeInfo"
        );

        $this->set(
            function() use ($st) {
                return
                $st[0] === "/manga"      ||
                $st[0] === "!manga"      ||
                $st[0] === "~manga"      ||
                (!empty($this->b->replyto) and $this->b->replyto['text'] === "Manga apa yang kamu cari?" and $this->b->lowertext = "/manga ".$this->b->lowertext);
            },
            "Anime@mangaSearch"
        );
        
        $this->set(
            function() use ($st) {
                return
                $st[0] === "/idma"      ||
                $st[0] === "!idma"      ||
                $st[0] === "~idma"      ||
                (!empty($this->b->replyto) and $this->b->replyto['text'] === "Sebutkan ID Manga!" and $this->b->lowertext = "/idma ".$this->b->lowertext);
            },
            "Anime@mangaInfo"
        );
    }
}
