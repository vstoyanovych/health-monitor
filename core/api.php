<?php

	use SM\SM;

	function monitor_class_loader($classname)
		{
			if (strcmp(substr($classname, 0, 5), 'NUWM\\')===0)
				include_once(dirname(__FILE__).'/'.str_replace('\\', '/', $classname).'.php');
			else
				{
					$filename=dirname(__FILE__).'/'.strtolower($classname).'.php';
					if (file_exists($filename))
						include_once($filename);
				}
		}

	function Domain()
		{
			$fe_domain = getsqlfield("SELECT value_settings FROM mgmt_settings WHERE name_settings = 'resource_url' AND mode='default' LIMIT 1");
			if(substr($fe_domain, -1) == '/')
				{
					$fe_domain = substr($fe_domain, 0, -1);
				}
			return $fe_domain;
		}

	function detect_website($resource_url)
		{
			$resource_url = strtolower($resource_url);
			$resource_url = str_replace( 'www.', '', $resource_url );
			$parsed = parse_url($resource_url);
			return $parsed['host'];
		}

	function url_validator($url)
		{
			$redirectionlink = strtolower($url);
			$redirectionlink = str_replace( 'http://', '', $redirectionlink );
			$redirectionlink = str_replace( 'https://', '', $redirectionlink );
			if(strpos($redirectionlink, '/'))
				$redirectionlink = substr($redirectionlink, 0, strpos($redirectionlink, '/'));

			$pattern = '/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,30}$/i';
			if (!preg_match($pattern, $redirectionlink))
				{
					$error_message = $url. ' is not a valid URL';
				}
			return $error_message;
		}

	function url_cleaner($url)
		{
			$redirectionlink = strtolower($url);
			$redirectionlink = str_replace( 'http://', '', $redirectionlink );
			$redirectionlink = str_replace( 'https://', '', $redirectionlink );


			return $redirectionlink;
		}

	function getVisIpAddr()
		{
			if (!empty($_SERVER['HTTP_CLIENT_IP']))
				return $_SERVER['HTTP_CLIENT_IP'];
			else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			else
				return $_SERVER['REMOTE_ADDR'];
		}

	function contains_url($string) {
		$url_pattern = '/\b((http[s]?:\/\/)|(www\.))[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/';
		return preg_match($url_pattern, $string);
	}

	spl_autoload_register('monitor_class_loader');
