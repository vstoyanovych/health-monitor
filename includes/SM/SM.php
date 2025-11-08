<?php

	namespace SM;

	use SM\Common\Input\RequestParam;
	use SM\Common\Input\RequestManager;
	use SM\Common\MessageCollector;

	class SM
		{
			protected static $userinfo=NULL;
			protected static $user=NULL;
			protected static $top_navigation=NULL;
			protected static $bottom_navigation=NULL;
			protected static $errors;

			static function isLoggedIn()
				{
					if (SM::$userinfo===NULL)
						return false;
					elseif (empty(SM::$userinfo['id']))
						return false;
					else
						return true;
				}

			static function isAdministrator()
				{
					if (!SM::isLoggedIn())
						return false;
					elseif (SM::$userinfo['id']==1)
						return true;
					else
						return SM::$userinfo['level']==3;
				}

		/**
		 * @return User
		 */
			static function User()
				{
					if (!SM::isLoggedIn())
						return new User([]);
					else
						return SM::$user;
				}

			static function initLoggedUser(&$userinfo)
				{
					SM::$userinfo=&$userinfo;
					SM::$user=new User($userinfo);
				}

		/**
		 * @return \SMNavigation
		 */
			static function TopNavigation()
				{
					global $sm;
					if (SM::$top_navigation===NULL)
						SM::$top_navigation=new \SMNavigation($sm['s']['uppermenu']);
					return SM::$top_navigation;
				}
		/**
		 * @return \SMNavigation
		 */
			static function BottomNavigation()
				{
					global $sm;
					if (SM::$bottom_navigation===NULL)
						SM::$bottom_navigation=new \SMNavigation($sm['s']['bottommenu']);
					return SM::$bottom_navigation;
				}

		/**
		 * @param string $param_name
		 * @return RequestParam
		 */
			static function POST($param_name)
				{
					global $sm;
					return new RequestParam($sm['p'], $param_name);
				}

		/**
		 * @param string $param_name
		 * @return RequestParam
		 */
			static function GET($param_name)
				{
					global $sm;
					return new RequestParam($sm['g'], $param_name);
				}

		/**
		 * @param string $param_name
		 * @return RequestParam
		 */
			static function Settings($param_name)
				{
					global $sm;
					return new RequestParam($sm['_s'], $param_name);
				}

		/**
		 * @return RequestManager
		 */
			static function Requests()
				{
					return new RequestManager();
				}

		/**
		 * @return MessageCollector
		 */
			static function Errors()
				{
					if (!isset(self::$errors))
						self::$errors=new MessageCollector();
					return self::$errors;
				}

		/**
		 * @return string
		 */
			static function FilesPath()
				{
					return dirname(__FILE__, 3).'/files/';
				}

		/**
		 * @return string
		 */
			static function TemporaryFilesPath($file_name='')
				{
					return self::FilesPath().'temp/'.$file_name;
				}
		}