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
		self::getInstance($lang)->saveBotInstance($bot);
		return true;
	}

	/**
	 * @param \Bot\Bot $bot
	 */
	public function saveBotInstance($bot)
	{
		$this->b = $bot;
	}

	/**
	 *
	 */
	public static function get($space)
	{

	}
}