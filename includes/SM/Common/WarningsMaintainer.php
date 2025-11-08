<?php

	namespace SM\Common;

	class WarningsMaintainer
		{

			private static $error_reporting;

			public static function PHPDisableWarnings()
				{
					self::$error_reporting=error_reporting();
					error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
				}
			
			public static function PHPRestorePreviousWarningMode()
				{
					error_reporting(self::$error_reporting);
				}

		}
