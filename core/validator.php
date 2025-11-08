<?php

	class Validator
		{
			public static function verifyEmailSMTP($email)
				{
					if (!filter_var($email, FILTER_VALIDATE_EMAIL))
						return false;

					list(, $domain) = explode('@', $email);
					$my_domain = 'showbizzed.com';
					if (!getmxrr($domain, $mxRecords))
						return false;

					$mxHost = $mxRecords[0];
					$connection = fsockopen($mxHost, 25);
					if (!$connection)
						return false;

					$response = fgets($connection, 1024);
					fwrite($connection, "EHLO ".$my_domain." \r\n");

					$ehloResponse = '';
					while ($line = fgets($connection, 512)) {
						$ehloResponse .= $line;
						if (substr($line, 0, 4) === '250 ')
							break;
					}
//					echo "EHLO response: $ehloResponse\n";

					fwrite($connection, "MAIL FROM: <hello@".$my_domain.">\r\n");
					$response = fread($connection, 512);
//					echo "MAIL FROM response: $response\n";

					fwrite($connection, "RCPT TO: <$email>\r\n");
					$response = fread($connection, 512);
//					echo "RCPT TO response: $response\n";

					$result = false;
					if (strpos($response, '250') !== false)
						$result = true;
					elseif (strpos($response, '550') !== false)
						$result = false;
					fputs($connection, "QUIT\r\n");
					fclose($connection);
					return $result;
				}

			public static function isValidNameForModule(string $module): bool
				{
					if (empty($module) || strpos($module, ':') || strpos($module, '.') || strpos($module, '/') || strpos($module, '\\')) return false; else
						return true;
				}

		}
