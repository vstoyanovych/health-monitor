<?php

	//------------------------------------------------------------------------------
	//|                                                                            |
	//|            Content Management System SiMan CMS                             |
	//|                                                                            |
	//------------------------------------------------------------------------------

	if (!defined("adminnavigation_DEFINED"))
		{

			/** @deprecated  */
			class TNavigation extends \SM\UI\Navigation
				{
				}

			define("adminnavigation_DEFINED", 1);
		}
	