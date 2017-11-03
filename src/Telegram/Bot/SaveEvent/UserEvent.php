<?php

namespace Telegram\Bot\SaveEvent;

use DB;
use PDO;
use Telegram\Lang;
use Telegram\Bot\Bot;
use Telegram as B;
use Telegram\Bot\Abstraction\EventFoundation;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class UserEvent extends EventFoundation
{
    

    /**
     * @var \Bot\Bot
     */
    private $b;

    /**
     * @var array
     */
    private $oldIdentity = [];

    /**
     * Constructor.
     *
     * @param \Bot\Bot $bot
     */
    public function __construct(Bot $bot)
    {
        $this->b = $bot;
    }

    /**
     * Track event.
     */
    private function trackEvent()
    {
        $st = DB::prepare("SELECT `username`,`name`,`photo` FROM `a_users` WHERE `user_id`=:user_id LIMIT 1;");
        pc($st->execute([":user_id" => $this->b->user_id]), $st);
        $st = $st->fetch(PDO::FETCH_ASSOC);
        if (! $st) {
            return false;
        }
        if ($st['username'] !== $this->b->username 
            || $st['name']     !== $this->b->name
        ) {
            $this->oldIdentity = $st;
            return "update";
        }
        return "known";
    }

    /**
     * Update user info.
     */
    private function updateUserInfo()
    {
        $add = $this->b->chattype === "private" ? "`private_msg_count`=`private_msg_count`+1" : "`group_msg_count`=`group_msg_count`+1";
        $st = DB::prepare("UPDATE `a_users` SET `username`=:username, `name`=:name, `photo` = NULL, `updated_at`=:updated_at, {$add} WHERE `user_id`=:user_id LIMIT 1;");
        pc(
            $st->execute(
                [
                ":username"     => $this->b->username,
                ":name"            => $this->b->name,
                ":updated_at"    => date("Y-m-d H:i:s"),
                ":user_id"         => $this->b->user_id
                ]
            ), $st
        );
        $this->b->chattype !== "private" and $this->notify();
        $this->writeUserHistory();
        return true;
    }

    private function notify()
    {
        $st = DB::prepare("SELECT `history_notification` FROM `groups_setting` WHERE `group_id`=:group_id LIMIT 1;");
        pc($st->execute([":group_id" => $this->b->chat_id]), $st);
        if ($st = $st->fetch(PDO::FETCH_NUM)) {
            if ($st[0] === 'true') {
                if ($this->b->name !== $this->oldIdentity['name']) {
                    $msg = Lang::bind(
                        "<a href=\"tg://user?id=".$this->b->user_id."\">".htmlspecialchars($this->oldIdentity['name'])."</a> changes name to {namelink}"
                    );
                    B::sendMessage(
                        [
                        "text" => $msg,
                        "chat_id" => $this->b->chat_id,
                        "parse_mode" => "HTML"
                        ]
                    );
                }
                if ($this->b->username != $this->oldIdentity['username']) {
                    if (empty($this->oldIdentity['username'])) {
                        $msg = Lang::bind("{namelink} create new username @".$this->b->username);
                    } elseif(empty($this->b->username)) {
                        $msg = Lang::bind("{namelink} removed username");
                    } else {
                        $msg = Lang::bind("{namelink} changes username from @".$this->oldIdentity['username']." to @{username}");
                    }
                    B::sendMessage(
                        [
                        "text" =>  $msg,
                        "chat_id" => $this->b->chat_id,
                        "parse_mode" => "HTML"
                        ]
                    );
                }
            }
        }
    }

    /**
     * Increase message count.
     */
    private function increaseMessageCount()
    {
        $add = $this->b->chattype === "private" ? "`private_msg_count`=`private_msg_count`+1" : "`group_msg_count`=`group_msg_count`+1";
        $st = DB::prepare("UPDATE `a_users` SET `updated_at`=:updated_at, {$add} WHERE `user_id`=:user_id LIMIT 1;");
        pc(
            $st->execute(
                [
                ":user_id"         => $this->b->user_id,
                ":updated_at"    => date("Y-m-d H:i:s")
                ]
            ), $st
        );
        return true;
    }

    /**
     * Save new user.
     */
    private function saveNewUser()
    {
        $pr = $this->b->chattype === "private" ? 1 : 0;
        $gr = $pr ? 0 : 1;
        $st = DB::prepare("INSERT INTO `a_users` (`user_id`, `username`, `name`, `photo`, `private_msg_count`, `group_msg_count`, `created_at`, `updated_at`) VALUES (:user_id, :username, :name, NULL, {$pr}, {$gr}, :created_at, NULL);");
        pc(
            $st->execute(
                [
                ":user_id"         => $this->b->user_id,
                ":username"        => $this->b->username,
                ":name"            => $this->b->name,
                ":created_at"    => date("Y-m-d H:i:s")
                ]
            ), $st
        );
        $this->writeUserHistory();
        return true;
    }

    /**
     * Write user history.
     */
    private function writeUserHistory()
    {
        $st = DB::prepare("INSERT INTO `users_history` (`user_id`, `username`, `name`, `photo`, `created_at`) VALUES (:user_id, :username, :name, NULL, :created_at)");
        pc(
            $st->execute(
                [
                ":user_id"         => $this->b->user_id,
                ":username"     => $this->b->username,
                ":name"            => $this->b->name,
                ":created_at"    => date("Y-m-d H:i:s")
                ]
            ), $st
        );
        return true;
    }

    /**
     * Run user event.
     */
    public function run()
    {
        $track = $this->trackEvent();
        if ($track === "update") {
            $this->updateUserInfo();
        } elseif ($track === "known") {
            $this->increaseMessageCount();
        } else {
            $this->saveNewUser();
        }
        return $this->b->chattype !== "private";
    }
}