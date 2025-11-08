<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	/*
	Module Name: Navigation
	Module URI: http://simancms.apserver.org.ua/modules/menu/
	Description: Navigation management module. Base CMS module
	Version: 1.6.23
	Revision: 2023-08-27
	Author URI: http://simancms.apserver.org.ua/
	*/

	use SM\SM;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	sm_default_action('view');

	if (sm_action('view'))
		{
			if (!empty($m['bid']))
				$menu_id = intval($m['bid']);
			else
				$menu_id = SM::GET('mid')->AsInt();
			$row=TQuery::ForTable(sm_table_prefix().'menus')
				->AddNumeric('id_menu_m', $menu_id)
				->Get();
			if (!empty($row))
				{
					sm_template('menu');
					sm_title($row['caption_m']);
					$m['menu'] = siman_load_menu($menu_id);
					siman_add_modifier_menu($m['menu']);
					sm_page_viewid('menu-view-'.$menu_id);
				}
		}

	if (SM::isAdministrator())
		include('modules/inc/adminpart/menu.php');
