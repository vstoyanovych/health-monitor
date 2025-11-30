<?php

	//------------------------------------------------------------------------------
	//|                                                                            |
	//|            Content Management System SiMan CMS                             |
	//|                                                                            |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.19
	//#revision 2020-09-20
	//==============================================================================

	use SM\SM;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (SM::User()->Level()>=intval(sm_settings('content_editor_level')))
		include_once('modules/preload/level_inc/content.php');

