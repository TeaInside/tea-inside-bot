<?php

namespace Telegram\Bot\Response\Command;

use Bridge;
use Telegram as B;
use Telegram\Bot\Bot;
use Telegram\Bot\Abstraction\CommandFoundation;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class LINEForwarder extends CommandFoundation
{
    

    /**
     * @var \Bot\Bot
     */
    private $b;

    /**
     * Constructor.
     *
     * @param \Bot\Bot $bot
     */
    public function __construct(Bot $bot)
    {
        $this->b = $bot;
    }

    public function run()
    {
        if ($this->b->msgtype === "text") {
            $__text = [];
            foreach (str_split($this->b->name."\n\n".$this->b->text, 1999) as $val) {
                $__text = [
                    "type" => "text",
                    "text" => $val
                ];
            }
            $data = [
                    "to" => "Ce20228a1f1f98e6cf9d6f6338603e962",
                    "messages" => [
                        [
                            "type" => "text",
                            "text" => $__text
                        ]
                    ]
                ];
        } elseif ($this->b->msgtype === "photo") {
            $this->savePhoto();
            $data = [
                    "to" => "Ce20228a1f1f98e6cf9d6f6338603e962",
                    "messages" => [
                        [
                            "type" => "text",
                            "text" => $__text
                        ]
                    ]
                ];
        }

        return Bridge::go("line", ["\"".urlencode(json_encode($data))."\""], true);
    }

    private function savePhoto()
    {
        $p = end($this->b->photo);
        $a = B::getFile([
            "file_id" => $p['file_id']
        ]);
        var_dump($a['content']);
    }
}
