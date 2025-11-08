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

	function siman_block_items_content($blockinfo)
		{
			global $lang;
			$sql = "SELECT * FROM ".sm_table_prefix()."categories";
			$result = execsql($sql);
			$i = 0;
			$res=[];
			while ($row = database_fetch_object($result))
				{
					$res[$i]['caption'] = ' - '.$lang['show_on_category'].': '.$row->title_category;
					$res[$i]['value'] = 'content|'.$row->id_category;
					if (
						!empty($blockinfo['show_on_module_block'])
						&& !empty($blockinfo['show_on_ctg_block'])
						&& sm_strcmp($blockinfo['show_on_module_block'], 'content') == 0
						&& $blockinfo['show_on_ctg_block'] == $row->id_category
					)
						$res[$i]['selected'] = 1;
					$i++;
				}
			return $res;
		}
	
	if (SM::User()->Level()>=intval(sm_settings('content_editor_level')))
		include_once('modules/preload/level_inc/content.php');
	