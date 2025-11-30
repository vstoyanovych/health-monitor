<?php

	namespace SM;

	class SMDBData
		{

			public static function CurrentDatabase()
				{
					global $nameDB;
					return $nameDB;
				}

			public static function CurrentServerType()
				{
					global $serverDB;
					return $serverDB;
				}

		}