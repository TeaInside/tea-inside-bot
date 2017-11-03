<?php

namespace Telegram\Lang;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class LanguagesMap
{
	public static $map = [
		"ID" => "Telegram\\Lang\\ID",
		"EN" => "Telegram\\Lang\\EN"
	];

	public static function languageExists($lang)
	{
		return isset(self::$map[$lang]);
	}
}