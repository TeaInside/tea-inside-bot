<?php

namespace Handler;

use Handler\MainHandler;

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
                ? "Private" : "Group";
        if ($conder) {
            $st = new UserHandler($this->h);
            $tr = $st->track();
            if ($tr === false) {
                $tr->saveNewUser();
            } elseif ($tr === "change") {
                $tr->saveChange();
            }
        } else {
            $st = new UserHandler($this->h);
            $tr = $st->track();
            if ($tr === false) {
                $tr->saveNewUser();
            } elseif ($tr === "change") {
                $tr->saveChange();
            }
            $st = new GroupHandler($this->h);
            $tr = $st->track();
            if ($tr === false) {
                $tr->saveNewGroup();
            }
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
