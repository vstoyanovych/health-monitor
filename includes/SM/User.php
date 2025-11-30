<?php

	namespace SM;

	class User
		{
			protected $userinfo=NULL;

			function __construct($id_or_cacheddata)
				{
					if (is_array($id_or_cacheddata))
						$this->userinfo=$id_or_cacheddata;
					else
						$this->userinfo=sm_userinfo(intval($id_or_cacheddata));
				}

			function Exists()
				{
					return !empty($this->userinfo['id']);
				}

			function ID()
				{
					return intval(sm_get_array_value($this->userinfo, 'id'));
				}

			function Level()
				{
					return intval(sm_get_array_value($this->userinfo, 'level'));
				}

			function Login()
				{
					return sm_get_array_value($this->userinfo, 'login');
				}

			function RandomCode()
				{
					return sm_get_array_value($this->userinfo['info'], 'random_code');
				}

			function isAdministrator()
				{
					if ($this->ID()==1)
						return true;
					else
						return $this->Level()==3;
				}

		}