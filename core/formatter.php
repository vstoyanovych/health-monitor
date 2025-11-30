<?php

	class Formatter
		{
			public static function CountryCodes() :array
				{
					return [
						"ad", "ae", "af", "ag", "ai", "al", "am", "ao", "aq", "ar", "arab", "as", "at",
						"au", "aw", "ax", "az", "ba", "bb", "bd", "be", "bf", "bg", "bh", "bi", "bj",
						"bl", "bm", "bn", "bo", "bq", "br", "bs", "bt", "bv", "bw", "by", "bz", "ca",
						"cc", "cd", "cefta", "cf", "cg", "ch", "ci", "ck", "cl", "cm", "cn", "co", "cp",
						"cr", "cu", "cv", "cw", "cx", "cy", "cz", "de", "dg", "dj", "dk", "dm", "do",
						"dz", "eac", "ec", "ee", "eg", "eh", "er", "es", "es-ct", "es-ga", "es-pv",
						"et", "eu", "fi", "fj", "fk", "fm", "fo", "fr", "ga", "gb", "gb-eng", "gb-nir",
						"gb-sct", "gb-wls", "gd", "ge", "gf", "gg", "gh", "gi", "gl", "gm", "gn", "gp",
						"gq", "gr", "gs", "gt", "gu", "gw", "gy", "hk", "hm", "hn", "hr", "ht", "hu",
						"ic", "id", "ie", "il", "im", "in", "io", "iq", "ir", "is", "it", "je", "jm",
						"jo", "jp", "ke", "kg", "kh", "ki", "km", "kn", "kp", "kr", "kw", "ky", "kz",
						"la", "lb", "lc", "li", "lk", "lr", "ls", "lt", "lu", "lv", "ly", "ma", "mc",
						"md", "me", "mf", "mg", "mh", "mk", "ml", "mm", "mn", "mo", "mp", "mq", "mr",
						"ms", "mt", "mu", "mv", "mw", "mx", "my", "mz", "na", "nc", "ne", "nf", "ng",
						"ni", "nl", "no", "np", "nr", "nu", "nz", "om", "pa", "pc", "pe", "pf", "pg",
						"ph", "pk", "pl", "pm", "pn", "pr", "ps", "pt", "pw", "py", "qa", "re", "ro",
						"rs", "ru", "rw", "sa", "sb", "sc", "sd", "se", "sg", "sh", "sh-ac", "sh-hl",
						"sh-ta", "si", "sj", "sk", "sl", "sm", "sn", "so", "sr", "ss", "st", "sv", "sx",
						"sy", "sz", "tc", "td", "tf", "tg", "th", "tj", "tk", "tl", "tm", "tn", "to",
						"tr", "tt", "tv", "tw", "tz", "ua", "ug", "um", "un", "us", "uy", "uz", "va",
						"vc", "ve", "vg", "vi", "vn", "vu", "wf", "ws", "xk", "xx", "ye", "yt", "za",
						"zm", "zw"
					];
				}
			public static function Money($float)
				{
					return number_format($float, 2, '.', '');
				}
			public static function MoneyFine($float)
				{
					return number_format($float, 2, '.', ',');
				}
			public static function FloatFine($float)
				{
					return number_format($float, 2, '.', ' ');
				}
			public static function IntFine($float)
				{
					return number_format($float, 0, '.', ',');
				}
			public static function Date($unixtimestamp)
				{
					global $lang;
					return strftime('%m/%d/%Y', $unixtimestamp);
				}
			public static function DateTime($unixtimestamp)
				{
					global $lang;
					return strftime('%b %d, %Y %I:%M %p', $unixtimestamp);
				}
			public static function Time($unixtimestamp)
				{
					global $lang;
					return strftime('%I:%M %p', $unixtimestamp);
				}
			public static function USPhone($phone)
				{
					$phone=Cleaner::USPhone($phone);
					if (strlen($phone)==11)
						$phone=substr($phone, 1);
					return '('.substr($phone, 0, 3).') '.substr($phone, 3, 3).'-'.substr($phone, 6);
				}
			public static function OrdinalNumber($number, $divider='')
				{
					$last=substr($number, -1);
					if (intval($last)==1)
						return $number.$divider.'st';
					elseif (intval($last)==2)
						return $number.$divider.'nd';
					elseif (intval($last)==3)
						return $number.$divider.'rd';
					else
						return $number.$divider.'th';
				}

			function convertUnixTimeToAge($unixTime) {
				$currentTime = time();
				$difference = $currentTime - $unixTime;

				$years = floor($difference / (365 * 24 * 60 * 60));
				$difference -= $years * 365 * 24 * 60 * 60;

				$days = floor($difference / (24 * 60 * 60));

				$result = '';

				if ($years > 0) {
					$result .= $years . ' year';
					if ($years > 1) {
						$result .= 's';
					}
				}

				if ($days > 0) {
					if ($years > 0) {
						$result .= ' ';
					}
					$result .= $days . ' day';
					if ($days > 1) {
						$result .= 's';
					}
				}

				if (empty($result)) {
					$result = '0 days';
				}

				return $result . ' old';
			}

			public static function FormatDateForTimezone($timestamp, $timezone = 'America/New_York')
				{
					$date = new DateTime("@$timestamp");
					$date->setTimezone(new DateTimeZone($timezone));
					return $date->format('M d Y');
				}

		}

