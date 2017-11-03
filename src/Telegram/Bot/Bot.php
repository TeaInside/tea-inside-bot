<?php

namespace Telegram\Bot;

use Telegram\Bot\Response;
use Telegram\Bot\SaveEvent;
use Telegram as B;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class Bot
{

    /**
     * @var array
     */
    public $input = [];

    /**
     * @var string
     */
    public $chattitle;

    /**
     * @var string
     */
    public $chatuname;

    /**
     * @var string
     */
    public $msgtype;

    /**
     * @var string
     */
    public $update_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $msgid;

    /**
     * @var int
     */
    public $date;

    /**
     * @var text
     */
    public $text;

    /**
     * @var string
     */
    public $lowertext;

    /**
     * @var array
     */
    public $entities = [];

    /**
     * @var string
     */
    public $chat_id;

    /**
     * @var string
     */
    public $chattype;
    
    /**
     * @var array
     */
    public $photo = [];

    /**
     * @var bool
     */
    public $is_bot;

    /**
     * @var string
     */
    public $user_id;

    /**
     * @var array
     */
    public $replyto = [];

    /**
     * Constructor.
     *
     * @param string $input
     */
    public function __construct($input)
    {
        $this->input = json_decode($input, true);
    }

    /**
     * Parse webhook event.
     */
    private function parseEvent()
    {
        $this->chattitle = isset($this->input['message']['chat']['title']) ? $this->input['message']['chat']['title'] : null;
        $this->chatuname = isset($this->input['message']['chat']['username']) ? $this->input['message']['chat']['username'] : null;
        if (isset($this->input['message']['text'])) {
            $this->msgtype   = "text";
            $this->update_id = $this->input['update_id'];
            $this->name         = $this->input['message']['from']['first_name'] . (isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : "");
            $this->username  = isset($this->input['message']['from']['username']) ? $this->input['message']['from']['username'] : null;
            $this->msgid     = $this->input['message']['message_id'];
            $this->date      = $this->input['message']['date'];
            $this->text      = $this->input['message']['text'];
            $this->lowertext = strtolower($this->input['message']['text']);
            $this->entities  = isset($this->input['message']['entities']) ? $this->input['message']['entities'] : [];
            $this->chat_id     = $this->input['message']['chat']['id'];
            $this->chattype  = $this->input['message']['chat']['type'];
            $this->is_bot    = $this->input['message']['from']['is_bot'];
            $this->user_id   = $this->input['message']['from']['id'];
            $this->replyto   = isset($this->input['message']['reply_to_message']) ? $this->input['message']['reply_to_message'] : [];
            $this->first_name = $this->input['message']['from']['first_name'];
            $this->last_name  = isset($this->input['message']['from']['last_name']) ? $this->input['message']['from']['last_name'] : "";
        } else if (isset($this->input['message']['photo'])) {
            $this->photo = $this->input['message']['photo'];
            $this->msgtype   = "photo";
            $this->update_id = $this->input['update_id'];
            $this->name         = $this->input['message']['from']['first_name'] . (isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : "");
            $this->username  = isset($this->input['message']['from']['username']) ? $this->input['message']['from']['username'] : null;
            $this->msgid     = $this->input['message']['message_id'];
            $this->date      = $this->input['message']['date'];
            $this->text      = isset($this->input['message']['caption']) ? $this->input['message']['caption'] : null;
            $this->lowertext = strtolower($this->text);
            $this->entities  = isset($this->input['message']['entities']) ? $this->input['message']['entities'] : [];
            $this->chat_id     = $this->input['message']['chat']['id'];
            $this->chattype  = $this->input['message']['chat']['type'];
            $this->is_bot    = $this->input['message']['from']['is_bot'];
            $this->user_id   = $this->input['message']['from']['id'];
            $this->replyto   = isset($this->input['message']['reply_to_message']) ? $this->input['message']['reply_to_message'] : [];
            $this->first_name = $this->input['message']['from']['first_name'];
            $this->last_name  = isset($this->input['message']['from']['last_name']) ? $this->input['message']['from']['last_name'] : "";
        }
    }


    /**
     * Response.
     */
    private function response()
    {
        $st = new Response($this);
        return $st->run();
    }

    /**
     * Run bot.
     */
    public function run()
    {
        $this->parseEvent();
        $res = $this->response();
        if (in_array($this->msgtype, ["text","photo"])) {
            $st  = new SaveEvent($this);
            $st->run();
        }
        return $res;
    }
}