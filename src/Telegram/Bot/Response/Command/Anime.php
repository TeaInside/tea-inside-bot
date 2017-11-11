<?php

namespace Telegram\Bot\Response\Command;

use DB;
use PDO;
use Telegram as B;
use Telegram\Lang;
use Telegram\Bot\Bot;
use Plugins\MyAnimeList\MyAnimeList;
use Telegram\Bot\Abstraction\CommandFoundation;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Anime extends CommandFoundation
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

    public function animeSearch()
    {
    	$query = explode(" ", $this->b->lowertext, 2);
    	$query = isset($query[1]) ? trim($query[1]) : "";
    	if (!empty($query)) {
            $st = new MyAnimeList(MAL_USER, MAL_PASS);
            $st->search($query);
            $st->exec();
            $st = $st->get_result();
            if (isset($st['entry']['id'])) {
                $rep = "";
                $rep.="Hasil pencarian anime :\n<b>{$st['entry']['id']}</b> : {$st['entry']['title']}\n\nBerikut ini adalah anime yang cocok dengan <b>{$query}</b>.\n\nKetik /idan [spasi] [id_anime].";
            } elseif (is_array($st) and $xz = count($st['entry'])) {
                $rep = "Hasil pencarian anime :\n";
                foreach ($st['entry'] as $vz) {
                    $rep .= "<b>".$vz['id']."</b> : ".$vz['title']."\n";
                }
                $rep.="\nBerikut ini adalah beberapa anime yang cocok dengan <b>{$query}</b>.\n\nKetik /idan [spasi] [id_anime].";
            } else {
                $rep = "Mohon maaf, anime \"{$query}\" tidak ditemukan !";
                $noforce = true;
            }
            return B::sendMessage(
                [
                "chat_id" => $this->b->chat_id,
                "text" => $rep,
                "parse_mode" => "HTML",
                "disable_web_page_preview" => true,
                "reply_markup" => (isset($noforce) ? null : json_encode(["force_reply"=>true,"selective"=>true]))
                ]
            );
        } else {
            return B::sendMessage(
                [
                    "chat_id" => $this->b->chat_id,
                    "text" => "Anime apa yang kamu cari?",
                    "reply_markup"=>(json_encode(["force_reply"=>true,"selective"=>true])),
                    "reply_to_message_id" => $this->b->msgid
                ]
            );
        }
    }

    public function animeInfo()
    {
    	$id = explode(" ", $this->b->lowertext, 2);
    	$id = isset($id[1]) ? trim($id[1]) : "";
    	if (!empty($id)) {
            $fx = function ($str) {
                if (is_array($str)) {
                    return trim(str_replace(array("[i]", "[/i]","<br />"), array("<i>", "</i>","\n"), html_entity_decode(implode($str))));
                }
                return trim(str_replace(array("[i]", "[/i]","<br />"), array("<i>", "</i>","\n"), html_entity_decode($str, ENT_QUOTES, 'UTF-8')));
            };
            $st = new MyAnimeList(MAL_USER, MAL_PASS);
            $st = $st->get_info($id);
            $st = isset($st['entry']) ? $st['entry'] : $st;
            if (is_array($st) and count($st)) {
                $img = $st['image'];
                unset($st['image']);
                $rep = "";
                foreach ($st as $key => $value) {
                    $ve = $fx($value);
                    !empty($ve) and $rep .= "<b>".ucwords($key)."</b> : ".($ve)."\n";
                }
                $rep = str_replace("\n\n", "\n", $rep);
            } else {
                $rep = "Mohon maaf, anime dengan id \"{$id}\" tidak ditemukan !";
            }
            isset($img) and B::sendPhoto(
                [
                    "chat_id" => $this->b->chat_id,
                    "photo" => $img,
                    "reply_to_message_id" => $this->b->msgid
                ]
            );
            return B::sendMessage(
                [
                    "chat_id" => $this->b->chat_id,
                    "text" => $rep,
                    "reply_to_message_id" => $this->b->msgid,
                    "parse_mode" => "HTML"
                ]
            );
        } else {
            return B::sendMessage(
                [
                    "chat_id" => $this->b->chat_id,
                    "text" => "Sebutkan ID Anime!",
                    "reply_markup" => json_encode(["force_reply"=>true,"selective"=>true]),
                    "reply_to_message_id" => $this->b->msgid
                ]
            );
        }
    }

    public function mangaSearch()
    {
    	$query = explode(" ", $this->b->lowertext, 2);
    	$query = isset($query[1]) ? trim($query[1]) : "";
    	if (!empty($query)) {
            $st = new MyAnimeList(MAL_USER, MAL_PASS);
            $st->search($query, "manga");
            $st->exec();
            $st = $st->get_result();
            if (isset($st['entry']['id'])) {
                $rep = "";
                $rep.="Hasil pencarian manga :\n<b>{$st['entry']['id']}</b> : {$st['entry']['title']}\n\nBerikut ini adalah manga yang cocok dengan <b>{$query}</b>.\n\nKetik /idma [spasi] [id_anime].";
            } elseif (is_array($st) and $xz = count($st['entry'])) {
                $rep = "Hasil pencarian manga :\n";
                foreach ($st['entry'] as $vz) {
                    $rep .= "<b>".$vz['id']."</b> : ".$vz['title']."\n";
                }
                $rep.="\nBerikut ini adalah beberapa manga yang cocok dengan <b>{$query}</b>.\n\nKetik /idma [spasi] [id_manga].";
            } else {
                $rep = "Mohon maaf, anime \"{$query}\" tidak ditemukan !";
            }
            return B::sendMessage(
                [
                    "chat_id" => $this->b->chat_id,
                    "text" => $rep,
                    "parse_mode" => "HTML",
                    "disable_web_page_preview" => true,
                    "reply_markup" => (isset($noforce) ? null : json_encode(["force_reply"=>true,"selective"=>true]))
                ]
            );
        } else {
            return B::sendMessage(
                [
                    "text" => "Manga apa yang kamu cari?",
                    "chat_id" => $this->b->chat_id,
                    "reply_markup"=>(json_encode(["force_reply"=>true,"selective"=>true])),
                    "reply_to_message_id" => $this->b->msgid
                ]
            );
        }
    }

    public function mangaInfo()
    {
    	$id = explode(" ", $this->b->lowertext, 2);
    	$id = isset($id[1]) ? trim($id[1]) : "";
    	 if (!empty($id)) {
            $fx = function ($str) {
                if (is_array($str)) {
                    return trim(str_replace(array("[i]", "[/i]","<br />"), array("<i>", "</i>","\n"), html_entity_decode(implode($str))));
                }
                return trim(str_replace(array("[i]", "[/i]","<br />"), array("<i>", "</i>","\n"), html_entity_decode($str, ENT_QUOTES, 'UTF-8')));
            };
            $st = new MyAnimeList(MAL_USER, MAL_PASS);
            $st = $st->get_info($id, "manga");
            $st = isset($st['entry']) ? $st['entry'] : $st;
            if (is_array($st) and count($st)) {
                $img = $st['image'];
                unset($st['image']);
                $rep = "";
                foreach ($st as $key => $value) {
                    $ve = $fx($value);
                    !empty($ve) and $rep .= "<b>".ucwords($key)."</b> : ".($ve)."\n";
                }
                isset($img) and B::sendPhoto(
                    [
                    "chat_id" => $this->b->chat_id,
                    "photo" => $img,
                    "reply_to_message_id" => $this->b->msgid
                    ]
                );
                return B::sendMessage(
                    [
                    "chat_id" => $this->b->chat_id,
                    "text" => $rep,
                    "reply_to_message_id" => $this->b->msgid,
                    "parse_mode" => "HTML"
                    ]
                );
            } else {
                B::sendMessage(
                    [
                        "text" => "Mohon maaf, manga \"{$id}\" tidak ditemukan !",
                        "chat_id" => $this->b->chat_id
                    ]
                );
            }
        } else {
            B::sendMessage(
                [
                    "text" => "Sebutkan ID Manga!",
                    "chat_id" => $this->b->chat_id,
                    "reply_markup" => json_encode(["force_reply"=>true,"selective"=>true]),
                    "reply_to_message_id" => $this->b->msgid
                ]
            );
        }
    }
}
