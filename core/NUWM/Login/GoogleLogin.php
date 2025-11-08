<?php

	namespace NUWM\Login;

	class GoogleLogin {
		private $clientID;
		private $clientSecret;
		private $redirectUri;

		public function __construct($clientID, $clientSecret, $redirectUri) {
			$this->clientID = $clientID;
			$this->clientSecret = $clientSecret;
			$this->redirectUri = $redirectUri;
		}

		public function getLoginUrl() {
			$params = [
				'client_id' => $this->clientID,
				'redirect_uri' => $this->redirectUri,
				'response_type' => 'code',
				'scope' => 'email profile',
				'access_type' => 'offline'
			];
			return 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($params);
		}

		public function authenticate($code) {
			$params = [
				'code' => $code,
				'client_id' => $this->clientID,
				'client_secret' => $this->clientSecret,
				'redirect_uri' => $this->redirectUri,
				'grant_type' => 'authorization_code'
			];

			$url = 'https://oauth2.googleapis.com/token';

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);

			$token = json_decode($response, true);
			return $token;
		}

		public function getUserInfo($accessToken) {
			$url = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token=' . $accessToken;

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);

			$userInfo = json_decode($response, true);
			return $userInfo;
		}

		public function getUserDataFromToken($token) {
			if (isset($token['access_token'])) {
				return $this->getUserInfo($token['access_token']);
			}
			return null;
		}
	}