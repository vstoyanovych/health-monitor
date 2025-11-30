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
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\Navigation;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (!defined("MENU_ADMINPART_FUNCTIONS_DEFINED"))
		{
			function siman_delete_menu_line($line_id)
				{
					$result = execsql("SELECT id_ml FROM ".sm_table_prefix()."menu_lines WHERE submenu_from=".intval($line_id));
					while ($row = database_fetch_assoc($result))
						{
							siman_delete_menu_line($row['id_ml']);
						}
					if (intval(sm_settings('menuitems_use_image'))==1)
						{
							if (file_exists(SM::FilesPath().'img/menuitem'.intval($line_id).'.jpg'))
								unlink(SM::FilesPath().'img/menuitem'.intval($line_id).'.jpg');
						}
					execsql("DELETE FROM ".sm_table_prefix()."menu_lines WHERE id_ml=".intval($line_id));
				}

			define("MENU_ADMINPART_FUNCTIONS_DEFINED", 1);
		}


	if (SM::isAdministrator())
		{
			sm_on_action('admin', function ()
				{
					add_path_modules();
					add_path_current();
					sm_title(sm_lang('control_panel').' - '.sm_lang('module_menu.module_menu_name'));
					$ui = new UI();
					$nav=new Navigation();
					$nav->AddItem(sm_lang('list_menus'), 'index.php?m=menu&d=listmenu');
					$nav->AddItem(sm_lang('add_menu'), 'index.php?m=menu&d=add');
					$ui->Add($nav);
					$ui->Output(true);
				});

			sm_on_action('addouter', function ()
				{
					sm_title(sm_lang('module_menu.add_menu_line'));
					$ui = new UI();
					$f = new Form('index.php?m=menu&d=prepareaddline&returnto='.SM::GET('returnto')->UrlencodedString());
					$f->AddText('p_caption', sm_lang('caption'))
						->SetFocus();
					$f->AddText('p_url', sm_lang('url'));
					$values=[];
					$labels=[];
					$q=new TQuery(sm_table_prefix().'menus');
					$q->OrderBy('if (id_menu_m=1, 1, 0), caption_m');
					$q->Select();
					for ($i = 0; $i < $q->Count(); $i++)
						{
							$values[]=$q->items[$i]['id_menu_m'].'|0';
							$labels[]='['.$q->items[$i]['caption_m'].']';
							$lines = siman_load_menu($q->items[$i]['id_menu_m']);
							foreach ($lines as $line)
								{
									$prefix=str_repeat(' - ', $line['level']);
									$values[]=$line['add_param'];
									$labels[]=$prefix.$line['caption'];
								}
						}
					$f->AddSelect('p_mainmenu', sm_lang('module_menu.add_to_menu'), $values, $labels);
					$f->LoadValuesArray(sm_postvars());
					$f->LoadValuesArray(sm_getvars());
					$ui->AddForm($f);
					$ui->Output(true);
				});

			sm_on_action('postadd-dialog', function ()
				{
					sm_title(sm_lang('module_menu.add_menu_line'));
					$ui=new UI();
					$ui->p(sm_lang('you_want_add_line'));
					$b=new Buttons();
					$b->Button(sm_lang('no'), 'index.php?m=menu&d=listmenu');
					$b->Button(sm_lang('yes'), 'index.php?m=menu&d=addline&mid='.SM::GET('id')->AsInt());
					$ui->Add($b);
					$ui->Output(true);
				});

			sm_on_action('postadd', function ()
				{
					$title=SM::POST('p_caption')->AsString();
					if (empty($title))
						{
							SM::Errors()->AddError(sm_lang('messages.fill_required_fields'));
							sm_set_action('add');
						}
					else
						{
							$id_menu=TQuery::ForTable(sm_table_prefix().'menus')
										   ->AddString('caption_m', $title)
										   ->Insert();
							if (sm_settings('menus_use_image')>0)
								{
									siman_upload_image($id_menu, 'menu');
								}
							Redirect::Now('index.php?m=menu&d=postadd-dialog&id='.$id_menu);
						}
				});

			sm_on_action('add', function ()
				{
					add_path(sm_lang('control_panel'), 'index.php?m=admin');
					add_path(sm_lang('modules_mamagement'), 'index.php?m=admin&d=modules');
					add_path(sm_lang('module_menu.module_menu_name'), 'index.php?m=menu&d=admin');
					add_path_current();
					sm_title(sm_lang('add_menu'));
					$ui = new UI();
					SM::Errors()->DisplayUIErrors($ui);
					$f = new Form('index.php?m='.sm_current_module().'&d=postadd');
					$f->AddText('p_caption', sm_lang('caption'), true)->SetFocus();
					if (intval(sm_settings('menus_use_image'))>0)
						$f->AddFile('userfile', sm_lang('common.image'));
					$ui->Add($f);
					$ui->Output(true);
				});

			if (sm_action('postdeleteline'))
				{
					siman_delete_menu_line(SM::GET('lid')->AsInt());
					Redirect::Now('index.php?m=menu&d=listlines&mid='.SM::GET('mid')->AsInt());
				}
			if (sm_action('postaddouter'))
				{
					SM::GET('mid')->SetValue(SM::POST('p_mid')->AsString());
					$lposition = 0;
					$m["mode"] = 'postaddline';
				}
			if (sm_action('postaddline'))
				{
					$lcaption = sm_postvars("p_caption");
					$menu_id = SM::GET('mid')->AsInt();
					$lurl = sm_postvars("p_url");
					$submenu_from = intval(sm_postvars("p_sub"));
					$lposition = intval(sm_postvars("p_position"));
					$alt_ml = dbescape(sm_postvars("p_alt"));
					$newpage_ml = intval(sm_postvars("p_newpage"));
					if ($lposition == 0)
						{
							$sql = "SELECT max(position) FROM ".sm_table_prefix()."menu_lines WHERE id_menu_ml=".$menu_id." AND submenu_from=".$submenu_from;
							$lposition = 1;
							$result = execsql($sql);
							while ($row = database_fetch_row($result))
								{
									$lposition = $row[0] + 1;
								}
						}
					else
						{
							$sql = "UPDATE ".sm_table_prefix()."menu_lines SET position=position+1 WHERE position >= ".$lposition." AND id_menu_ml=".$menu_id." AND submenu_from=".$submenu_from;
							$result = execsql($sql);
						}
					$sql = "INSERT INTO ".sm_table_prefix()."menu_lines (id_menu_ml, submenu_from, url, caption_ml, position, alt_ml, newpage_ml) VALUES ('".dbescape($menu_id)."', '".dbescape($submenu_from)."', '".dbescape($lurl)."', '".dbescape($lcaption)."', '".dbescape($lposition)."', '".dbescape($alt_ml)."', '".dbescape($newpage_ml)."')";
					$id_ml = insertsql($sql);
					if (sm_settings('menuitems_use_image') == 1)
						{
							siman_upload_image($id_ml, 'menuitem');
						}
					if (!empty(sm_getvars('returnto')))
						Redirect::Now(sm_getvars('returnto'));
					else
						Redirect::Now('index.php?m=menu&d=listlines&mid='.$menu_id);
				}
			if (sm_action('posteditline'))
				{
					$menu_id = SM::GET('mid')->AsInt();
					$menuline_id = SM::GET('lid')->AsInt();
					$lcaption = sm_postvars("p_caption");
					$lurl = sm_postvars("p_url");
					$lposition = intval(sm_postvars("p_position"));
					$partial_select = intval(sm_postvars("p_partial_select"));
					$alt_ml = dbescape(sm_postvars("p_alt"));
					$attr_ml = dbescape(sm_postvars("attr_ml"));
					$newpage_ml = intval(sm_postvars("p_newpage"));
					if ($lposition == -1)
						{
							$sql = "SELECT max(position) FROM ".sm_table_prefix()."menu_lines WHERE id_menu_ml=".$menu_id;
							$lposition = 1;
							$result = execsql($sql);
							while ($row = database_fetch_row($result))
								{
									$lposition = $row[0] + 1;
								}
						}
					elseif (!empty($lposition))
						{
							$sql = "UPDATE ".sm_table_prefix()."menu_lines SET position=position+1 WHERE position>=".$lposition;
							$result = execsql($sql);
						}
					$sql = "UPDATE ".sm_table_prefix()."menu_lines SET url = '".dbescape($lurl)."', caption_ml = '".dbescape($lcaption)."', partial_select='".dbescape($partial_select)."', alt_ml = '".dbescape($alt_ml)."', attr_ml = '".dbescape($attr_ml)."', newpage_ml = '".dbescape($newpage_ml)."' ";
					if (!empty($lposition))
						{
							$sql .= ", position = '$lposition'";
						}
					$sql .= " WHERE id_ml = '$menuline_id'";
					$result = execsql($sql);
					if (sm_settings('menuitems_use_image') == 1)
						{
							siman_upload_image($menuline_id, 'menuitem');
						}
					Redirect::Now('index.php?m=menu&d=listlines&mid='.$menu_id);
				}
			if (sm_action('addline'))
				{
					sm_template('menu');
					sm_title($lang['module_menu']['add_menu_line']);
					$menu_id = SM::GET('mid')->AsInt();
					$m['idmenu'] = $menu_id;
					$m['menu'] = siman_load_menu($menu_id);
					sm_setfocus('caption');
				}
			if (sm_action('prepareaddline'))
				{
					sm_template('menu');
					sm_title($lang['module_menu']['add_menu_line']);
					$m['menuline']['menu_id'] = substr(sm_postvars('p_mainmenu'), 0, sm_strpos(sm_postvars('p_mainmenu'), '|'));
					$m['menuline']['form_url'] = 'index.php?m=menu&d=postaddline&mid='.$m['menuline']['menu_id'].'&returnto='.SM::GET('returnto')->UrlencodedString();
					$m['menuline']['sub_id'] = substr(sm_postvars('p_mainmenu'), sm_strpos(sm_postvars('p_mainmenu'), '|') + 1, sm_strlen(sm_postvars('p_mainmenu')) - sm_strpos(sm_postvars('p_mainmenu'), '|') - 1);
					$m['menuline']['caption'] = sm_postvars('p_caption');
					$m['menuline']['url'] = sm_postvars('p_url');
					$sql = "SELECT * FROM ".sm_table_prefix()."menu_lines WHERE id_menu_ml='".$m['menuline']['menu_id']."' AND submenu_from='".$m['menuline']['sub_id']."' ORDER BY position";
					$result = execsql($sql);
					$i = 0;
					while ($row = database_fetch_object($result))
						{
							$m['menu'][$i]['id'] = $row->id_ml;
							$m['menu'][$i]['caption'] = $row->caption_ml;
							$m['menu'][$i]['pos'] = $row->position;
							$i++;
						}
					sm_setfocus('alt');
				}
			if (sm_action('editline'))
				{
					sm_template('menu');
					sm_title(sm_lang('menu'));
					add_path(sm_lang('control_panel'), "index.php?m=admin");
					add_path(sm_lang('modules_mamagement'), "index.php?m=admin&d=modules");
					add_path(sm_lang('module_menu.module_menu_name'), "index.php?m=menu&d=admin");
					add_path($lang['list_menus'], "index.php?m=menu&d=listmenu");
					$menu_id = SM::GET('mid')->AsInt();
					$menuline_id = SM::GET('lid')->AsInt();
					$submenu_from = SM::GET('sid')->AsInt();
					if (empty($submenu_from)) $submenu_from = 0;
					$m['idmenu'] = $menu_id;
					$m['idline'] = $menuline_id;
					$sql = "SELECT * FROM ".sm_table_prefix()."menu_lines WHERE id_menu_ml='$menu_id' AND submenu_from='$submenu_from' ORDER BY position";
					$result = execsql($sql);
					$i = 0;
					$u = 0;
					while ($row = database_fetch_object($result))
						{
							if ($row->id_ml == $menuline_id)
								{
									$m['captionline'] = $row->caption_ml;
									$m['urlline'] = $row->url;
									$m['posline'] = $row->position;
									$m['partial_select'] = $row->partial_select;
									$m['alt_ml'] = $row->alt_ml;
									$m['attr_ml'] = $row->attr_ml;
									$m['newpage_ml'] = $row->newpage_ml;
									$u = 1;
								}
							else
								{
									if ($u == 1)
										{
											$u = 0;
										}
									else
										{
											$m['menu'][$i]['id'] = $row->id_ml;
											$m['menu'][$i]['mid'] = $menu_id;
											$m['menu'][$i]['caption'] = $row->caption_ml;
											$m['menu'][$i]['pos'] = $row->position;
											$i++;
										}
								}
						}
				}
			if (sm_action('listlines'))
				{
					$menu_id = SM::GET('mid')->AsInt();
					$q = new TQuery(sm_table_prefix().'menus');
					$q->AddNumeric('id_menu_m', $menu_id);
					$menuinfo = $q->Get();
					sm_title(sm_lang('menu').': '.$menuinfo['caption_m']);
					add_path(sm_lang('control_panel'), "index.php?m=admin");
					add_path(sm_lang('modules_mamagement'), "index.php?m=admin&d=modules");
					add_path(sm_lang('module_menu.module_menu_name'), "index.php?m=menu&d=admin");
					add_path($lang['list_menus'], "index.php?m=menu&d=listmenu");
					add_path($menuinfo['caption_m'], "index.php?m=menu&d=listlines&mid=".$menu_id);
					$m['menu'] = siman_load_menu($menu_id);
					sm_use('admintable');
					sm_use('admininterface');
					sm_use('adminbuttons');
					$ui = new UI();
					$t=new Grid('edit');
					$t->AddCol('title', $lang['common']['title'], '40%');
					$t->AddCol('url', $lang['url'], '60%');
					$t->AddCol('open', '', '16', $lang['common']['open']);
					$t->AddEdit();
					$t->AddDelete();
					for ($i = 0; $i < sm_count($m['menu']); $i++)
						{
							$lev = '';
							for ($j = 1; $j < $m['menu'][$i]['level']; $j++)
								{
									$lev .= '-';
								}
							$t->Label('title', $lev.$m['menu'][$i]['caption']);
							if (sm_strlen($m['menu'][$i]['url'])>65)
								{
									$t->Label('url', substr($m['menu'][$i]['url'], 0, 65).'...');
									$t->Expand('url');
									$t->ExpanderHTML($m['menu'][$i]['url']);
								}
							else
								$t->Label('url', $m['menu'][$i]['url']);
							$t->URL('title', $m['menu'][$i]['url'], true);
							$t->Image('open', 'url');
							$t->URL('open', $m['menu'][$i]['url'], true);
							$t->URL('edit', 'index.php?m=menu&d=editline&mid='.$m['menu'][$i]['mid'].'&lid='.$m['menu'][$i]['id'].'&sid='.$m['menu'][$i]['submenu_from']);
							$t->URL('delete', 'index.php?m=menu&d=postdeleteline&mid='.$m['menu'][$i]['mid'].'&lid='.$m['menu'][$i]['id']);
							$t->NewRow();
						}
					if ($t->RowCount()==0)
						$t->SingleLineLabel($lang['messages']['nothing_found']);
					$b=new Buttons();
					$b->AddButton('add', $lang['module_menu']['add_menu_line'], 'index.php?m=menu&d=addline&mid='.$menu_id);
					$ui->AddButtons($b);
					$ui->AddGrid($t);
					$ui->AddButtons($b);
					$ui->Output(true);
				}
			if (sm_action('editmenu'))
				{
					sm_template('menu');
					sm_title($lang["edit_menu"]);
					add_path(sm_lang('control_panel'), "index.php?m=admin");
					add_path(sm_lang('modules_mamagement'), "index.php?m=admin&d=modules");
					add_path(sm_lang('module_menu.module_menu_name'), "index.php?m=menu&d=admin");
					$menu_id = SM::GET('mid')->AsInt();
					$sql = "SELECT * FROM ".sm_table_prefix()."menus WHERE id_menu_m='$menu_id'";
					$result = execsql($sql);
					while ($row = database_fetch_object($result))
						{
							$m["id"] = $menu_id;
							$m["caption"] = $row->caption_m;
						}
				}
			if (sm_action('postedit'))
				{
					sm_template('menu');
					sm_title($lang['edit_menu']);
					$menu_id = SM::GET('mid')->AsInt();
					$mcaption = SM::POST("p_caption")->AsString();
					(new TQuery(sm_table_prefix().'menus'))
						->AddString('caption_m', $mcaption)
						->Update('id_menu_m', $menu_id);
					if (sm_settings('menus_use_image') == 1)
						{
							siman_upload_image($menu_id, 'menu');
						}
					Redirect::Now('index.php?m=menu&d=listmenu');
				}

			sm_on_action('postdeletemenu', function ()
				{
					$menu_id = SM::GET('mid')->AsInt();
					execsql("DELETE FROM ".sm_table_prefix()."menus WHERE id_menu_m=".$menu_id);
					if (sm_settings('menuitems_use_image') == 1)
						{
							if (file_exists(SM::FilesPath().'img/menu'.$menu_id.'.jpg'))
								unlink(SM::FilesPath().'img/menu'.$menu_id.'.jpg');
						}
					$q=new TQuery(sm_table_prefix().'menu_lines');
					$q->AddNumeric('id_menu_ml', $menu_id);
					$q->Remove();
					Redirect::Now('index.php?m=menu&d=listmenu');
				});

			sm_on_action('listmenu', function ()
				{
					sm_title(sm_lang('list_menus'));
					add_path_control();
					add_path(sm_lang('modules_mamagement'), 'index.php?m=admin&d=modules');
					add_path(sm_lang('module_menu.module_menu_name'), 'index.php?m=menu&d=admin');
					add_path_current();
					$ui = new UI();
					$t=new Grid('edit');
					$t->AddCol('title', sm_lang('common.title'), '85%');
					$t->AddCol('add_to_menu', sm_lang('add_to_menu'), '15%');
					$t->AddEdit();
					$t->AddDelete();
					$t->AddCol('stick', '', '16', sm_lang('set_as_block'), '', 'stick.gif');
					$q=new TQuery(sm_table_prefix().'menus');
					$q->OrderBy('caption_m');
					$q->Select();
					foreach ($q->items as $item)
						{
							$t->Label('title', $item['caption_m']);
							$t->Label('add_to_menu', sm_lang('add_to_menu'));
							$t->URL('add_to_menu', sm_tomenuurl($item['caption_m'], sm_fs_url('index.php?m=menu&d=view&mid='.$item['id_menu_m'])));
							$t->URL('title', 'index.php?m=menu&d=listlines&mid='.$item['id_menu_m']);
							$t->URL('edit', 'index.php?m=menu&d=editmenu&mid='.$item['id_menu_m']);
							if ($item['id_menu_m']!=sm_settings('upper_menu_id') && $item['id_menu_m']!=sm_settings('bottom_menu_id') && $item['id_menu_m']!=sm_settings('users_menu_id'))
								$t->URL('delete', 'index.php?m=menu&d=postdeletemenu&mid='.$item['id_menu_m']);
							$t->URL('stick', sm_addblockurl($item['caption_m'], 'menu', $item['id_menu_m'], 'view', 'index.php?m=menu&d=listlines&mid='.$item['id_menu_m']));
							$t->NewRow();
						}
					$b=new Buttons();
					$b->AddButton('add', sm_lang('add_menu'), 'index.php?m=menu&d=add');
					$ui->AddButtons($b);
					$ui->AddGrid($t);
					$ui->AddButtons($b);
					$ui->Output(true);
				});

		}
