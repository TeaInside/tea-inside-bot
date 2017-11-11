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
                $rep.="Hasil pencarian anime :\n<b>{$st['entry']['id']}</b> : {$st['entry']['title']}\n\nBerikut ini adalah anime yang cocok dengan <b>{$query}</b>.\n\nKetik /idan [spasi] [id_anime] atau balas dengan id anime untuk menampilkan info anime lebih lengkap.";
            } elseif (is_array($st) and $xz = count($st['entry'])) {
                $rep = "Hasil pencarian anime :\n";
                foreach ($st['entry'] as $vz) {
                    $rep .= "<b>".$vz['id']."</b> : ".$vz['title']."\n";
                }
                $rep.="\nBerikut ini adalah beberapa anime yang cocok dengan <b>{$query}</b>.\n\nKetik /idan [spasi] [id_anime] atau balas dengan id anime untuk menampilkan info anime lebih lengkap.";
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
                    "text" => "Anime apa yang ingin kamu cari?",
                    "reply_markup"=>(json_encode(["force_reply"=>true,"selective"=>true])),
                    "reply_to_message_id" => $this->b->msgid
                ]
            );
        }
    }
}
