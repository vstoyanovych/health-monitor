<?php

	use NUWM\Login\GoogleLogin;
	use SM\Common\Redirect;
	use SM\SM;

	require_once 'googlelogin.php';

	$clientID = sm_settings('google_client_id');
	$clientSecret = sm_settings('google_client_secret');
	$redirectUri = 'https://'.Domain().'/index.php?m=googlelogin&d=receivetoken';

	sm_default_action('login');

	if ( sm_action('login') )
		{
			$googleLogin = new GoogleLogin($clientID, $clientSecret, $redirectUri);
			$loginUrl = $googleLogin->getLoginUrl();

			if (!empty($loginUrl))
				Redirect::Now($loginUrl);
		}

	if ( sm_action('receivetoken') )
		{
			if (!SM::GET('code')->isEmpty())
				{
					$googleLogin = new GoogleLogin($clientID, $clientSecret, $redirectUri);
					$token = $googleLogin->authenticate(SM::GET('code')->AsString());

					if (!empty($token['access_token']))
						{
							$userInfo = $googleLogin->getUserInfo($token['access_token']);

							if (!empty($userInfo['email']))
								{
									$user = TEmployee::initWithEmail($userInfo['email']);
									if (is_object($user) && $user->Exists())
										{
											sm_login($user->ID());
											Redirect::Now('index.php?m=dashboard');
										}
									else
										Redirect::Now('https://'.Domain().'/');
								}
						}

					header('Location: ' . filter_var($redirectUri, FILTER_SANITIZE_URL));
					exit();
				}
		}