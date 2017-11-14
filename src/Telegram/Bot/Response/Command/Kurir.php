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
class Kurir extends CommandFoundation
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

    public function check()
    {
    	$a = explode(" ", $this->b->lowertext, 2);
    	var_dump($a);
    	$ch = curl_init("http://api4.cekresi.co.id/allcnote.php");
		curl_setopt_array($ch, 
			[
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_REFERER => "http://www.resi.co.id/",
				CURLOPT_HTTPHEADER => [
					"Origin: http://www.resi.co.id",
					"Content-type: application/x-www-form-urlencoded"
				],
				CURLOPT_POSTFIELDS => "id=".trim($a[1])."&kurir={$a[0]}",
				CURLOPT_USERAGENT => "Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:56.0) Gecko/20100101 Firefox/56.0"
			]
		);
		$out = curl_exec($ch);
		curl_close($ch);
		var_dump($out);
    	$b = explode("<td width=\"130\">No Resi</td>", $out, 2);
		if (isset($b[1])) {
			$b = explode("</tr>", $b[1], 2);
			if (isset($b[1])) {
				$noresi = strip_tags($b[0]);
				$b = explode("<td>Status</td>", $a, 2);
				if (isset($b[1])) {
					$b = explode("<td><b>", $b[1], 2);
					if (isset($b[1])) {
						$b = explode("<", $b[1], 2);
						$status = $b[0];
						$b = explode("<td>Dikirim tanggal</td>", $a, 2);
						if (isset($b[1])) {
							$b = explode("</tr>", $b[1], 2);
							$b = explode("<td>", $b[0]);
							if (isset($b[2])) {
								$b = explode("</td>", $b[2], 2);
								$dikirim = $b[0];
								$b = explode("<td valign=\"top\">Dikirim oleh</td>", $a, 2);
								if (isset($b[1])) {
									$b = explode("</tr>", $b[1], 2);
									$b = explode("<td valign=\"top\">", $b[0]);
									if (isset($b[2])) {
										$dikirimoleh = trim(strip_tags(html_entity_decode($b[2], ENT_QUOTES, 'UTF-8')));
										$b = explode("<td valign=\"top\">Dikirim ke</td>", $a, 2);
										if (isset($b[1])) {
											$b = explode("</tr>", $b[1], 2);
											$b = explode("<td valign=\"top\">", $b[0]);
											if (isset($b[2])) {
												$b = explode("</td>", $b[2], 2);
												$dikirimke = trim(strip_tags(html_entity_decode($b[0], ENT_QUOTES, 'UTF-8')));
												$b = explode("<th width=\"40%\">Keterangan</th>", $a, 2);
												$b = explode("</tbody>", $b[1]);
												$b = explode("<tr>", $b[0]);
												unset($b[0]);
												$data = [];
												foreach ($b as $val) {
													$val = explode("\n", trim($val));
													$tgl = strip_tags(trim($val[0]));
													unset($val[0]);
													$text = [];
													foreach ($val as $val) {
														$val = trim(strip_tags(html_entity_decode($val, ENT_QUOTES, 'UTF-8')));
														empty($val) or $text[] = $val;
													}
													$text and $data[$tgl] = implode("\n", $text);
												}
												$b = explode("POD Detail</b></div>", $a, 2);
												$b = explode("<th width=\"40%\">Keterangan</th>", $b[1], 2);
												$b = explode("</tbody>", $b[1], 2);
												$b = explode("<tr>", $b[0]);
												unset($b[0]);
												$text = []; $pod = [];
												foreach ($b as $val) {
													$val = explode("\n", trim($val));
													$tgl = strip_tags(trim($val[0]));
													unset($val[0]);
													$text = [];
													foreach ($val as $val) {
														$val = trim(strip_tags(html_entity_decode($val, ENT_QUOTES, 'UTF-8')));
														empty($val) or $text[] = $val;
													}
													$text and $pod[$tgl] = implode("\n", $text);
												}
											}
										}
									}
								}
								$data = [
									"informasi_pengiriman" => [
										"no_resi" => $noresi,
										"status" => $status,
										"tanggal_pengiriman" => $dikirim,
										"dikirim_oleh" => $dikirimoleh,
										"dikirim_ke" => $dikirimke
									],
									"status_pengiriman" => [
										"outbond" => $data,
										"pod_detail" => $pod
									]
								];
							}
						}
					}
				}
			}
		}
		B::sendMessage(
			[
				"chat_id" => $this->b->chat_id,
				"text" => json_encode($data, 128)
			]
		);
    }
}
