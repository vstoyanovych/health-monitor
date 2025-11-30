<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.23
	//#revision 2023-08-27
	//==============================================================================

	use SM\Common\Redirect;
	use SM\SM;
	use SM\SMDBData;
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\Navigation;
	use SM\UI\Tabs;
	use SM\UI\UI;
	use SM\UI\FA;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (!defined("ADMIN_FUNCTIONS_DEFINED"))
		{
			sm_include_lang('admin');
			function sm_get_module_info($filename)
				{
					if (!file_exists($filename))
						return false;
					$fh = fopen($filename, 'r');
					$info = fread($fh, 2048);
					fclose($fh);
					$start = sm_strpos($info, 'Module Name:');
					if ($start !== false && sm_strpos($info, '*/', $start) !== false)
						{
							$info = substr($info, $start, sm_strpos($info, '*/', $start) - $start);
							$items=nllistToArray($info, true);
							for ($i=0; $i<sm_count($items); $i++)
								{
									$item=explode(':', $items[$i]);
									$key=sm_getnicename(trim($item[0]));
									$value='';
									for ($j=1; $j<sm_count($item); $j++)
										$value.=($j>1?':'.$item[$j]:ltrim($item[$j]));
									$result[$key]=$value;
								}
							return $result;
						}
					else
						return false;
				}
			function siman_clean_resource_url($url)
				{
					$url = trim($url);
					if (strcmp($url, '/')==0)
						$url = '';
					if (substr($url, -1) != '/' && sm_strlen($url)>0)
						$url .= '/';
					if (sm_strpos($url, '://')!==false)
						return substr($url, sm_strpos($url, '://')+3);
					return $url;
				}

			sm_add_cssfile('stylesheetsadmin.css');
			define("ADMIN_FUNCTIONS_DEFINED", 1);
		}

	sm_default_action('view');

	if (SM::isAdministrator())
		{
			if (sm_actionpost('postsettings'))
				{
					$settings_mode=SM::GET('viewmode')->AsStringOrDefault('default');
					//------- Common settings ------------------------------------------------------------------------------
					sm_update_settings('resource_title', sm_postvars('p_title'), $settings_mode);
					sm_update_settings('resource_url', siman_clean_resource_url(sm_postvars('p_url')), $settings_mode);
					sm_update_settings('resource_url_mobile', siman_clean_resource_url(sm_postvars('resource_url_mobile')), $settings_mode);
					sm_update_settings('resource_url_tablet', siman_clean_resource_url(sm_postvars('resource_url_tablet')), $settings_mode);
					sm_update_settings('resource_url_rewrite', intval(sm_postvars('resource_url_rewrite'))==1 ? '1' : '0', $settings_mode);
					sm_update_settings('logo_text', sm_postvars('p_logo'), $settings_mode);
					sm_update_settings('copyright_text', sm_postvars('p_copyright'), $settings_mode);
					sm_update_settings('meta_keywords', sm_postvars('p_keywords'), $settings_mode);
					sm_update_settings('meta_description', sm_postvars('p_description'), $settings_mode);
					sm_update_settings('default_language', sm_postvars('p_lang'), $settings_mode);
					sm_update_settings('default_theme', sm_postvars('p_theme'), $settings_mode);
					sm_update_settings('sidepanel_count', (intval(sm_postvars('p_sidepanel_count')) <= 0) ? 1 : intval(sm_postvars('p_sidepanel_count')), $settings_mode);
					sm_update_settings('default_module', sm_postvars('p_module'), $settings_mode);
					sm_update_settings('cookprefix', sm_postvars('p_cook'), $settings_mode);
					sm_update_settings('max_upload_filesize', intval(sm_postvars('p_maxfsize')), $settings_mode);
					sm_update_settings('admin_items_by_page', intval(sm_postvars('p_adminitems_per_page'))<=0 ? 10 : intval(sm_postvars('p_adminitems_per_page')), $settings_mode);
					sm_update_settings('search_items_by_page', intval(sm_postvars('p_searchitems_per_page'))<=0 ? 10 : intval(sm_postvars('p_searchitems_per_page')), $settings_mode);
					sm_update_settings('ext_editor', sm_postvars('p_exteditor'), $settings_mode);
					sm_update_settings('noflood_time', intval(sm_postvars('p_floodtime'))<=0 ? 600 : intval(sm_postvars('p_floodtime')), $settings_mode);
					sm_update_settings('blocks_use_image', intval(sm_postvars('p_blocks_use_image'))==1?1:0, $settings_mode);
					sm_update_settings('rewrite_index_title', sm_postvars('p_rewrite_index_title'), $settings_mode);
					sm_update_settings('log_type', intval(sm_postvars('p_log_type'))<=0 ? 0 : intval(sm_postvars('p_log_type')), $settings_mode);
					sm_update_settings('log_store_days', intval(sm_postvars('p_log_store_days'))<=0 ? 0 : intval(sm_postvars('p_log_store_days')), $settings_mode);
					sm_update_settings('image_generation_type', (sm_postvars('p_image_generation_type') == 'static') ? 'static' : 'dynamic', $settings_mode);
					sm_update_settings('title_delimiter', sm_postvars('p_title_delimiter'), $settings_mode);
					sm_update_settings('meta_resource_title_position', intval(sm_postvars('p_meta_resource_title_position')), $settings_mode);
					if ($settings_mode === 'default')
						{
							sm_update_settings('hide_generator_meta', intval(sm_postvars('hide_generator_meta')));
						}
					//------- Menu settings ------------------------------------------------------------------------------
					sm_update_settings('upper_menu_id', sm_postvars('p_uppermenu'), $settings_mode);
					sm_update_settings('bottom_menu_id', sm_postvars('p_bottommenu'), $settings_mode);
					sm_update_settings('users_menu_id', sm_postvars('p_usersmenu'), $settings_mode);
					sm_update_settings('menus_use_image', intval(sm_postvars('p_menus_use_image'))==1?1:0, $settings_mode);
					sm_update_settings('menuitems_use_image', intval(sm_postvars('p_menuitems_use_image'))==1?1:0, $settings_mode);
					//------- Text settings ------------------------------------------------------------------------------
					sm_update_settings('content_use_preview', intval(sm_postvars('p_content_use_preview'))==1?1:0, $settings_mode);
					sm_update_settings('content_per_page_multiview', intval(sm_postvars('content_per_page_multiview'))<=0?10:intval(sm_postvars('content_per_page_multiview')), $settings_mode);
					sm_update_settings('allow_alike_content', intval(sm_postvars('p_allow_alike_content'))==1?1:0, $settings_mode);
					sm_update_settings('alike_content_count', intval(sm_postvars('alike_content_count'))<=0 ? 5 : intval(sm_postvars('alike_content_count')), $settings_mode);
					sm_update_settings('content_use_path', (sm_postvars('p_content_use_path') == '1') ? '1' : '0', $settings_mode);
					sm_update_settings('content_attachments_count', sm_abs(intval(sm_postvars('p_content_attachments_count'))), $settings_mode);
					sm_update_settings('content_use_image', (sm_postvars('p_content_use_image') == '1') ? '1' : '0', $settings_mode);
					sm_update_settings('content_image_preview_width', sm_postvars('p_content_image_preview_width'), $settings_mode);
					sm_update_settings('content_image_preview_height', sm_postvars('p_content_image_preview_height'), $settings_mode);
					sm_update_settings('content_image_fulltext_width', sm_postvars('p_content_image_fulltext_width'), $settings_mode);
					sm_update_settings('content_image_fulltext_height', sm_postvars('p_content_image_fulltext_height'), $settings_mode);
					sm_update_settings('content_editor_level', intval(sm_postvars('content_editor_level')), $settings_mode);
					if ($settings_mode === 'default')
						{
							sm_update_settings('autogenerate_content_filesystem', intval(sm_postvars('autogenerate_content_filesystem')), 'content');
						}
					//------- News settings ------------------------------------------------------------------------------
					sm_update_settings('news_use_time', intval(sm_postvars('p_news_use_time'))==1?1:0, $settings_mode);
					sm_update_settings('news_use_image', intval(sm_postvars('p_news_use_image'))==1?1:0, $settings_mode);
					sm_update_settings('news_image_preview_width', sm_postvars('p_news_image_preview_width'), $settings_mode);
					sm_update_settings('news_image_preview_height', sm_postvars('p_news_image_preview_height'), $settings_mode);
					sm_update_settings('news_image_fulltext_width', sm_postvars('p_news_image_fulltext_width'), $settings_mode);
					sm_update_settings('news_image_fulltext_height', sm_postvars('p_news_image_fulltext_height'), $settings_mode);
					sm_update_settings('news_by_page', intval(sm_postvars('p_news_per_page'))<=0?10:intval(sm_postvars('p_news_per_page')), $settings_mode);
					sm_update_settings('news_use_preview', intval(sm_postvars('p_news_use_preview'))==1?1:0, $settings_mode);
					sm_update_settings('news_anounce_cut', intval(sm_postvars('p_news_cut'))<=0?300:intval(sm_postvars('p_news_cut')), $settings_mode);
					sm_update_settings('short_news_count', intval(sm_postvars('p_news_short'))<=0?3:intval(sm_postvars('p_news_short')), $settings_mode);
					sm_update_settings('short_news_cut', intval(sm_postvars('p_short_news_cut'))<=0?100:intval(sm_postvars('p_short_news_cut')), $settings_mode);
					sm_update_settings('allow_alike_news', intval(sm_postvars('p_allow_alike_news'))==1?1:0, $settings_mode);
					sm_update_settings('alike_news_count', intval(sm_postvars('p_alike_news_count')), $settings_mode);
					sm_update_settings('news_attachments_count', sm_abs(intval(sm_postvars('p_news_attachments_count'))), $settings_mode);
					sm_update_settings('news_full_list_longformat', intval(sm_postvars('news_full_list_longformat')), $settings_mode);
					sm_update_settings('news_editor_level', intval(sm_postvars('news_editor_level')), $settings_mode);
					if ($settings_mode === 'default')
						{
							sm_update_settings('autogenerate_news_filesystem', intval(sm_postvars('autogenerate_news_filesystem')), 'news');
						}
					//------ User settings ----------------------------------------------------------------
					sm_update_settings('allow_register', intval(sm_postvars('p_allowregister'))==1?1:0, $settings_mode);
					sm_update_settings('allow_forgot_password', intval(sm_postvars('p_allowforgotpass'))==1?1:0, $settings_mode);
					sm_update_settings('user_activating_by_admin', intval(sm_postvars('p_adminactivating'))==1?1:0, $settings_mode);
					sm_update_settings('return_after_login', intval(sm_postvars('p_return_after_login'))==1?1:0, $settings_mode);
					sm_update_settings('allow_private_messages', intval(sm_postvars('p_allow_private_messages'))==1?1:0, $settings_mode);
					sm_update_settings('use_email_as_login', (sm_postvars('p_use_email_as_login') == '1') ? '1' : '0', $settings_mode);
					sm_update_settings('signinwithloginandemail', intval(sm_postvars('signinwithloginandemail')), $settings_mode);
					sm_update_settings('redirect_after_login_1', sm_postvars('p_redirect_after_login_1'), $settings_mode);
					sm_update_settings('redirect_after_login_2', sm_postvars('p_redirect_after_login_2'), $settings_mode);
					sm_update_settings('redirect_after_login_3', sm_postvars('p_redirect_after_login_3'), $settings_mode);
					sm_update_settings('redirect_after_register', sm_postvars('p_redirect_after_register'), $settings_mode);
					sm_update_settings('redirect_after_logout', sm_postvars('p_redirect_after_logout'), $settings_mode);
					sm_update_settings('redirect_on_success_change_usrdata', sm_postvars('redirect_on_success_change_usrdata'), $settings_mode);
					//------ Security settings ----------------------------------------------------------------
					sm_update_settings('banned_ip', sm_postvars('p_banned_ip'), $settings_mode);
					//------ Static texts settings ----------------------------------------------------------------
					sm_update_settings('meta_header_text', sm_postvars('p_meta_header_text'), $settings_mode);
					sm_update_settings('header_static_text', sm_postvars('p_htext'), $settings_mode);
					sm_update_settings('footer_static_text', sm_postvars('p_ftext'), $settings_mode);
					//---- Setup mail settings ------------------------------------------------------------
					sm_update_settings('administrators_email', sm_postvars('p_admemail'), $settings_mode);
					sm_update_settings('email_signature', sm_postvars('p_esignature'), $settings_mode);
					//-------------------------------------------------------------------------------------

					include(sm_cms_rootdir().'includes/config.php');
					sm_notify(sm_lang('settings_saved_successful'));
					Redirect::Now('index.php?m=admin&d=settings&viewmode='.$settings_mode);
				}
			if (sm_action('postuplimg'))
				{
					$fs = $_uplfilevars['userfile']['tmp_name'];
					if (empty(sm_postvars('p_optional')))
						{
							$fd = basename($_uplfilevars['userfile']['name']);
						}
					else
						{
							$fd = sm_postvars('p_optional');
						}
					$fd = SM::FilesPath().'img/'.$fd;
					$m['fs'] = $fs;
					$m['fd'] = $fd;
					if (!sm_is_allowed_to_upload($fd))
						{
							$m['error_message']=$lang['error_file_upload_message'];
							sm_set_action('uplimg');
						}
					elseif (!move_uploaded_file($fs, $fd))
						{
							$m['error_message']=$lang['error_file_upload_message'];
							sm_set_action('uplimg');
						}
					else
						{
							sm_event('afteruploadedimagesaveadmin', array($fd));
							sm_notify($lang['operation_completed']);
							Redirect::Now('index.php?m=admin&d=listimg');
						}
				}
			if (sm_action('view'))
				{
					if (intval(sm_settings('ignore_update'))!=1)
						{
							if (file_exists(sm_cms_rootdir().'includes/update.php'))
								{
									sm_update_settings('install_not_erased', 1);
								}
						}
					sm_event('beforeadmindashboard');
					sm_title($lang['control_panel']);
					$ui = new UI();
					sm_event('admin-dashboard-ui-start', $ui);
					//--------------------------------------------------------------------------------------------------
					$shortcutsdashboard=new Navigation();
					sm_event('admin-dashboard-shortcuts-nav-start', $shortcutsdashboard);
					if ($shortcutsdashboard->Count()>0)
						{
							$ui->AddBlock($lang['module_admin']['shortcuts']);
							$ui->AddDashboard($shortcutsdashboard);
						}
					sm_event('admin-dashboard-shortcuts-nav-end', $shortcutsdashboard);
					//--------------------------------------------------------------------------------------------------
					$ui->AddBlock($lang['control_panel']);
					$navigation=new Navigation();
					sm_event('admin-dashboard-control-nav-start', $navigation);
					$navigation->AddItem($lang['modules_mamagement'], 'index.php?m=admin&d=modules')->SetFA('th-large');
					$navigation->AddItem($lang['blocks_mamagement'], 'index.php?m=blocks')->SetFA('thumb-tack ');
					$navigation->AddItem($lang['module_admin']['virtual_filesystem'], 'index.php?m=admin&d=filesystem')->SetFA('folder');
					$navigation->AddItem($lang['module_admin']['images_list'], 'index.php?m=admin&d=listimg')->SetFA('picture-o');
					$navigation->AddItem($lang['module_admin']['optimize_database'], 'index.php?m=admin&d=tstatus')->SetFA('database');
					if (intval(sm_settings('log_type'))>0)
						$navigation->AddItem($lang['module_admin']['view_log'], 'index.php?m=admin&d=viewlog')->SetFA('history');
					if (is_writeable(sm_cms_rootdir()) && sm_settings('packages_upload_allowed'))
						$navigation->AddItem($lang['module_admin']['upload_package'], 'index.php?m=admin&d=package')->SetFA('upload');
					$navigation->AddItem('robots.txt', 'index.php?m=admin&d=robotstxt')->SetFA('file-code-o');
					$navigation->AddItem('ads.txt', 'index.php?m=admin&d=adstxt')->SetFA('file-text-o');
					$navigation->AddItem($lang['settings'], 'index.php?m=admin&d=settings')->SetFA('cog');
					sm_event('admin-dashboard-control-nav-end', $navigation);
					$ui->Add($navigation);
					unset($navigation);
					//--------------------------------------------------------------------------------------------------
					$ui->AddBlock($lang['user_settings']);
					$navigation=new Navigation();
					sm_event('admin-dashboard-users-nav-start', $navigation);
					$navigation->AddItem($lang['register_user'], 'index.php?m=account&d=adminregister')->SetFA('user-plus');
					$navigation->AddItem($lang['user_list'], 'index.php?m=account&d=usrlist')->SetFA('user');
					$navigation->AddItem($lang['module_account']['groups_management'], 'index.php?m=account&d=listgroups')->SetFA('users');
					$navigation->AddItem($lang['module_admin']['mass_email'], 'index.php?m=admin&d=massemail')->SetFA('envelope');
					sm_event('admin-dashboard-users-nav-end', $navigation);
					$ui->Add($navigation);
					unset($navigation);
					//--------------------------------------------------------------------------------------------------
					sm_event('admin-dashboard-ui-end', $ui);
					$ui->Output(true);
					sm_event('afteradmindashboard');
				}
			if (sm_action('uplimg'))
				{
					sm_title($lang['upload_image']);
					add_path_control();
					add_path($lang['module_admin']['images_list'], 'index.php?m=admin&d=listimg');
					add_path_current();
					$ui = new UI();
					if (!empty($m['error_message']))
						$ui->NotificationError($m['error_message']);
					$f = new Form('index.php?m=admin&d=postuplimg');
					$f->AddFile('userfile', $lang['file_name']);
					$f->AddText('p_optional', $lang['optional_file_name']);
					$f->SaveButton($lang['upload']);
					$ui->AddForm($f);
					$ui->NotificationInfo($lang['module_admin']['images_media_notification']);
					$ui->Output(true);
				}
			if (sm_action('addmodule'))
				{
					add_path_modules();
					add_path_current();
					sm_title($lang['module_admin']['add_module']);
					$ui = new UI();
					$t=new Grid();
					$t->AddCol('title', $lang['module'], '20%');
					$t->AddCol('information', $lang['common']['information'], '25%');
					$t->AddCol('description', $lang['common']['description'], '50%');
					$t->AddCol('url', '', '16', $lang['common']['url']);
					$t->SetHeaderImage('url', 'url');
					$t->AddCol('action', $lang['action'], '5%');
					$t->SetAsMessageBox('action', $lang['common']['are_you_sure']);
					$dir = dir(sm_cms_rootdir().'modules/');
					$i = 0;
					while ($entry = $dir->read())
						{
							if (sm_strpos($entry, '.php') > 0)
								{
									if (in_array($entry, Array('admin.php', 'content.php', 'account.php', 'blocks.php', 'refresh.php', 'menu.php', 'news.php', 'download.php', 'search.php', 'media.php')))
										continue;
									if (in_array(substr($entry, 0, -4), nllistToArray(sm_settings('installed_packages'))))
										continue;
									$info = sm_get_module_info('./modules/'.$entry);
									if ($info === false)
										continue;
									if (!empty($info[sm_getnicename('Module Name')]))
										$t->Label('title', $info[sm_getnicename('Module Name')]);
									else
										$t->Label('title', substr($entry, 0, -4));
									$information='';
									if (!empty($info[sm_getnicename('Version')]))
										$information=$lang['module_admin']['version'].': '.$info[sm_getnicename('Version')].'<br />';
									if (!empty($info[sm_getnicename('Author')]))
										$information.=$lang['module_admin']['author'].': '.$info[sm_getnicename('Author')].'<br />';
									$t->Label('information', $information);
									if (!empty($info[sm_getnicename('Description')]))
										$t->Label('description', $info[sm_getnicename('Description')]);
									if (!empty($info[sm_getnicename('Author URI')]))
										$t->DropDownItem('url', $lang['module_admin']['author'], $info[sm_getnicename('Author URI')]);
									if (!empty($info[sm_getnicename('Module URI')]))
										$t->DropDownItem('url', $lang['module'], $info[sm_getnicename('Module URI')]);
									if ($t->DropDownItemsCount('url')>0)
										$t->Image('url', 'url');
									$t->Label('action', $lang['common']['install']);
									$t->URL('action', 'index.php?m='.substr($entry, 0, -4).'&d=install');
									$t->NewRow();
									$i++;
								}
						}
					$dir->close();
					if ($t->RowCount()==0)
						$t->SingleLineLabel($lang['messages']['nothing_found']);
					$ui->AddGrid($t);
					$ui->Output(true);
				}
			if (sm_action('modules'))
				{
					add_path_modules();
					sm_title($lang['modules_mamagement']);
					$ui = new UI();
					$b = new Buttons();
					$b->AddButton('add', $lang['module_admin']['add_module'], 'index.php?m=admin&d=addmodule');
					$ui->AddButtons($b);
					$t = new Grid();
					$t->AddCol('title', $lang['module']);
					$t->AddCol('information', $lang['common']['information'], '25%');
					$t->AddCol('description', $lang['common']['description'], '50%');
					$t->AddCol('url', '', '16', $lang['common']['url']);
					$t->AddEdit();
					$t->AddCol('delete', '', '16');
					$t->SetHeaderImage('delete', 'transparent.gif');
					$result = execsql('SELECT * FROM '.sm_table_prefix().'modules');
					$i = 0;
					while ($row = database_fetch_assoc($result))
						{
							$info = sm_get_module_info('./modules/'.$row['module_name'].'.php');
							if (!empty($info[sm_getnicename('Module Name')]))
								$t->Label('title', $info[sm_getnicename('Module Name')]);
							else
								$t->Label('title', substr($row['module_name'], 0, -4));
							$information='';
							if (!empty($info[sm_getnicename('Version')]))
								$information=$lang['module_admin']['version'].': '.$info[sm_getnicename('Version')].'<br />';
							if (!empty($info[sm_getnicename('Author')]))
								{
									if (!empty($info[sm_getnicename('Author URI')]))
										$information.=$lang['module_admin']['author'].': <a href="'.$info[sm_getnicename('Author URI')].'" target="_blank">'.$info[sm_getnicename('Author')].'</a><br />';
									else
										$information.=$lang['module_admin']['author'].': '.$info[sm_getnicename('Author')].'<br />';
								}
							$t->Label('information', $information);
							if (!empty($info[sm_getnicename('Description')]))
								$t->Label('description', $info[sm_getnicename('Description')]);
							if (!empty($info[sm_getnicename('Author URI')]))
								$t->DropDownItem('url', $lang['module_admin']['author'], $info[sm_getnicename('Author URI')]);
							if (!empty($info[sm_getnicename('Module URI')]))
								$t->DropDownItem('url', $lang['module'], $info[sm_getnicename('Module URI')]);
							if ($t->DropDownItemsCount('url')>0)
								$t->Image('url', 'url');
							if (!empty($row['module_title']))
								$t->Label('title', $row['module_title']);
							$t->Url('title', 'index.php?m='.$row['module_name'].'&d=admin');
							$t->Url('edit', 'index.php?m=admin&d=chgttl&mid='.$row['id_module']);
							if (!in_array($row['module_name'], Array('content', 'news', 'download', 'menu', 'search', 'media')) && sm_is_installed($row['module_name']))
								{
									$t->Image('delete', 'delete.gif');
									$t->Url('delete', 'index.php?m='.$row['module_name'].'&d=uninstall');
									$t->CustomMessageBox('delete', $lang['common']['are_you_sure']);
								}
							$t->NewRow();
							$i++;
						}
					$ui->AddGrid($t);
					$ui->AddButtons($b);
					$ui->Output(true);
				}
			if (sm_action('postchgttl'))
				{
					$q=new TQuery(sm_table_prefix().'modules');
					$q->AddPost('module_title');
					$q->Update('id_module', SM::GET('mid')->AsInt());
					Redirect::Now('index.php?m=admin&d=modules');
				}
			if (sm_action('chgttl'))
				{
					add_path_control();
					add_path_current();
					sm_title($lang['change_title']);
					$ui = new UI();
					$f = new Form('index.php?m=admin&d=postchgttl&mid='.SM::GET('mid')->AsInt());
					$f->AddText('module_title', $lang['title'])
						->SetFocus();
					$q=new TQuery(sm_table_prefix().'modules');
					$q->Add('id_module', intval(sm_getvars('mid')));
					$f->LoadValuesArray($q->Get());
					$ui->AddForm($f);
					$ui->Output(true);
				}

			sm_on_action('copysettings', function ()
				{
					if (SM::GET('destmode')->isEmpty() || SM::GET('name')->isEmpty())
						return;
					$q = new TQuery(sm_table_prefix().'settings');
					$q->Add('name_settings', dbescape(sm_getvars('name')));
					$q->Add('value_settings', dbescape(sm_settings(sm_getvars('name'))));
					$q->Add('mode', dbescape(sm_getvars('destmode')));
					$q->Insert();
					Redirect::Now('index.php?m=admin&d=settings');
				});

			sm_on_action('remsettings', function ()
				{
					if (SM::GET('destmode')->isEmpty() || SM::GET('name')->isEmpty())
						return;
					$q = new TQuery(sm_table_prefix().'settings');
					$q->Add('name_settings', dbescape(sm_getvars('name')));
					$q->Add('mode', dbescape(sm_getvars('destmode')));
					$q->Remove();
					Redirect::Now('index.php?m=admin&d=settings');
				});

			if (sm_action('settings'))
				{
					sm_template('admin');
					sm_title($lang['settings']);
					sm_add_cssfile('css/adminpart/admin-settings.css');
					if (!empty(sm_getvars('viewmode')))
						$m['mode_settings'] = sm_getvars('viewmode');
					else
						$m['mode_settings'] = 'default';
					$m['list_modes'][0]['mode'] = 'mobile';
					$m['list_modes'][0]['shortcut'] = 'M';
					$m['list_modes'][0]['hint'] = $lang['common']['device'].': '.$lang['common']['mobile_device'];
					$m['list_modes'][0]['profile'] = $lang['common']['mobile_device'];
					$m['list_modes'][1]['mode'] = 'tablet';
					$m['list_modes'][1]['shortcut'] = 'T';
					$m['list_modes'][1]['hint'] = $lang['common']['device'].': '.$lang['common']['tablet_device'];
					$m['list_modes'][1]['profile'] = $lang['common']['tablet_device'];
					add_path_control();
					add_path($lang['settings'], 'index.php?m=admin&d=settings');
					if ($m['mode_settings'] == 'default')
						{
							$m['available_modes'] = $m['list_modes'];
							add_path($lang['common']['general'], 'index.php?m=admin&d=settings');
						}
					elseif ($m['mode_settings'] == 'mobile')
						{
							$m['available_modes'] = [];
							add_path($lang['common']['mobile_device'], 'index.php?m=admin&d=settings&viewmode=mobile');
						}
					elseif ($m['mode_settings'] == 'tablet')
						{
							$m['available_modes'] = [];
							add_path($lang['common']['tablet_device'], 'index.php?m=admin&d=settings&viewmode=tablet');
						}
					$sql = "SELECT * FROM ".sm_table_prefix()."settings WHERE mode='".dbescape($m['mode_settings'])."'";
					$result = execsql($sql);
					while ($row = database_fetch_object($result))
						{
							$m['edit_settings'][$row->name_settings] = $row->value_settings;
							$m['show_settings'][$row->name_settings] = 1;
						}
					for ($i = 0; $i < sm_count($m['available_modes']); $i++)
						{
							$sql = "SELECT * FROM ".sm_table_prefix()."settings WHERE mode='".dbescape($m['available_modes'][$i]['mode'])."'";
							$result = execsql($sql);
							while ($row = database_fetch_object($result))
								{
									$m['extmodes'][$m['available_modes'][$i]['mode']]['show_settings'][$row->name_settings] = 1;
								}
						}
					$dir = dir(sm_cms_rootdir().'lang/');
					$i = 0;
					while ($entry = $dir->read())
						{
							if (strcmp($entry, '.') != 0 && strcmp($entry, '..') != 0 && strcmp($entry, 'index.html') != 0 && sm_strpos($entry, '.php'))
								{
									$m['lang'][$i] = substr($entry, 0, sm_strpos($entry, '.'));
									$i++;
								}
						}
					$dir->close();
					$dir = dir(sm_cms_rootdir().'themes/');
					$i = 0;
					while ($entry = $dir->read())
						{
							if (strcmp($entry, '.') != 0 && strcmp($entry, '..') != 0 && strcmp($entry, 'default') != 0 && strcmp($entry, 'index.html') != 0)
								{
									if (!file_exists(SM::FilesPath().'themes/'.$entry)) continue;
									$m['themes'][$i] = $entry;
									$i++;
								}
						}
					$dir->close();
					$dir = dir(sm_cms_rootdir().'ext/editors/');
					$i = 0;
					while ($entry = $dir->read())
						{
							if (strcmp($entry, '.') != 0 && strcmp($entry, '..') != 0 && strcmp($entry, 'index.html') != 0)
								{
									$m['exteditors'][$i] = $entry;
									$i++;
								}
						}
					$dir->close();
					$q=new TQuery(sm_table_prefix().'modules');
					$q->OrderBy('module_title');
					$q->Open();
					while ($q->Fetch())
						$m['modules'][]=Array(
							'title' => $q->row['module_title'].(empty($q->row['module_title'])?$q->row['module_name']:''),
							'name' => $q->row['module_name'],
							'id' => $q->row['id_module']
						);
					unset($q);
					$q=new TQuery(sm_table_prefix()."menus");
					$q->OrderBy('caption_m');
					$q->Open();
					while ($q->Fetch())
						$m['menus'][]=Array(
							'title' => $q->row['caption_m'],
							'id' => $q->row['id_menu_m']
						);
					unset($q);
					if ($m['mode_settings'] == 'default')
						{
							$m['edit_settings']['autogenerate_content_filesystem'] = sm_get_settings('autogenerate_content_filesystem', 'content');
							$m['show_settings']['autogenerate_content_filesystem'] = 1;
							$m['edit_settings']['autogenerate_news_filesystem'] = sm_get_settings('autogenerate_news_filesystem', 'news');
							$m['show_settings']['autogenerate_news_filesystem'] = 1;
						}
				}
			if (sm_action('tstatus'))
				{
					add_path_control();
					add_path_current();
					sm_title($lang['module_admin']['optimize_database']);
					$ui = new UI();
					if (SMDBData::CurrentServerType() === 0 || SMDBData::CurrentServerType() === 3)
						{
							$t = new Grid();
							$t->AddCol('table_name', $lang['module_admin']['table_name'], '25%');
							$t->AddCol('table_rows', $lang['module_admin']['table_rows'], '25%');
							$t->AddCol('table_size', $lang['module_admin']['table_size'], '25%');
							$t->AddCol('table_not_optimized', $lang['module_admin']['table_not_optimized'], '20%');
							$t->AddCol('table_optimize', $lang['module_admin']['table_optimize'], '5%');
							$sql = "SHOW TABLE STATUS FROM ".SMDBData::CurrentDatabase();
							$result = execsql($sql);
							$i = 0;
							while ($row = database_fetch_object($result))
								{
									$t->Label('table_name', $row->Name);
									$t->Label('table_rows', $row->Rows);
									$t->Label('table_not_optimized', $row->Data_free);
									$t->Label('table_size', $row->Data_length + $row->Index_length);
									$t->Checkbox('table_optimize', 'p_opt_'.$i, $row->Name, $row->Data_free>0);
									$t->NewRow();
									$i++;
								}
							$ui->html('<form action="index.php?m=admin&d=optimize" method="post">');
							$ui->html('<input type="hidden" name="p_table_count" value="'.$i.'" />');
							$ui->AddGrid($t);
							$ui->div('<input type="submit" value="'.$lang['module_admin']['optimize_tables'].'" />', '', '', 'text-align:right;');
						}
					else
						{
							$ui->NotificationWarning($lang['module_admin']['message_no_tables_in_DB']);
						}
					$ui->Output(true);
				}
			if (sm_action('optimize'))
				{
					$tc = sm_postvars('p_table_count');
					if (SMDBData::CurrentServerType() === 0 || SMDBData::CurrentServerType() === 3)
						{
							for ($i = 0; $i < $tc; $i++)
								{
									if (!empty(sm_postvars('p_opt_'.$i)))
										{
											$sql = "OPTIMIZE TABLE `".dbescape(sm_postvars('p_opt_'.$i))."`";
											$result = execsql($sql);
										}
								}
							sm_notify($lang['module_admin']['message_optimize_successfull']);
							Redirect::Now('index.php?m=admin&d=tstatus');
						}
				}
			if (sm_action('viewimg'))
				{
					sm_title($lang['common']['image']);
					add_path_control();
					add_path($lang['module_admin']['images_list'], 'index.php?m=admin&d=listimg');
					add_path_current();
					$ui = new UI();
					$ui->div_open('', 'text-center');
					$ui->img(SM::FilesPath().'img/'.sm_getvars('path'), '', '', 'max-width:400px;');
					$b=new Buttons();
					$b->AddMessageBox('del', $lang['common']['delete'], 'index.php?m=admin&d=postdelimg&imgn='.urlencode(sm_getvars('path')), $lang['module_admin']['really_want_delete_image'].'?');
					$ui->AddButtons($b);
					$ui->div_close();
					$ui->Output(true);
				}
			if (sm_action('listimg'))
				{
					sm_title($lang['module_admin']['images_list']);
					add_path_control();
					add_path_current();
					$ui=new UI();
					$ui->div_open('searchimg', '', empty(sm_getvars('filter'))?'display:none;':'');
					$f=new Form('index.php');
					$f->SetMethodGet();
					$f->AddHidden('m', 'admin');
					$f->AddHidden('d', 'listimg');
					$f->AddText('filter', $lang['search']);
					$f->SaveButton($lang['search']);
					$f->LoadValuesArray(sm_getvars());
					$ui->AddForm($f);
					$ui->div_close();
					$b=new Buttons();
					$b->Button($lang['upload_image'], 'index.php?m=admin&d=uplimg&returnto='.urlencode(sm_this_url()));
					$b->AddToggle('searchb', $lang['search'], Array('searchimg', 'filter'));
					$t=new Grid();
					$t->AddCol('thumb', $lang['common']['thumbnail'], '10');
					$t->AddCol('title', $lang['module_admin']['image_file_name'], '85%');
					$t->AddCol('open', $lang['common']['open'], '5%');
					$t->AddEdit();
					$t->AddDelete();
					$t->SetAsMessageBox('delete', $lang['module_admin']['really_want_delete_image']);
					$i = 0;
					$j = -1;
					$files = load_file_list(SM::FilesPath().'img/');
					$offset=sm_abs(intval(sm_getvars('from')));
					$limit=intval(sm_settings('admin_items_by_page'));
					while ($j + 1 < count($files))
						{
							$j++;
							$entry = $files[$j];
							if (!empty(sm_getvars('filter')))
								if (sm_strpos($entry, sm_getvars('filter')) === false)
									continue;
							if (strcmp($entry, '.') != 0 && strcmp($entry, '..') != 0 && strcmp($entry, 'index.html') != 0 && strcmp($entry, '.htaccess') != 0)
								{
									if ($i>=$offset && $i<$limit+$offset)
										{
											$t->Image('thumb', sm_thumburl($entry, 50, 50));
											$t->Label('title', $entry);
											$t->Label('open', $lang['common']['open']);
											$t->URL('title', 'index.php?m=admin&d=viewimg&path='.urlencode($entry));
											$t->URL('open', SM::FilesPath().'img/'.$entry, true);
											$t->URL('edit', 'index.php?m=admin&d=renimg&imgn='.urlencode($entry));
											$t->URL('delete', 'index.php?m=admin&d=postdelimg&imgn='.urlencode($entry));
											$t->NewRow();
										}
									$i++;
								}
						}
					if ($t->RowCount()==0)
						$t->SingleLineLabel($lang['messages']['nothing_found']);
					$ui->Add($b);
					$ui->Add($t);
					$ui->Add($b);
					$ui->AddPagebarParams($i, $limit, $offset);
					$ui->NotificationInfo($lang['module_admin']['images_media_notification']);
					$ui->Output(true);
				}
			if (sm_action('postdelimg'))
				{
					sm_title($lang['module_admin']['delete_image']);
					$img = sm_getvars("imgn");
					if (!sm_strpos($img, '..') && !sm_strpos($img, '/') && !sm_strpos($img, '\\'))
						unlink(SM::FilesPath().'img/'.$img);
					sm_notify($lang['module_admin']['message_delete_image_successful']);
					Redirect::Now('index.php?m=admin&d=listimg');
				}
			if (sm_action('postrenimg'))
				{
					$img1 = sm_getvars("on");
					$img2 = sm_getvars("nn");
					if (!(!sm_strpos($img1, '..') && !sm_strpos($img1, '/') && !sm_strpos($img1, '\\') && !sm_strpos($img2, '..') && !sm_strpos($img2, '/') && !sm_strpos($img2, '\\')) || empty($img1) || empty($img2) || !sm_is_allowed_to_upload($img2))
						{
							$m["error_message"] = $lang['module_admin']['message_wrong_file_name'];
						}
					else
						{
							if (!rename(SM::FilesPath().'img/'.$img1, SM::FilesPath().'img/'.$img2))
								$m["error_message"] = $lang['module_admin']['message_cant_reaname'];
						}
					if (empty($m["error_message"]))
						{
							sm_notify($lang['module_admin']['message_rename_image_successful']);
							Redirect::Now('index.php?m=admin&d=listimg');
						}
					else
						{
							$m['mode'] = 'renimg';
							SM::GET('imgn')->SetValue($img1);
						}
				}
			if (sm_action('renimg') && !empty(sm_getvars("imgn")))
				{
					sm_title($lang['module_admin']['rename_image']);
					add_path_control();
					add_path($lang['module_admin']['images_list'], "index.php?m=admin&d=listimg");
					$ui = new UI();
					if (!empty($m['error_message']))
						$ui->div($m['error_message'], '', 'errormessage');
					$f = new Form('index.php', '', 'get');
					$f->AddText('nn', $lang['file_name'])
						->SetFocus();
					$f->LoadValuesArray(sm_getvars());
					if (empty(sm_getvars('nn')))
						$f->SetValue('nn', sm_getvars("imgn"));
					$f->AddHidden('m', 'admin');
					$f->AddHidden('d', 'postrenimg');
					$f->AddHidden('on', sm_getvars("imgn"));
					$f->SaveButton($lang['rename']);
					$ui->AddForm($f);
					$ui->Output(true);
				}
			if (sm_action('postmassemail'))
				{
					if (empty(sm_postvars('subject')) || empty(sm_postvars('message')))
						{
							$error=$lang['message_set_all_fields'];
							sm_set_action('massemail');
						}
					else
						{
							$result = execsql("SELECT * FROM ".sm_global_table_prefix()."users WHERE get_mail=1");
							while ($row = database_fetch_assoc($result))
								{
									send_mail(sm_website_title()." <".sm_settings('administrators_email').">", $row['email'], sm_postvars('subject'), sm_postvars('message'));
								}
							sm_notify($lang['operation_completed']);
							Redirect::Now('index.php?m=admin');
						}
				}
			if (sm_action('massemail'))
				{
					add_path_control();
					add_path_current();
					sm_title($lang['module_admin']['mass_email']);
					$ui = new UI();
					if (!empty($error))
						$ui->NotificationError($error);
					$f = new Form('index.php?m=admin&d=postmassemail');
					$f->AddText('subject', $lang['module_admin']['mass_email_theme'])
						->SetFocus();
					$f->AddEditor('message', $lang['module_admin']['mass_email_message']);
					$f->LoadValuesArray(sm_postvars());
					if (count(sm_postvars())==0)
						$f->SetValue('message', sm_settings('email_signature'));
					$ui->AddForm($f);
					$ui->Output(true);
				}
			if (sm_action('filesystem'))
				{
					add_path_control();
					add_path($lang['module_admin']['virtual_filesystem'], 'index.php?m=admin&d=filesystem');
					sm_title($lang['module_admin']['virtual_filesystem']);
					$offset=sm_abs(sm_getvars('from'));
					$limit=intval(sm_settings('admin_items_by_page'));
					$ui = new UI();
					$t=new Grid();
					$t->AddCol('ico', '', '16');
					$t->AddCol('url', $lang['url'], '50%');
					$t->HeaderDropDownItem('url', $lang['common']['sortingtypes']['asc'], sm_this_url(Array('orderby'=>'urlasc', 'from'=>'')));
					$t->HeaderDropDownItem('url', $lang['common']['sortingtypes']['desc'], sm_this_url(Array('orderby'=>'urldesc', 'from'=>'')));
					$t->AddCol('title', $lang['common']['title'], '50%');
					$t->HeaderDropDownItem('title', $lang['common']['sortingtypes']['asc'], sm_this_url(Array('orderby'=>'titleasc', 'from'=>'')));
					$t->HeaderDropDownItem('title', $lang['common']['sortingtypes']['desc'], sm_this_url(Array('orderby'=>'titledesc', 'from'=>'')));
					$t->AddEdit();
					$t->AddDelete();
					$t->AddMenuInsert();
					$q=new TQuery(sm_table_prefix()."filesystem");
					if (sm_getvars('orderby')=='urldesc')
						$q->OrderBy('filename_fs DESC');
					elseif (sm_getvars('orderby')=='titleasc')
						$q->OrderBy('comment_fs');
					elseif (sm_getvars('orderby')=='titledesc')
						$q->OrderBy('comment_fs DESC');        
					else
						$q->OrderBy('filename_fs');
					$q->Limit($limit);
					$q->Offset($offset);
					$q->Select();
					for ($i = 0; $i<$q->Count(); $i++)
						{
							if (substr($q->items[$i]['filename_fs'], -1) == '/')
								$t->Label('ico', FA::EmbedCodeFor('folder'));
							else
								$t->Label('ico', FA::EmbedCodeFor('file-o'));
							$t->Hint('ico', $q->items[$i]['id_fs']);
							$t->Label('url', $q->items[$i]['filename_fs']);
							$t->Label('title', empty($q->items[$i]['comment_fs'])?'-----':$q->items[$i]['comment_fs']);
							$t->URL('url', $q->items[$i]['filename_fs'], true);
							$t->URL('title', $q->items[$i]['url_fs'], true);
							$t->URL('edit', 'index.php?m=admin&d=editfilesystem&id='.$q->items[$i]['id_fs'].'&returnto='.urlencode(sm_this_url()));
							$t->URL('delete', 'index.php?m=admin&d=postdeletefilesystem&id='.$q->items[$i]['id_fs'].'&returnto='.urlencode(sm_this_url()));
							$t->Menu($q->items[$i]['comment_fs'], $q->items[$i]['filename_fs']);
							$t->NewRow();
						}
					$b=new Buttons();
					$b->AddButton('add', $lang['common']['add'], 'index.php?m=admin&d=addfilesystem');
					$ui->AddButtons($b);
					$ui->AddGrid($t);
					$ui->AddButtons($b);
					$ui->AddPagebarParams($q->TotalCount(), $limit, $offset);
					$ui->Output(true);
				}
			if (sm_action('postdeletefilesystem'))
				{
					sm_title($lang['common']['delete']);
					$sql = "DELETE FROM ".sm_table_prefix()."filesystem WHERE id_fs=".intval(sm_getvars("id"));
					execsql($sql);
					if (!empty(sm_getvars('returnto')))
						Redirect::Now(sm_getvars('returnto'));
					else
						Redirect::Now('index.php?m=admin&d=filesystem');
				}
			if (sm_action('postaddfilesystem', 'posteditfilesystem'))
				{
					$q=new TQuery(sm_table_prefix().'filesystem');
					$q->Add('filename_fs', dbescape(sm_postvars('filename_fs')));
					$q->Add('url_fs', dbescape(sm_postvars('url_fs')));
					$q->Add('comment_fs', dbescape(sm_postvars('comment_fs')));
					if (sm_action('postaddfilesystem'))
						$q->Insert();
					else
						$q->Update('id_fs', intval(sm_getvars('id')));
					if (!empty(sm_getvars('returnto')))
						Redirect::Now(sm_getvars('returnto'));
					else
						Redirect::Now('index.php?m=admin&d=filesystem');
				}
			if (sm_action('addfilesystem', 'editfilesystem'))
				{
					add_path_control();
					add_path($lang['module_admin']['virtual_filesystem'], 'index.php?m=admin&d=filesystem');
					$ui = new UI();
					if (!empty($error))
						$ui->div($error, '', 'error alert-error');
					if (sm_action('editfilesystem'))
						{
							sm_title($lang['common']['edit']);
							$f=new Form('index.php?m=admin&d=posteditfilesystem&id='.intval(sm_getvars('id')).'&returnto='.urlencode(sm_getvars('returnto')));
						}
					else
						{
							sm_title($lang['common']['add']);
							$f=new Form('index.php?m=admin&d=postaddfilesystem&returnto='.urlencode(sm_getvars('returnto')));
						}
					$f->AddText('filename_fs', $lang['common']['url'])
						->SetFocus();
					$f->AddText('url_fs', $lang['module_admin']['true_url']);
					$f->AddText('comment_fs', $lang['common']['comment']);
					if (sm_action('editfilesystem'))
						{
							$q=new TQuery(sm_table_prefix().'filesystem');
							$q->Add('id_fs', intval(sm_getvars('id')));
							$f->LoadValuesArray($q->Get());
							unset($q);
						}
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					$ui->Output(true);
				}

			sm_on_action('viewlog', function ()
				{
					add_path_control();
					add_path(sm_lang('module_admin.view_log'), 'index.php?m=admin&d=viewlog');
					if (intval(sm_settings('log_store_days'))>0)
						{
							$q = new TQuery(sm_table_prefix().'log');
							$q->Add('object_name', 'system');
							$q->Add('time<'.(time()-intval(sm_settings('log_store_days'))*3600*24));
							$q->Remove();
						}
					sm_title(sm_lang('module_admin.view_log'));
					$limit=100;
					$offset=SM::GET('from')->AsAbsInt();
					$ui = new UI();
					$t=new Grid();
					$t->AddCol('time', sm_lang('common.time'), '20%');
					$t->AddCol('description', sm_lang('common.description'), '60%');
					$t->AddCol('ip', 'IP', '10%');
					$t->AddCol('user', sm_lang('user'), '10%');
					$q=new TQuery(sm_table_prefix().'log');
					$q->AddString('object_name', 'system');
					$q->OrderBy('id_log DESC');
					$q->Limit($limit);
					$q->Offset($offset);
					$q->Select();
					for ($i = 0; $i<count($q->items); $i++)
						{
							$t->Label('time', date(sm_datetime_mask(), $q->items[$i]['time']));
							$t->Label('description', htmlescape($q->items[$i]['description']));
							$t->Label('ip', @inet_ntop($q->items[$i]['ip']));
							$t->Label('user', $q->items[$i]['user']);
							$t->NewRow();
						}
					if ($t->RowCount()===0)
						$t->SingleLineLabel(sm_lang('messages.nothing_found'));
					$ui->AddGrid($t);
					$ui->AddPagebarParams($q->TotalCount(), $limit, $offset);
					$ui->Output(true);
				});

			if (sm_action('postpackage') && sm_settings('packages_upload_allowed'))
				{
					if (empty(sm_getvars('typeupload')))
						{
							$fs = $_uplfilevars['userfile']['tmp_name'];
							$fd = basename($_uplfilevars['userfile']['name']);
							$fd = './'.$fd;
							$m['fs'] = $fs;
							$m['fd'] = $fd;
							if (!move_uploaded_file($fs, $fd))
								{
									$m['error_message'] = $lang['error_file_upload_message'];
									sm_set_action('package');
								}
						}
					elseif (function_exists('curl_init'))
						{
							$ch = curl_init(sm_postvars('urlupload'));
							if (file_exists(sm_cms_rootdir().'urlupload.zip'))
								unlink(sm_cms_rootdir().'urlupload.zip');
							$fp = fopen(sm_cms_rootdir()."urlupload.zip", "w");
							curl_setopt($ch, CURLOPT_FILE, $fp);
							curl_setopt($ch, CURLOPT_HEADER, 0);
							curl_setopt($ch, CURLOPT_FAILONERROR, 1);
							curl_exec($ch);
							$tmperr = curl_error($ch);
							curl_close($ch);
							fclose($fp);
							if (!empty($tmperr))
								{
									$m['error_message'] = $tmperr;
									sm_set_action('package');
									unlink(sm_cms_rootdir().'urlupload.zip');
								}
							else
								$fd = sm_cms_rootdir().'urlupload.zip';
						}
					if (sm_action('postpackage'))
						{
							global $refresh_url;
							require_once(sm_cms_rootdir().'ext/package/unarchiver.php');
							$zip = new PclZip($fd);
							$ext = $zip->extract(PCLZIP_OPT_SET_CHMOD, 0777);
							unlink($fd);
							if (intval(sm_settings('ignore_update'))!=1)
								{
									if (file_exists(sm_cms_rootdir().'includes/update.php'))
										{
											include(sm_cms_rootdir().'includes/update.php');
											@unlink(sm_cms_rootdir().'includes/update.php');
											if (file_exists(sm_cms_rootdir().'includes/update.php') && empty($refresh_url))
												sm_update_settings('install_not_erased', 1);
										}
								}
							if (empty($refresh_url))
								Redirect::Now('index.php?m=admin&d=view');
						}
				}
			if (sm_action('package') && sm_settings('packages_upload_allowed'))
				{
					sm_title($lang['module_admin']['upload_package']);
					add_path_control();
					add_path_current();
					$ui = new UI();
					if (!empty($m['error_message']))
						{
							$ui->AddBlock($lang['error']);
							$ui->NotificationError($m['error_message']);
						}
					$tabs=new Tabs();
					$tabs->AddBlock($lang['module_admin']['upload_package'].' ('.$lang['common']['file'].')');
					$f = new Form('index.php?m=admin&d=postpackage');
					$f->AddFile('userfile', $lang['file_name']);
					$f->SaveButton($lang['upload']);
					$tabs->AddForm($f);
					if (function_exists('curl_init'))
						{
							$tabs->AddBlock($lang['module_admin']['upload_package'].' ('.$lang['common']['url'].')');
							$f = new Form('index.php?m=admin&d=postpackage&typeupload=url');
							$f->AddText('urlupload', $lang['common']['url']);
							if (sm_getvars('typeupload')=='url')
								{
									$tabs->SetActiveIndex(1);
									$f->SetFocus();
								}
							$f->SaveButton($lang['upload']);
							$tabs->AddForm($f);
						}
					$ui->Add($tabs);
					$ui->Output(true);
				}

			sm_on_action('saverobotstxt', function ()
				{
					sm_update_settings('robots_txt', SM::POST('robotstxtcontent')->AsString(), 'seo');
					Redirect::Now('index.php?m=admin');
				});

			sm_on_action('robotstxt', function ()
				{
					add_path_control();
					add_path_current();
					sm_title('robots.txt');
					$ui = new UI();
					$f = new Form('index.php?m=admin&d=saverobotstxt');
					$f->AddTextarea('robotstxtcontent')
						->WithValue(sm_get_settings('robots_txt', 'seo'))
						->SetFocus()
						->MergeColumns();
					$ui->AddForm($f);
					$ui->Output(true);
				});

			sm_on_action('saveadstxt', function ()
				{
					sm_update_settings('ads_txt', SM::POST('robotstxtcontent')->AsString(), 'seo');
					Redirect::Now('index.php?m=admin');
				});

			sm_on_action('adstxt', function ()
				{
					if (!sm_settings_exists_in_db('ads_txt', 'seo'))
						{
							if (file_exists(sm_cms_rootdir().'ads.txt'))
								sm_add_settings('ads_txt', file_get_contents(sm_cms_rootdir().'ads.txt'), 'seo');
							else
								sm_add_settings('ads_txt', '', 'seo');
						}
					add_path_control();
					add_path_current();
					sm_title('ads.txt');
					$ui = new UI();
					$f = new Form('index.php?m=admin&d=saveadstxt');
					$f->AddTextarea('robotstxtcontent')
						->WithValue(sm_get_settings('ads_txt', 'seo'))
						->SetFocus()
						->MergeColumns();
					$ui->AddForm($f);
					$ui->Output(true);
				});

		}
