<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	/*
	Module Name: Settings (Expert Mode)
	Module URI: http://simancms.apserver.org.ua/modules/adminsettings/
	Description: Manage default settings in expert mode.
	Version: 2020-09-20
	Author: SiMan CMS Team
	Author URI: http://simancms.apserver.org.ua/
	*/

	use SM\SM;
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (SM::isAdministrator())
		sm_include_lang('adminsettings');
	
	if (SM::isAdministrator() && sm_is_installed(sm_current_module()))
		{
			sm_default_action('admin');
			if (sm_action('addeditor', 'addhtml', 'edit', 'html'))
				{
					add_path_modules();
					add_path($lang['module_adminsettings']['module_adminsettings'], 'index.php?m=adminsettings&d=admin');
					add_path_current();
					if (sm_action('addeditor', 'addhtml'))
						sm_title($lang['common']['add']);
					else
						sm_title($lang['common']['edit']);
					$ui = new UI();
					if (sm_action('addeditor', 'addhtml'))
						$f = new Form('index.php?m=adminsettings&d=postadd');
					else
						$f = new Form('index.php?m=adminsettings&d=postedit&param='.urlencode(sm_getvars('param')).'&mode='.urlencode(sm_getvars('mode')));
					$f->AddText('name_settings', 'name_settings');
					if (sm_action('addeditor', 'edit'))
						$f->AddEditor('value_settings', 'value_settings');
					else
						$f->AddTextarea('value_settings', 'value_settings');
					$f->AddText('mode', 'mode');
					if (sm_action('addeditor', 'addhtml'))
						{
							$f->SetValue('mode', 'default');
						}
					else
						{
							$q=new TQuery(sm_table_prefix()."settings");
							$q->Add('mode', empty(sm_getvars('mode'))?'default':dbescape(sm_getvars('mode')));
							$q->Add('name_settings', dbescape(sm_getvars('param')));
							$f->LoadValuesArray($q->Get());
						}
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					$ui->Output(true);
					sm_setfocus('name_settings');
				}
			if (sm_action('admin'))
				{
					add_path_modules();
					add_path($lang['module_adminsettings']['module_adminsettings'], 'index.php?m=adminsettings&d=admin');
					sm_use('admintable');
					sm_use('adminbuttons');
					sm_use('admininterface');
					sm_title($lang['settings']);
					$ui = new UI();
					$b=new Buttons();
					$b->AddButton('', $lang['common']['add'], 'index.php?m=adminsettings&d=addeditor');
					$b->AddButton('', $lang['common']['add'].'('.$lang['common']['html'].')', 'index.php?m=adminsettings&d=addhtml');
					$ui->AddButtons($b);
					$t=new Grid('edit');
					$t->AddCol('title', $lang['common']['title'], '80%');
					$t->AddCol('mode', '', '20%');
					$t->AddEdit();
					$t->AddCol('html', '', '16', $lang['common']['edit'].' ('.$lang['common']['html'].')', '', 'edit_html.gif');
					$t->AddDelete();
					$result = execsql("SELECT * FROM ".sm_table_prefix()."settings ORDER BY if(mode='default', 0, 1), mode, name_settings");
					$i = 0;
					while ($row = database_fetch_assoc($result))
						{
							$t->Label('title', $row['name_settings']);
							$t->Hint('title', strip_tags($row['value_settings']));
							$t->Label('mode', $row['mode']);
							$t->URL('edit', 'index.php?m=adminsettings&d=edit&param='.urlencode($row['name_settings']).'&mode='.urlencode($row['mode']));
							$t->URL('html', 'index.php?m=adminsettings&d=html&param='.urlencode($row['name_settings']).'&mode='.urlencode($row['mode']));
							$t->URL('delete', 'index.php?m=adminsettings&d=postdelete&param='.urlencode($row['name_settings']).'&mode='.urlencode($row['mode']));
							$t->NewRow();
						}
					$ui->AddGrid($t);
					$ui->AddButtons($b);
					$ui->Output(true);
				}
			if (sm_action('postadd', 'postedit'))
				{
					$q=new TQuery(sm_table_prefix()."settings");
					$q->Add('mode', empty(sm_postvars('mode'))?'default':dbescape(sm_postvars('mode')));
					$q->Add('name_settings', dbescape(sm_postvars('name_settings')));
					$q->Add('value_settings', dbescape(sm_postvars('value_settings')));
					if (sm_action('postedit'))
						{
							$q->AddWhere('mode', empty(sm_getvars('mode'))?'default':dbescape(sm_getvars('mode')));
							$q->AddWhere('name_settings', dbescape(sm_getvars('param')));
							$q->Update();
						}
					else
						$q->Insert();
					sm_redirect('index.php?m=adminsettings&d=admin');
				}
			if (sm_action('postdelete'))
				{
					$q=new TQuery(sm_table_prefix()."settings");
					$q->Add('mode', empty(sm_getvars('mode'))?'default':dbescape(sm_getvars('mode')));
					$q->Add('name_settings', dbescape(sm_getvars('param')));
					$q->Remove();
					sm_redirect('index.php?m=adminsettings&d=admin');
				}
			if (sm_action('uninstall'))
				{
					sm_unregister_module('adminsettings');
					sm_redirect('index.php?m=admin&d=modules');
				}
		}

	if (!sm_is_installed(sm_current_module()) && SM::isAdministrator())
		{
			if (sm_action('install'))
				{
					sm_register_module('adminsettings', $lang['module_adminsettings']['module_adminsettings']);
					sm_redirect('index.php?m=admin&d=modules');
				}
		}