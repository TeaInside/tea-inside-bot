<?php

namespace Plugins\KulgramWriter\Actions;

use Telegram as B;
use Plugins\KulgramWriter\KulgramWriterFoundation;

class Start extends KulgramWriterFoundation
{
    public function run()
    {
        if (file_exists($this->lockfile)) {
            $this->getInfo();
            if ($this->infodata['status'] === "init") {
                $this->infodata['status'] = "start";
                $this->infodata['list'][$this->infodata['count'] - 1]['start'] = time();
                $this->start();
                $this->writeInfo();
                B::sendMessage(
                    [
                    "text" => "Ok, saya mulai mencatat ✍️\nini notulen ke ".$this->infodata['count'],
                    "chat_id" => $this->b->chat_id
                    ]
                );
            }
        }
        return false;
    }
}
