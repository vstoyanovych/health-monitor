<?php

	if (!defined("system_DEFINED"))
		{
			class System
				{

					public static function isGrabberEnabled(): bool
						{
							$grabber_on = getsqlfield("SELECT value_settings FROM en_settings WHERE name_settings = 'grabber_enabled' AND mode='default' LIMIT 1");

							return !empty($grabber_on);
						}

					public static function DissableGrabber()
						{
							execsql("UPDATE `en_settings` SET `value_settings` = '0' WHERE `name_settings` = 'grabber_enabled' LIMIT 1;");

							return !empty($grabber_on);
						}

					public static function EnaableGrabber()
						{
							execsql("UPDATE `en_settings` SET `value_settings` = '1' WHERE `name_settings` = 'grabber_enabled' LIMIT 1;");

							return !empty($grabber_on);
						}

					public static function GetIPAddress(): string
						{
							if (!empty($_SERVER['HTTP_CLIENT_IP']))
								$ip_address = $_SERVER['HTTP_CLIENT_IP'] ?? '';
							elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
								$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
							else
								$ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
							return $ip_address;
						}

					public static function CheckIPUsingIPHub($ip_address)
						{
							$api_key = 'MjAwOTU6bjdRSHZadE5PNE5QNEZlazNrU2drNFVjM0hjdE1sVGI=';

							$url = "https://v2.api.iphub.info/ip/".$ip_address;
							$headers = array(
								'Content-Type: application/json',
								"X-Key: ".$api_key
							);
							$curl = curl_init();
							curl_setopt($curl, CURLOPT_URL, $url);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
							$response = curl_exec($curl);
							curl_close($curl);
							$json = json_decode($response);

							if (!empty($json->isp))
								$message[] = 'ISP: '.$json->isp;

							$message[] = 'Country: '.$json->countryName;
							$message[] = 'Country Code: '.$json->countryCode;
							$message[] = 'Hostname: '.$json->hostname;
							$message[] = 'Block: '.$json->block;

							if (count($message) > 0)
								return implode("<br/>\n",$message);
							else
								return '';

						}

					public static function CheckIPQuality($ip_address): string
						{
							$api_key = 'gj0w7FeYqXdBs9tdbtQC39Z5mC4F1dAR';

							$url = 'https://www.ipqualityscore.com/api/json/ip/'.$api_key.'/'.$ip_address.'?full=1';

							$curl = curl_init($url);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
							$response = curl_exec($curl);
							curl_close($curl);

							$message = [];

							$data = json_decode($response, true);
							if ($data['success'])
								{
									if (!empty($data['ISP']))
										$message[] = 'ISP: '.$data['ISP'];

									if ($data['is_datacenter'])
										$message[] = 'Datacenter';
									if ($data['is_crawler'])
										$message[] = 'Crawler';
									if ($data['vpn'])
										$message[] = 'VPN';
									if ($data['proxy'])
										$message[] = 'Proxy';
									if ($data['bot_status'])
										$message[] = 'Bot';
									if ($data['tor'])
										$message[] = 'Tor';
									if ($data['recent_abuse'])
										$message[] = 'Recent Abuse';

									if (count($message) > 0)
										return implode("<br/>\n",$message);
									else
										return '';
								}
							else
								return 'Something went wrong';
						}

					public static function GetVisitorDevice(): string
						{
							$agent = $_SERVER['HTTP_USER_AGENT'];

							if (!empty($agent))
								{
//									if (preg_match('/(android|iphone|ipod|ipad)/i', $agent))
//										return 'mobile';
//									else
//										return 'desktop';
										return $agent;
								}

							return 'unknown';
						}

					public static function CurrentTime()
						{
							return time();
						}

					public static function RootDirectory(): string
						{
							return dirname(__FILE__, 2).'/';
						}

					public static function TwitterAccessToken()
						{
							return sm_get_settings('twitter_access_token');
						}

					public static function TwitterAccessTokenSecret()
						{
							return sm_get_settings('twitter_access_token_secret');
						}

					public static function TwitterConsumerKey()
						{
							return sm_get_settings('twitter_consumer_key');
						}

					public static function TwitterConsumerSecret()
						{
							return sm_get_settings('twitter_consumer_secret');
						}


					public static function SetTwitterAccessToken($val)
						{
							sm_set_settings('twitter_access_token', dbescape($val));
						}

					public static function SetTwitterAccessTokenSecret($val)
						{
							sm_set_settings('twitter_access_token_secret', dbescape($val));
						}

					public static function SetTwitterConsumerKey($val)
						{
							sm_set_settings('twitter_consumer_key', dbescape($val));
						}

					public static function SetTwitterConsumerSecret($val)
						{
							sm_set_settings('twitter_consumer_secret', dbescape($val));
						}

					public static function RedditClientId()
						{
							return sm_get_settings('reddit_client_id');
						}

					public static function RedditClientSecret()
						{
							return sm_get_settings('reddit_client_secret');
						}

					public static function SetRedditClientId($val)
						{
							if (!sm_has_settings('reddit_client_id'))
								sm_add_settings('reddit_client_id', '');

							sm_set_settings('reddit_client_id', dbescape($val));
						}

					public static function SetRedditClientSecret($val)
						{
							if (!sm_has_settings('reddit_client_secret'))
								sm_add_settings('reddit_client_secret', '');

							sm_set_settings('reddit_client_secret', dbescape($val));
						}

					public static function RedditUsername()
						{
							return sm_get_settings('reddit_username');
						}

					public static function RedditPassword()
						{
							return sm_get_settings('reddit_password');
						}

					public static function SetRedditUsername($val)
						{
							if (!sm_has_settings('reddit_username'))
								sm_add_settings('reddit_username', '');

							sm_set_settings('reddit_username', dbescape($val));
						}

					public static function SetRedditPassword($val)
						{
							if (!sm_has_settings('reddit_password'))
								sm_add_settings('reddit_password', '');

							sm_set_settings('reddit_password', dbescape($val));
						}

					public static function MailjetApiKey()
						{
							return sm_get_settings('mailjet_api_key');
						}

					public static function HasMailjetApiKey()
						{
							return !empty(sm_get_settings('mailjet_api_key'));
						}

					public static function SetMailjetApiKey($val)
						{
							if (!sm_has_settings('mailjet_api_key'))
								sm_add_settings('mailjet_api_key', '');

							sm_set_settings('mailjet_api_key', dbescape($val));
						}
					public static function MailjetApiSecret()
						{
							return sm_get_settings('mailjet_api_secret');
						}

					public static function HasMailjetApiSecret()
						{
							return !empty(sm_get_settings('mailjet_api_secret'));
						}

				public static function SetMailjetApiSecret($val)
					{
						if (!sm_has_settings('mailjet_api_secret'))
							sm_add_settings('mailjet_api_secret', '');

						sm_set_settings('mailjet_api_secret', dbescape($val));
					}

				// Google Ads API credentials
				public static function GoogleAdsClientId()
					{
						return sm_get_settings('google_ads_client_id');
					}

				public static function SetGoogleAdsClientId($val)
					{
						if (!sm_has_settings('google_ads_client_id'))
							sm_add_settings('google_ads_client_id', '');

						sm_set_settings('google_ads_client_id', dbescape($val));
					}

				public static function GoogleAdsClientSecret()
					{
						return sm_get_settings('google_ads_client_secret');
					}

				public static function SetGoogleAdsClientSecret($val)
					{
						if (!sm_has_settings('google_ads_client_secret'))
							sm_add_settings('google_ads_client_secret', '');

						sm_set_settings('google_ads_client_secret', dbescape($val));
					}

				public static function GoogleAdsRefreshToken()
					{
						return sm_get_settings('google_ads_refresh_token');
					}

				public static function SetGoogleAdsRefreshToken($val)
					{
						if (!sm_has_settings('google_ads_refresh_token'))
							sm_add_settings('google_ads_refresh_token', '');

						sm_set_settings('google_ads_refresh_token', dbescape($val));
					}

				public static function GoogleAdsAccountId()
					{
						return sm_get_settings('google_ads_account_id');
					}

				public static function SetGoogleAdsAccountId($val)
					{
						if (!sm_has_settings('google_ads_account_id'))
							sm_add_settings('google_ads_account_id', '');

						sm_set_settings('google_ads_account_id', dbescape($val));
					}

				public static function HasGoogleAdsCredentials()
					{
						return !empty(sm_get_settings('google_ads_client_id')) && 
						       !empty(sm_get_settings('google_ads_client_secret')) && 
						       !empty(sm_get_settings('google_ads_refresh_token')) &&
						       !empty(sm_get_settings('google_ads_account_id'));
					}

				public static function HasEmailDomainID()
						{
							return !empty(self::EmailDomainID());
						}

					public static function EmailDomainID()
						{
							return sm_get_settings('email_domain_id');
						}

					public static function SetEmailDomainID($val)
						{
							if (!sm_has_settings('email_domain_id'))
								sm_add_settings('email_domain_id', '');

							sm_update_settings('email_domain_id', dbescape($val));
						}

					public static function HasEmailDnsID()
						{
							return !empty(self::EmailDnsID());
						}

					public static function EmailDnsID()
						{
							return sm_get_settings('email_dns_id');
						}

					public static function SetEmailDnsID($val)
						{
							if (!sm_has_settings('email_dns_id'))
								sm_add_settings('email_dns_id', '');

							sm_update_settings('email_dns_id', dbescape($val));
						}

					public static function HasEmailOwnerShipToken()
						{
							return !empty(self::EmailOwnerShipToken());
						}

					public static function EmailOwnerShipToken()
						{
							return sm_get_settings('email_ownership_token');
						}

					public static function SetEmailOwnerShipToken($val)
						{
							if (!sm_has_settings('email_ownership_token'))
								sm_add_settings('email_ownership_token', '');

							sm_update_settings('email_ownership_token', dbescape($val));
						}

					public static function HasEmailOwnerShipTokenRecordName()
						{
							return !empty(self::EmailOwnerShipTokenRecordName());
						}

					public static function EmailOwnerShipTokenRecordName()
						{
							return sm_get_settings('email_ownership_token_record_name');
						}

					public static function SetEmailOwnerShipTokenRecordName($val)
						{
							if (!sm_has_settings('email_ownership_token_record_name'))
								sm_add_settings('email_ownership_token_record_name', '');

							sm_update_settings('email_ownership_token_record_name', dbescape($val));
						}

					public static function EmailSPFRecordValue()
						{
							return sm_get_settings('email_sprf_record_value');
						}

					public static function SetEmailSPFRecordValue($val)
						{
							if (!sm_has_settings('email_sprf_record_value'))
								sm_add_settings('email_sprf_record_value', '');

							sm_update_settings('email_sprf_record_value', dbescape($val));
						}

					public static function EmailDKIMRecordName()
						{
							return sm_get_settings('email_dkim_record_name');
						}

					public static function SetEmailDKIMRecordName($val)
						{
							if (!sm_has_settings('email_dkim_record_name'))
								sm_add_settings('email_dkim_record_name', '');

							sm_update_settings('email_dkim_record_name', dbescape($val));
						}

					public static function EmailDKIMRecordValue()
						{
							return sm_get_settings('email_dkim_record_value');
						}

					public static function SetEmailDKIMRecordValue($val)
						{
							if (!sm_has_settings('email_dkim_record_value'))
								sm_add_settings('email_dkim_record_value', '');

							sm_update_settings('email_dkim_record_value', dbescape($val));
						}

					public static function EmailSPFRecordStatus()
						{
							return sm_get_settings('email_sprf_record_status');
						}

					public static function SetEmailSPFRecordStatus($val)
						{
							if (!sm_has_settings('email_sprf_record_status'))
								sm_add_settings('email_sprf_record_status', '');

							sm_update_settings('email_sprf_record_status', dbescape($val));
						}

					public static function EmailDKIMRecordStatus()
						{
							return sm_get_settings('email_dkim_record_status');
						}

					public static function SetEmailDKIMRecordStatus($val)
						{
							if (!sm_has_settings('email_dkim_record_status'))
								sm_add_settings('email_dkim_record_status', '');

							sm_update_settings('email_dkim_record_status', dbescape($val));
						}

					public static function SetEmailStatus($val)
						{
							if (!sm_has_settings('email_status'))
								sm_add_settings('email_status', '');

							sm_update_settings('email_status', dbescape($val));
						}

					public static function HasEmailStatus()
						{
							return !empty(self::EmailStatus());
						}

					public static function EmailStatus()
						{
							return sm_get_settings('email_status');
						}

					public static function isEmailActive()
						{
							return self::EmailStatus() == 'Active';
						}

					public static function HasEmailDomain()
						{
							return !empty(self::EmailDomain());
						}

					public static function EmailDomain()
						{
							return sm_get_settings('email_domain');
						}

					public static function SetEmailDomain($val)
						{
							if (!sm_has_settings('email_domain'))
								sm_add_settings('email_domain', '');

							sm_update_settings('email_domain', dbescape($val));
						}

					public static function HasEmailFrom()
						{
							return !empty(self::EmailFrom());
						}

					public static function EmailFrom()
						{
							return sm_get_settings('email');
						}

					public static function SetEmailFrom($val)
						{
							if (!sm_has_settings('email'))
								sm_add_settings('email', '');

							sm_update_settings('email', dbescape($val));
						}

					public static function SetEmailParseRouteID($val)
						{
							if (!sm_has_settings('email_parse_route_id'))
								sm_add_settings('email_parse_route_id', '');

							sm_update_settings('email_parse_route_id', dbescape($val));
						}

					public static function HasEmailParseRouteID()
						{
							return !empty(self::EmailParseRouteID());
						}
					public static function EmailParseRouteID()
						{
							return sm_get_settings('email_parse_route_id');
						}

					public static function SetEmailParseRouteURL($val)
						{
							if (!sm_has_settings('email_parse_route_url'))
								sm_add_settings('email_parse_route_url', '');

							sm_update_settings('email_parse_route_url', dbescape($val));
						}

					public static function HasEmailParseRouteURL()
						{
							return !empty(self::EmailParseRouteURL());
						}
					public static function EmailParseRouteURL()
						{
							return sm_get_settings('email_parse_route_url');
						}

					public static function HasSystemLogoImageURL()
						{
							return file_exists(Path::Root().'files/img/systemlogo.jpg');
						}

					public static function SystemLogoImageURL()
						{
							return 'https://'.FrontEndDomain().'/files/img/systemlogo.jpg';
						}

					public static function UnsetSystemLogoImage()
						{
							$fd=Path::Root().'/files/img/systemlogo.jpg';
							if (!file_exists($fd))
								return false;
							if (file_exists($fd))
								unlink($fd);
							return true;
						}

					public static function SetSystemLogoImage($filename, $erase_source_after_copying=true)
						{
							if (!file_exists($filename))
								return false;
							$fd=Path::Root().'/files/img/systemlogo.jpg';
							if (file_exists($fd))
								unlink($fd);
							copy($filename, $fd);
							if ($erase_source_after_copying)
								unlink($filename);
							return true;
						}

					public static function GoogleSearchCXForAmazon()
						{
							return sm_get_settings('google_amazon_search_cx');
						}

					public static function GoogleSearchAPIKeyForAmazon()
						{
							return sm_get_settings('google_amazon_search_api_key');
						}

				}

			define("system_DEFINED", 1);
		}
