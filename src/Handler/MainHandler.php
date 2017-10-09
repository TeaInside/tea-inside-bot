<?php

namespace Handler;

use Lang;
use Telegram as B;
use Handler\Response;
use Handler\SaveEvent;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class MainHandler
{
    /**
     * @var array|null
     */
    public $replyto;

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
    public $chattype;

    /**
     * @var string
     */
    public $text;
    
    /**
     * @var string
     */
    public $lowertext;

    /**
     * @var string
     */
    public $chat_id;

    /**
     * @var string
     */
    public $msgId;

    /**
     * @var string
     */
    public $name;

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
    public $username;

    /**
     * Constructor.
     * @param string $input
     */
    public function __construct($input)
    {
        if ($input) {
            $this->input = json_decode($input, true);
        } else {
            $this->input = json_decode(file_get_contents("php://input"), true);
        }
    }

    /**
     * Run app.
     */
    public function run()
    {
        $this->parseEvent();
        $this->response();
    }

    /**
     * Parse Webhook Event.
     */
    private function parseEvent()
    {
        isset($this->input['message']['reply_to_message']) and $this->replyto = $this->input['message']['reply_to_message'];
        isset($this->input['message']['chat']['title']) and $this->chattitle = $this->input['message']['chat']['title'];
        isset($this->input['message']['chat']['username']) and $this->chatuname = $this->input['message']['chat']['username'];
        if (isset($this->input['message']['text'])) {
            $this->msgtype    = "text";
            $this->chattype   = $this->input['message']['chat']['type'];
            $this->text          = $this->input['message']['text'];
            $this->lowertext  = strtolower($this->text);
            $this->chat_id      = (string) $this->input['message']['chat']['id'];
            $this->msgid      = (string) $this->input['message']['message_id'];
            $this->name          = $this->input['message']['from']['first_name'] . (isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : "");
            $this->first_name = $this->input['message']['from']['first_name'];
            $this->last_name  = isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : null;
            $this->userid      = $this->input['message']['from']['id'];
            $this->username   = isset($this->input['message']['from']['username']) ? $this->input['message']['from']['username'] : null;
            $this->time    = $this->input['message']['date'];
        } elseif (isset($this->input['message']['photo'])) {
            $this->msgtype    = "photo";
            $this->chattype   = $this->input['message']['chat']['type'];
            $this->text          = isset($this->input['message']['caption']) ? $this->input['message']['caption'] : null;
            $this->photo      = end($this->input['message']['photo']);
            $this->lowertext  = strtolower($this->text);
            $this->chat_id      = (string) $this->input['message']['chat']['id'];
            $this->msgid      = (string) $this->input['message']['message_id'];
            $this->name          = $this->input['message']['from']['first_name'] . (isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : "");
            $this->first_name = $this->input['message']['from']['first_name'];
            $this->last_name  = isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : null;
            $this->userid      = $this->input['message']['from']['id'];
            $this->username   = isset($this->input['message']['from']['username']) ? $this->input['message']['from']['username'] : null;
            $this->time    = $this->input['message']['date'];
        }
    }

    /**
     * Response.
     */
    private function response()
    {
        if (in_array($this->msgType, ["text"])) {
            $res = new Response($this);
            $res();
        }
        $ch = new SaveEvent($this);
        $ch->save();
    }

    public function __get($var)
    {
        $wd = strtolower($var);
        return isset($this->{$wd}) ? $this->{$wd} : null;
    }
}
