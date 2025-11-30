<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	/*
	Module Name: Replacers
	Module URI: http://simancms.apserver.org.ua/
	Description: Template replacers for custom themes
	Version: 2021-12-01
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
		{
			sm_include_lang('replacers');
			if (sm_action('postdelete'))
				{
					$q = new TQuery(sm_table_prefix()."replacers");
					$q->Add('id_r', intval(sm_getvars('id')));
					$q->Remove();
					sm_redirect('index.php?m=replacers&d=admin');
				}
			if (sm_action('postadd', 'postedit'))
				{
					$q = new TQuery(sm_table_prefix()."replacers");
					$q->AddPost('key_r');
					$q->AddPost('value_r');
					if (sm_action('postedit'))
						$q->Update('id_r='.intval(sm_getvars('id')));
					else
						$q->Insert();
					sm_redirect('index.php?m=replacers&d=admin');
				}
			if (sm_action('add', 'edit'))
				{
					add_path_modules();
					add_path('Replacers', 'index.php?m=replacers&d=admin');
					add_path_current();
					if (sm_action('add'))
						sm_title($lang['common']['add']);
					else
						sm_title($lang['common']['edit']);
					$ui = new UI();
					$f = new Form('index.php?m=replacers&d=post'.sm_current_action().'&id='.intval(sm_getvars('id')));
					$f->AddText('key_r', 'Key')
						->SetFocus();
					$f->AddTextarea('value_r', 'Content');
					if (sm_action('edit'))
						{
							$q = new TQuery(sm_table_prefix()."replacers");
							$q->Add('id_r', intval(sm_getvars('id')));
							$f->LoadValuesArray($q->Get());
						}
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					$ui->Output(true);
				}
			if (sm_action('admin'))
				{
					add_path_modules();
					add_path('Replacers', 'index.php?m=replacers&d=admin');
					$ui = new UI();
					$b=new Buttons();
					$b->AddButton('', $lang['common']['add'], 'index.php?m=replacers&d=add');
					$ui->AddButtons($b);
					$t = new Grid();
					$t->AddCol('key_r', 'Key', '50%');
					$t->AddCol('tag', 'Template Tag', '50%');
					$t->AddEdit();
					$t->AddDelete();
					$q = new TQuery(sm_table_prefix()."replacers");
					$q->Select();
					for ($i = 0; $i < $q->Count(); $i++)
						{
							$t->Label('key_r', $q->items[$i]['key_r']);
							$t->Label('tag', '{$sm.s.replacers.'.$q->items[$i]['key_r'].'}');
							$t->Url('edit', 'index.php?m=replacers&d=edit&id='.$q->items[$i]['id_r']);
							$t->Url('delete', 'index.php?m=replacers&d=postdelete&id='.$q->items[$i]['id_r']);
							$t->NewRow();
						}
					if ($q->Count() == 0)
						$t->SingleLineLabel($lang['messages']['nothing_found']);
					$ui->AddGrid($t);
					$ui->AddButtons($b);
					$ui->Output(true);
					sm_title($lang['settings']);
				}
			if (sm_action('install'))
				{
					sm_register_module('replacers', 'Replacers');
					sm_register_autoload('replacers');
					execsql("CREATE TABLE ".sm_table_prefix()."replacers (
								`id_r` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
								`key_r` VARCHAR( 255 ) NOT NULL ,
								`value_r` TEXT NOT NULL
							);");
					sm_redirect('index.php?m=admin&d=modules');
				}
			if (sm_action('uninstall'))
				{
					sm_unregister_module('replacers');
					sm_unregister_autoload('replacers');
					execsql("DROP TABLE ".sm_table_prefix()."replacers");
					sm_redirect('index.php?m=admin&d=modules');
				}
		}
