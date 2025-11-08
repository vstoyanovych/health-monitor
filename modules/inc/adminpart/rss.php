<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.23
	//#revision 2023-08-27
	//==============================================================================

	use SM\SM;
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (SM::isAdministrator())
		{
			sm_include_lang('rss');
			if (sm_action('postsettings'))
				{
					$cnt=intval(sm_postvars('rss_itemscount'));
					if ($cnt<=0)
						$cnt=15;
					sm_update_settings('rss_itemscount', $cnt);
					sm_update_settings('rss_showfulltext', intval(sm_postvars('rss_showfulltext')));
					sm_update_settings('rss_shownewsctgs', intval(sm_postvars('rss_shownewsctgs')));
					sm_update_settings('rss_shownimagetag', intval(sm_postvars('rss_shownimagetag')));
					if ($filename=sm_upload_file())
						{
							if (file_exists($filename))
								{
									$dst=SM::FilesPath().'img/rss_logo.png';
									if (file_exists($dst))
										unlink($dst);
									rename($filename, $dst);
								}
						}
					sm_notify(sm_lang('settings_saved_successful'));
					sm_redirect('index.php?m='.sm_current_module().'&d=admin');
				}
			if (sm_action('removelogo'))
				{
					if (file_exists(SM::FilesPath().'img/rss_logo.png'))
						unlink(SM::FilesPath().'img/rss_logo.png');
					sm_notify(sm_lang('messages.delete_successful'));
					sm_redirect('index.php?m='.sm_current_module().'&d=admin');
				}
			if (sm_action('admin'))
				{
					add_path_modules();
					add_path(sm_lang('module_rss.module_rss'), 'index.php?m=rss&d=admin');
					sm_title(sm_lang('settings'));
					$ui = new UI();
					$f = new Form('index.php?m=rss&d=postsettings');
					$f->AddText('rss_itemscount', sm_lang('module_rss.settings.rss_itemscount'))
						->WithValue(sm_settings('rss_itemscount'));
					$f->AddCheckbox('rss_showfulltext', sm_lang('module_rss.settings.rss_showfulltext'))
						->WithValue(sm_settings('rss_showfulltext'));
					$f->AddCheckbox('rss_shownewsctgs', sm_lang('module_rss.settings.rss_shownewsctgs'))
						->WithValue(sm_settings('rss_shownewsctgs'));
					$f->AddCheckbox('rss_shownimagetag', sm_lang('module_rss.settings.rss_shownimagetag'))
						->WithValue(sm_settings('rss_shownimagetag'));
					$ui->AddForm($f);
					if (file_exists(SM::FilesPath().'img/rss_logo.png'))
						{
							$ui->AddBlock(sm_lang('module_rss.rss_feed_logo'));
							$ui->img(SM::FilesPath().'img/rss_logo.png?rand='.rand());
							$b=new Buttons();
							$b->MessageBox(sm_lang('module_admin.delete_image'), 'index.php?m='.sm_current_module().'&d=removelogo');
							$ui->Add($b);
						}
					$ui->AddBlock(sm_lang('module_rss.rss_feeds'));
					$t = new Grid();
					$t->AddCol('title', sm_lang('title'));
					$t->AddCol('url', sm_lang('url'));
					$t->AddCol('add_to_menu', sm_lang('add_to_menu'));
					$t->Label('title', sm_lang('news'));
					$t->Label('url', sm_homepage().sm_fs_url('index.php?m=rss'));
					$t->URL('url', sm_homepage().sm_fs_url('index.php?m=rss'), true);
					$t->Label('add_to_menu', sm_lang('add_to_menu'));
					$t->URL('add_to_menu', sm_tomenuurl('RSS - '.sm_lang('news'), sm_fs_url('index.php?m=rss')));
					$t->NewRow();
					$newsctgs = getsqlarray("SELECT * FROM ".sm_table_prefix()."categories_news ORDER BY title_category");
					for ($i = 0; $i < sm_count($newsctgs); $i++)
						{
							$t->Label('title', $newsctgs[$i]['title_category']);
							$t->Label('url', sm_homepage().sm_fs_url('index.php?m=rss&ctg='.$newsctgs[$i]['id_category']));
							$t->URL('url', sm_homepage().sm_fs_url('index.php?m=rss&ctg='.$newsctgs[$i]['id_category']), true);
							$t->Label('add_to_menu', sm_lang('add_to_menu'));
							$t->URL('add_to_menu', sm_tomenuurl('RSS - '.$newsctgs[$i]['title_category'], sm_fs_url('index.php?m=rss&ctg='.$newsctgs[$i]['id_category'])));
							$t->NewRow();
						}
					$ui->AddGrid($t);
					$ui->Output(true);
				}
			if (sm_action('install'))
				{
					sm_register_module('rss', sm_lang('module_rss.module_rss'));
					sm_register_autoload('rss');
					sm_add_settings('rss_itemscount', 15);
					sm_add_settings('rss_showfulltext', 0);
					sm_add_settings('rss_shownewsctgs', 0);
					sm_add_settings('rss_shownimagetag', 0);
					sm_redirect('index.php?m=admin&d=modules');
				}
			if (sm_action('uninstall'))
				{
					sm_unregister_module('rss');
					sm_unregister_autoload('rss');
					sm_delete_settings('rss_itemscount');
					sm_delete_settings('rss_showfulltext');
					sm_delete_settings('rss_shownewsctgs');
					sm_delete_settings('rss_shownimagetag');
					sm_redirect('index.php?m=admin&d=modules');
				}
		}
	