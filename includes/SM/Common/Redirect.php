<?php

	namespace SM\Common;

	use SM\SM;

	class Redirect
		{
			public static function To($url)
				{
					sm_redirect($url);
				}

			public static function Now($url)
				{
					sm_redirect_now($url);
				}

			public static function ReturnToNow($params_to_modify=[])
				{
					if (!SM::GET('returnto')->isEmpty())
						{
							$url=SM::GET('returnto')->AsString();
							if (!empty($params_to_modify))
								{
									$url=sm_url($url, $params_to_modify);
								}
							self::Now($url);
						}
					else
						{
							self::Now(sm_homepage());
						}
				}

			public static function NowReturnToOr($alternative_url_if_no_returnto)
				{
					global $sm;
					if (!empty(SM::GET('returnto')->AsString()))
						self::Now($sm['g']['returnto']);
					else
						self::Now($alternative_url_if_no_returnto);
				}
		}
