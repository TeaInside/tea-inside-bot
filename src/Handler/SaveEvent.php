<?php

namespace Handler;

use Handler\MainHandler;
use Handler\SaveEvent\UserHandler;
use Handler\SaveEvent\GroupHandler;

final class SaveEvent
{
    /**
     * @var Handler\MainHandler
     */
    private $h;

    /**
     * @var string
     */
    private $saver;

    /**
     * Constructor.
     *
     * @param Handler\MainHandler $handler
     */
    public function __construct(MainHandler $handler)
    {
        $this->h = $handler;
    }

    private function getSaverClass()
    {
        $chattype = ($conder = $this->h->chattype === "private") 
                ? "PrivateChat" : "GroupChat";
        if ($conder) {
            $st = new UserHandler($this->h);
            $tr = $st->track();
            if ($tr === false) {
                $st->saveNewUser();
            } elseif ($tr === "change") {
                $st->saveChange();
            }
            $st->saveCountMessage("private");
            var_dump(456);
        } else {
            $st = new UserHandler($this->h);
            $tr = $st->track();
            if ($tr === false) {
                $st->saveNewUser();
            } elseif ($tr === "change") {
                $st->saveChange();
            }
            $st->saveCountMessage("");
            $st = new GroupHandler($this->h);
            $tr = $st->track();
            if ($tr === false) {
                $st->saveNewGroup();
            } elseif ($tr === "change") {
                $st->saveChange();
            }
            var_dump(123);
        }
        switch ($this->h->msgtype) {
            case 'text':
                $this->saver = "\\Handler\\SaveEvent\\{$chattype}\\Text";
                break;
            default:
                break;
        }
    }

    public function save()
    {
        $this->getSaverClass();
        if (isset($this->saver)) {
            $st = new $this->saver($this->h);
            return $st->save();
        }
        return false;
    }
}
