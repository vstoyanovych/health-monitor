<?php

	//------------------------------------------------------------------------------
	//|                                                                            |
	//|            Content Management System SiMan CMS                             |
	//|                                                                            |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.9
	//#revision 2020-09-20
	//==============================================================================

	use SM\SM;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (SM::User()->Level()>=intval(sm_settings('news_editor_level')))
		include_once('modules/preload/level_inc/news.php');
	