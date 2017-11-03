<?php

namespace Plugins\KulgramWriter\Actions;

use Telegram as B;
use Plugins\KulgramWriter\KulgramWriterFoundation;

class Init extends KulgramWriterFoundation
{
    public function run()
    {
        if (file_exists($this->lockfile)) {
            return false;
        }
        $l = $this->b->lowertext;
        $a = explode("topik saat ini", $l, 2);
        if (! isset($a[1])) {
            $a = explode("topik hari ini", $l, 2);
            if (! isset($a[1])) {
                $a = explode("materi hari ini", $l, 2);
                if (! isset($a[1])) {
                    $a = explode("materi kulgram hari ini", $l, 2);
                    if (! isset($a[1])) {
                        $a = explode("topik kulgram hari ini", $l, 2);
                        if (! isset($a[1])) {
                            return false;
                        }
                    }
                }
            }
        }
        
        $b = explode("oleh", $a[1], 2);
        $author = isset($b[1]) ? ucwords(strtolower(trim($b[1]))) : $this->b->name;
        $title  = isset($b[1]) ? strtoupper(trim($b[0])) : strtoupper(trim($a[1]));
        $this->getInfo();
        $data =[
        "start" => null,
        "title" => $title,
        "author" => $author,
        "init_time" => time()
        ];
        if ($this->infodata) {
            $this->infodata['count']++;
            $this->infodata['status'] = "init";
            $this->infodata['list'][] = $data;
        } else {
            $this->infodata = [
            "chat_title" => $this->b->chattitle,
            "chat_id" => $this->b->chat_id,
            "status" => "init",
            "count" => 1,
            "list" => [$data]
            ];
        }
        $this->writeInfo();
        file_put_contents($this->lockfile, json_encode($data));
        B::sendMessage(
            [
            "text" => "Baiklah, topik saat ini adalah <b>\"".htmlspecialchars($title)."\"</b> oleh <b>".htmlspecialchars($author)."</b>",
            "chat_id" => $this->b->chat_id,
            "parse_mode" => "HTML"
            ]
        );
    }
}