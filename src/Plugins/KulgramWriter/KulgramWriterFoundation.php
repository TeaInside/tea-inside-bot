<?php

namespace Plugins\KulgramWriter;

use Bot\Bot;

abstract class KulgramWriterFoundation
{
    protected $b;
    
    protected $path;
    
    protected $lockfile;

    protected $infofile;

    protected $tmpdir;

    protected $infodata = [];
    
    public function __construct(Bot $bot)
    {
        $this->b = $bot;
        $this->path = data."/kulgram";
        $this->lockfile = $this->path."/data/".$bot->chat_id."/lock/".$bot->chat_id.".lock";
        $this->infofile = $this->path."/info/".$bot->chat_id.".info";
        $this->tmpdir = $this->path."/data/".$bot->chat_id."/tmp/";
        is_dir($this->path) or mkdir($this->path);
        is_dir($this->path."/data") or mkdir($this->path."/data");
        is_dir($this->path."/info") or mkdir($this->path."/info");
        $this->datapath = $this->path."/data/".$bot->chat_id;
        is_dir($this->path."/data/".$bot->chat_id) or mkdir($this->path."/data/".$bot->chat_id);
        is_dir($this->path."/data/".$bot->chat_id."/lock") or mkdir($this->path."/data/".$bot->chat_id."/lock");
        is_dir($this->path."/data/".$bot->chat_id."/tmp") or mkdir($this->path."/data/".$bot->chat_id."/tmp");
    }

    protected function getInfo()
    {
        if (file_exists($this->infofile)) {
            $this->infodata = json_decode(file_get_contents($this->infofile), true);
        }
    }

    protected function writeInfo()
    {
        file_put_contents($this->infofile, json_encode($this->infodata));
    }

    protected function start()
    {
        file_put_contents($this->lockfile.".start", 1);
    }
}