<?php

	namespace SM\Core;

	use SM\SM;

	class UserDataMaintainer
		{

			public static function Init()
				{
					global $userinfo, $_sessionvars;
					$userinfo['sid'] = session_id();

					if (empty($_sessionvars['userinfo_id']))
						{
							$userinfo = [
								'id' => 0,
								'login' => '',
								'email' => '',
								'level' => 0,
								'session' => '',
								'groups' => [],
								'info' => [],
							];
						}
					else
						{
							$userinfo['id'] = $_sessionvars['userinfo_id'];
							$userinfo['login'] = $_sessionvars['userinfo_login'];
							$userinfo['email'] = $_sessionvars['userinfo_email'];
							$userinfo['level'] = $_sessionvars['userinfo_level'];
							$userinfo['session'] = $userinfo['sid'];
							$userinfo['groups'] = $_sessionvars['userinfo_groups'];
							$userinfo['info'] = unserialize($_sessionvars['userinfo_allinfo']);
						}

					if (intval($userinfo['id']) == 1)
						{
							$userinfo['level'] = 3;
						}
					SM::initLoggedUser($userinfo);
				}

		}
