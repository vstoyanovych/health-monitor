<?php

	include_once(dirname(dirname(dirname(__FILE__))) . '/libs/php-graph-sdk-5.x/src/Facebook/autoload.php');
	date_default_timezone_set('America/Los_Angeles');

	function fb_account_info($access_token)
		{
			$facebook = new Facebook\Facebook(Array(
				'app_id' => '8185102454907826',
				'app_secret' => '735a04d81cab8db537995da3f5018b22',
				'default_graph_version' => 'v2.4',
			));

			try
				{
					if ($response=$facebook->get('/me', $access_token))
						{
							$arr = $response->getDecodedBody();
							return Array(
								'id'=>$arr['id'],
								'name'=>$arr['name']
							);
						}
				}
			catch (Exception $e)
				{
					return false;
				}
			return false;
		}

	function is_fb_access_token_valid($access_token)
		{
			$facebook = new Facebook\Facebook(Array(
				'app_id' => '8185102454907826',
				'app_secret' => '735a04d81cab8db537995da3f5018b22',
				'default_graph_version' => 'v2.4',
			));

			try
				{
					if ($facebook->get('/me', $access_token))
						{
							return true;
						}
				}
			catch (Exception $e)
				{
					return false;
				}
			return true;
		}

	function fb_post_link($access_token, $url, $message, $picture = '', $title_link = '', $description_link = '', $caption_link = '', $destination_identifier='me')
		{
			global $pb;
			$pb['facebook']['last_post_error'] = '';

			$fb = new Facebook\Facebook(Array(
				'app_id' => '8185102454907826',
				'app_secret' => '735a04d81cab8db537995da3f5018b22',
				'default_graph_version' => 'v2.4',
			));


			if (!empty($url))
				{
					$linkData = Array(
						'link' => $url,
						'message' => $message
					);
				}
			else
				{
					$response = $fb->post('/me/photos', [
						'source' => $fb->fileToUpload($picture),
						'no_story' => true
					], $access_token);
					$photo = $response->getGraphNode()->asArray();

					$link = 'https://www.facebook.com/photo.php?fbid=' . $photo['id'];
					$linkData = Array(
						'link' => $link,
						'message' => $message
					);
				}

			// ==== temporary fix to comply to a policy of FB for Custom Link Page Post
			//   https://developers.facebook.com/docs/graph-api/reference/v2.11/page/feed#custom-image
			//if (!empty($picture))
			//	$linkData['picture'] = $picture;
			//if (!empty($caption_link))
			//	$linkData['caption'] = $caption_link;
			//if (!empty($description_link))
			//	$linkData['description'] = $description_link;
			//if (!empty($title_link))
			//	$linkData['name'] = $title_link;
			//====================================================

			try
				{
					$response = $fb->post('/'.$destination_identifier.'/feed', $linkData, $access_token);
				}
			catch (Facebook\Exceptions\FacebookResponseException $e)
				{
					$pb['facebook']['last_post_error'] = 'Failed to post: '.$e->getMessage();
				}
			catch (Facebook\Exceptions\FacebookSDKException $e)
				{
					$pb['facebook']['last_post_error'] = 'Error: '.$e->getMessage();
				}

			if (!empty($pb['facebook']['last_post_error']))
				return false;
			else
				{
					$graphNode = $response->getGraphNode();
					return $graphNode['id'];
				}
		}
	function fb_get_pages($access_token)
		{
			global $pb;
			$pb['facebook']['last_post_error'] = '';
			$r=Array();

			$fb = new Facebook\Facebook(Array(
				'app_id' => '8185102454907826',
				'app_secret' => '735a04d81cab8db537995da3f5018b22',
				'default_graph_version' => 'v2.4',
			));

			try
				{
					$res = $fb->get('/me/accounts', $access_token);
					$arr=$res->getDecodedBody();
					for ($i = 0; $i < count($arr['data']); $i++)
						{
							if (!is_array($arr['data'][$i]['tasks']))
								continue;
							if (!in_array('MANAGE', $arr['data'][$i]['tasks']) && !in_array('CREATE_CONTENT', $arr['data'][$i]['tasks']))
								continue;
							$r[]=Array(
								'name'=>$arr['data'][$i]['name'],
								'fbid'=>$arr['data'][$i]['id'],
								'access_token'=>$arr['data'][$i]['access_token']
							);
						}
				}
			catch (Facebook\Exceptions\FacebookResponseException $e)
				{
					$pb['facebook']['last_error'] = $e->getMessage();
				}
			catch (Facebook\Exceptions\FacebookSDKException $e)
				{
					$pb['facebook']['last_error'] = 'Error: '.$e->getMessage();
				}
			return $r;
		}
	function fb_friends_count($access_token)
		{
			global $pb;
			$pb['facebook']['last_post_error'] = '';

			$fb = new Facebook\Facebook(Array(
				'app_id' => '8185102454907826',
				'app_secret' => '735a04d81cab8db537995da3f5018b22',
				'default_graph_version' => 'v2.4',
			));

			try
				{
					// Returns a `Facebook\FacebookResponse` object
					$response = $fb->get('/me/friends', $access_token);
				}
			catch (Facebook\Exceptions\FacebookResponseException $e)
				{
					$pb['facebook']['last_post_error'] = 'Failed to post: '.$e->getMessage();
				}
			catch (Facebook\Exceptions\FacebookSDKException $e)
				{
					$pb['facebook']['last_post_error'] = 'Error: '.$e->getMessage();
				}

			if (!empty($pb['facebook']['last_post_error']))
				return false;
			else
				{
					$graphNode = $response->getDecodedBody();
					return floatval($graphNode['summary']['total_count']);
				}
		}
