<?php

use Bot\Bot;
use System\Hub\Singleton;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class Lang
{
	use Singleton;

	/**
	 * @var string
	 */
	private $lang;

	/**
	 * @var \Bot\Bot
	 */
	private $b;

	/**
	 * @var array
	 */
	private $r1 = [];

	/**
	 * @var array
	 */
	private $r2 = [];

	/**
	 * Constructor.
	 *
	 * @param string $lang
	 */
	public function __construct($lang)
	{
		$this->lang = $lang;
	}

	/**
	 * @param string $lang
	 * @return bool
	 */
	public static function init(Bot $bot, $lang = "ID")
	{
		$ins = self::getInstance($lang);
		$ins->saveBotInstance($bot);
		return true;
	}

	private function buildContext()
	{
		$this->r1 = [
			"{name}",
			"{namelink}",			
			"{username}",
			"{chattile}",
			"{chat_id}",
			"{first_name}",
			"{last_name}",
			"{short_namelink}"
		];
		$this->r2 = [
			$this->b->name,
			"<a href=\"tg://user?id=".$this->b->user_id."\">".htmlspecialchars($this->b->name)."</a>",
			(isset($this->b->username) ? "@".$this->b->username : ""),
			$this->b->chattile,
			$this->b->chat_id,
			$this->b->first_name,
			$this->b->last_name,
			"<a href=\"tg://user?id=".$this->b->user_id."\">".htmlspecialchars($this->b->first_name)."</a>",
		];
	}

	/**
	 * @param \Bot\Bot $bot
	 */
	public function saveBotInstance($bot)
	{
		$this->b = $bot;
	}

	/**
	 * @param string $what
	 */
	public static function get($what)
	{

	}

	/**
	 * @param string $str
	 */
	public static function bind($str)
	{
		$ins = self::getInstance();
		if (! $ins->r1) {
			$this->buildContext();
		}
		return str_replace($ins->r1, $ins->r2, $str);
	}
}