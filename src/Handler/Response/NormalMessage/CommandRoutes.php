<?php

namespace Handler\Response\NormalMessage;

use Lang;
use Closure;
use Telegram as B;
use Handler\MainHandler;
use Handler\Response\NormalMessage\CommandUtils as CMDUtil;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class CommandRoutes
{
    /**
     * @var Handler\MainHandler
     */
    private $h;

    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var object
     */
    public $run;

    /**
     * Constructor.
     *
     * @param Handler\MainHandler
     */
    public function __construct(MainHandler $handler)
    {
        $this->h = $handler;
        $a = explode(" ", $handler->lowertext, 2);
        $this->startWith = $a[0];
        $this->init_routes();
    }

    private function init_routes()
    {
        Lang::init("id");
        Lang::initMainHandler($this->h);

        /**
         * Translate
         */
        $this->route(function () {
            return
                CMDUtil::firstWorld($this->h->lowerText, "/translate") ||
                CMDUtil::firstWorld($this->h->lowerText, "!translate") ||
                CMDUtil::firstWorld($this->h->lowerText, "~translate") ||
                CMDUtil::firstWorld($this->h->lowerText, "/tl")           ||
                CMDUtil::firstWorld($this->h->lowerText, "!tl")           ||
                CMDUtil::firstWorld($this->h->lowerText, "~tl");
        }, "\\Handler\\Response\\NormalMessage\\Command\\Translate");

        /**
         * Translate replied message.
         */
        $this->route(function () {
            return
                CMDUtil::firstWorld($this->h->lowerText, "/tlr")           ||
                CMDUtil::firstWorld($this->h->lowerText, "!tlr")           ||
                CMDUtil::firstWorld($this->h->lowerText, "~tlr");
        }, "\\Handler\\Response\\NormalMessage\\Command\\TranslateRepliedMessage");

        /**
         * Admin list.
         */
        $this->route(function () {
            return
                CMDUtil::firstWorld($this->h->lowerText, "/admin")           ||
                CMDUtil::firstWorld($this->h->lowerText, "!admin")           ||
                CMDUtil::firstWorld($this->h->lowerText, "~admin");
        }, "\\Handler\\Response\\NormalMessage\\Command\\Admin");

        /**
         * Start bot.
         */
        $this->route(function () {
            return
                $this->h->lowerText === "/start";
        }, "\\Handler\\Response\\NormalMessage\\Command\\Start");
        
        /**
         * Ping bot.
         */
        $this->route(function () {
            return
                CMDUtil::firstWorld($this->h->lowerText, "/ping")           ||
                CMDUtil::firstWorld($this->h->lowerText, "!ping")           ||
                CMDUtil::firstWorld($this->h->lowerText, "~ping");
        }, function () {
            B::sendMessage(
                [
                    "chat_id" => $this->h->chat_id,
                    "text" => (time() - ($this->h->time))." s",
                    "reply_to_message_id" => $this->h->msgid
                ]
            );
        });

        return isset($this->run);
    }

    private function route(Closure $a, $route)
    {
        if (isset($this->run)) {
            return false;
        }
        if (((bool) $a())) {
            $this->run = $route;
            return true;
        }
        return false;
    }

    public function needResponse()
    {
        return $this->init_routes();
    }
}
