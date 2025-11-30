<?php

	class Path
		{
			public static function Root()
				{
					return dirname(dirname(__FILE__)).'/';
				}

			public static function VARFOLDER()
				{
					return dirname(dirname(dirname(dirname(__FILE__)))).'/';
				}
		}