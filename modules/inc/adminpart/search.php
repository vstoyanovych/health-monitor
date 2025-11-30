<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#revision 2022-02-13
	//==============================================================================

	use SM\SM;
	use SM\UI\Grid;
	use SM\UI\Navigation;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');
	
	/** @var string[]|string[][]|string[][][] $lang */
	if (SM::isAdministrator())
		{
			if (sm_action('enablesearchmodule', 'disablesearchmodule'))
				{
					TQuery::ForTable(sm_table_prefix().'modules')
						->Add('search_enabled', sm_action('enablesearchmodule')?1:0)
						->Update('id_module', intval(sm_getvars('id')));
					sm_notify($lang['messages']['settings_updated']);
					sm_redirect('index.php?m=search&d=admin');
				}
			if (sm_action('enablesearch'))
				{
					sm_update_settings('search_module_disabled', 0);
					sm_notify($lang['messages']['settings_updated']);
					sm_redirect('index.php?m=search&d=admin');
				}
			if (sm_action('disablesearch'))
				{
					if (sm_has_settings('search_module_disabled'))
						sm_update_settings('search_module_disabled', 1);
					else
						sm_add_settings('search_module_disabled', 1);
					sm_notify($lang['messages']['settings_updated']);
					sm_redirect('index.php?m=search&d=admin');
				}
			if (sm_action('admin'))
				{
					sm_include_lang('admin');
					add_path_modules();
					add_path_current();
					sm_title($lang['control_panel'].' - '.$lang['search']);
					$ui = new UI();
					$nav=new Navigation();
					$nav->AddItem($lang['set_as_block'].' - '.$lang['search'], sm_addblockurl($lang['search'], 'search', 1));
					$nav->AddItem($lang['add_to_menu'].' - '.$lang['search'], sm_tomenuurl($lang['search'], 'index.php?m=search'));
					if (intval(sm_settings('search_module_disabled'))==1)
						$nav->AddItem($lang['common']['enable'].' - '.$lang['search'], 'index.php?m=search&d=enablesearch');
					else
						$nav->AddItem($lang['common']['disable'].' - '.$lang['search'], 'index.php?m=search&d=disablesearch');
					$ui->Add($nav);
					$ui->AddBlock($lang['common']['list']);
					$q=new TQuery(sm_table_prefix().'modules');
					$q->AddWhere("search_doing<>''");
					$q->AddWhere("search_doing IS NOT NULL");
					$q->OrderBy('module_title');
					$q->Select();
					$t=new Grid();
					$t->AddCol('module', $lang['module_admin']['module']);
					$t->AddCol('status', $lang['status']);
					$t->AddCol('action', $lang['action']);
					for ($i=0; $i<$q->Count(); $i++)
						{
							$t->Label('module', $q->items[$i]['module_title']);
							$t->Label('action', $lang['action']);
							if (intval($q->items[$i]['search_enabled'])==1)
								{
									$t->Label('status', $lang['common']['enabled']);
									$t->CellHighlightSuccess('status');
									$t->DropDownItem('action', $lang['common']['disable'], 'index.php?m='.sm_current_module().'&d=disablesearchmodule&id='.$q->items[$i]['id_module']);
								}
							else
								{
									$t->Label('status', $lang['common']['disabled']);
									$t->CellHighlightError('status');
									$t->DropDownItem('action', $lang['common']['enable'], 'index.php?m='.sm_current_module().'&d=enablesearchmodule&id='.$q->items[$i]['id_module']);
								}
							$t->NewRow();
						}
					$ui->Add($t);
					$ui->Output(true);
				}
		}
