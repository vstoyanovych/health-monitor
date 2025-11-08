<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#revision 2021-08-15
	//==============================================================================

	use SM\SM;
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\ModalHelper;
	use SM\UI\Navigation;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	/** @var string[]|string[][]|string[][][] $lang */
	if (SM::isAdministrator())
		{
			if (sm_action('admin'))
				{
					sm_title($lang['control_panel'].' - '.$lang['module_content_name']);
					add_path_modules();
					add_path_current();
					$ui = new UI();
					$nav=new Navigation();
					$nav->AddItem($lang['common']['add'], 'index.php?m=content&d=add');
					$nav->AddItem(sprintf('%s (%s)', $lang['common']['add'], $lang['common']['html']), 'index.php?m=content&d=add&exteditor=off');
					$nav->AddItem($lang['list_content'], 'index.php?m=content&d=list');
					$nav->AddItem($lang['common']['categories'], 'index.php?m=content&d=listctg');
					$nav->AddItem($lang['add_category'], 'index.php?m=content&d=addctg');
					$nav->AddItem(sprintf('%s "%s - %s"', $lang['set_as_block'], $lang['list_content'], $lang['common']['category']), sm_addblockurl($lang['list_content'].' - '.$lang['common']['category'], 'content', 1, 'blockctgview'));
					$ui->Add($nav);
					$ui->Output(true);
				}
			if (sm_actionpost('postaddctg', 'posteditctg'))
				{
					if (empty(sm_postvars('title_category')))
						$error_message=$lang['messages']['fill_required_fields'];
					elseif (sm_action('postadd') && !empty(sm_postvars('url')) && sm_fs_exists(sm_postvars('url')))
						$error_message=$lang['messages']['seo_url_exists'];
					elseif (sm_action('postedit') && !empty(sm_postvars('url')) && sm_fs_exists(sm_postvars('url')) && sm_strcmp(sm_postvars('url'), sm_fs_url('index.php?m=content&d=viewctg&ctgid='.intval(sm_getvars('id'))))!=0)
						$error_message=$lang['messages']['seo_url_exists'];
					if (empty($error_message))
						{
							$groups=get_groups_list();
							$groupsviewenabled=Array();
							$groupsmodifyenabled=Array();
							for ($i = 0; $i < sm_count($groups); $i++)
								{
									if (!empty(sm_postvars('group_view_'.$groups[$i]['id'])))
										$groupsviewenabled[]=$groups[$i]['id'];
									if (!empty(sm_postvars('group_modify_'.$groups[$i]['id'])))
										$groupsmodifyenabled[]=$groups[$i]['id'];
								}
							$q=new TQuery(sm_table_prefix().'categories');
							$q->Add('id_maincategory', intval(sm_postvars('id_maincategory')));
							$q->Add('title_category', dbescape(sm_postvars('title_category')));
							$q->Add('can_view', intval(sm_postvars('can_view')));
							$q->Add('preview_category', dbescape(sm_postvars('preview_category')));
							$q->Add('sorting_category', intval(sm_postvars('sorting_category')));
							$q->Add('groups_view', dbescape(create_groups_str($groupsviewenabled)));
							$q->Add('groups_modify', dbescape(create_groups_str($groupsmodifyenabled)));
							if (intval(sm_settings('allow_alike_content'))==1)
								$q->Add('no_alike_content', intval(sm_postvars('no_alike_content')));
							if (intval(sm_settings('content_use_path'))==1)
								$q->Add('no_use_path', intval(sm_postvars('no_use_path')));
							if (sm_action('postaddctg'))
								{
									$ctgid=$q->Insert();
								}
							else
								{
									$ctgid=intval(sm_getvars('ctgid'));
									$q->Update('id_category', $ctgid);
								}
							if (!empty(sm_getvars('returnto')))
								sm_redirect(sm_getvars('returnto'));
							else
								sm_redirect('index.php?m=content&d=listctg');
							if (!empty(sm_postvars('url')))
								sm_fs_update(sm_postvars('title_category'), 'index.php?m=content&d=viewctg&ctgid='.$ctgid, sm_postvars('url'));
							sm_notify($lang['operation_completed']);
							if (sm_action('postadd'))
								sm_event('postaddctgcontent', Array($ctgid));
							else
								sm_event('posteditctgcontent', Array($ctgid));
						}
					else
						sm_set_action(Array('postaddctg'=>'addctg', 'posteditctg'=>'editctg'));
				}
			if (sm_action('addctg', 'editctg'))
				{
					$use_ext_editor=strcmp(sm_getvars('exteditor'), 'off')!=0;
					if (sm_action('addctg'))
						{
							sm_event('onaddcontentcategory');
						}
					else
						{
							$info=TQuery::ForTable(sm_table_prefix().'categories')
								->AddWhere('id_category', intval(sm_getvars('ctgid')))
								->Get();
							sm_event('oneditcontentcategory', Array($info['id_category']));
						}
					add_path_modules();
					add_path($lang['module_content_name'], 'index.php?m=content&d=admin');
					$b=new Buttons();
					if ($use_ext_editor)
						{
							$b->AddMessageBox('exteditoroff', $lang['ext']['editors']['switch_to_standard_editor'], sm_this_url(Array('exteditor'=>'off')), $lang['common']['are_you_sure']."? ".$lang['messages']['changes_will_be_lost']);
							$modal=new ModalHelper();
							$modal->SetAJAXSource('index.php?m=media&d=editorinsert&theonepage=1');
							$b->AddButton('insertimgmodal', $lang['add_image'])
								->OnClick($modal->GetJSCode());
						}
					else
						$b->AddMessageBox('exteditoron', $lang['ext']['editors']['switch_to_ext_editor'], sm_this_url(Array('exteditor'=>'')), $lang['common']['are_you_sure']."? ".$lang['messages']['changes_will_be_lost']);
					$categories = siman_load_ctgs_content(-1);
					$v=Array(0);
					$l=Array($lang['common']['none']);
					for ($i = 0; $i < sm_count($categories); $i++)
						{
							$v[]=$categories[$i]['id'];
							$l[]=$categories[$i]['title'];
						}
					$ui=new UI();
					if (!empty($error_message))
						$ui->NotificationError($error_message);
					if (sm_action('addctg'))
						{
							sm_event('beforecontentcategoryaddform');
							sm_title($lang['add_category']);
							$f=new Form('index.php?m='.sm_current_module().'&d=postaddctg&returnto='.urlencode(sm_getvars('returnto')));
							sm_event('startcontentcategoryaddform');
						}
					else
						{
							sm_event('beforecontentcategoryeditform', Array($info['id_category']));
							sm_title($lang['edit_category']);
							$f=new Form('index.php?m='.sm_current_module().'&d=posteditctg&ctgid='.intval($info['id_category']).'&returnto='.urlencode(sm_getvars('returnto')));
							sm_event('startcontentcategoryeditform', Array($info['id_category']));
						}
					$f->Separator($lang['common']['general']);
					$f->AddText('title_category', $lang['common']['title'], true)
						->SetFocus();
					$f->AddSelect('id_maincategory', $lang['module_content']['main_category'], $v, $l)
						->WithValue(intval(sm_getvars('ctg')));
					if (!empty($sm['contenteditor']['controlbuttonsclass']))
						$b->ApplyClassnameForAll($sm['contenteditor']['controlbuttonsclass']);
					$f->InsertButtons($b);
					if ($use_ext_editor)
						{
							$f->AddEditor('preview_category', $lang['common']['preview'])
							  ->MergeColumns();
						}
					else
						{
							$f->AddTextarea('preview_category', $lang['common']['preview'])
							  ->MergeColumns();
						}
					$f->AddText('url', $lang['common']['url'])
						->WithTooltip($lang['common']['leave_empty_for_default']);
					$f->Separator($lang['common']['extended_parameters']);
					$f->AddSelect('sorting_category', $lang['common']['sorting'],
						Array(0, 1, 2, 3),
						Array($lang['common']['title'].' / '.$lang['common']['sortingtypes']['asc'], $lang['common']['title'].' / '.$lang['common']['sortingtypes']['desc'], $lang['common']['priority'].' / '.$lang['common']['sortingtypes']['asc'], $lang['common']['priority'].' / '.$lang['common']['sortingtypes']['desc'])
					);
					if (intval(sm_settings('allow_alike_content'))==1)
						$f->AddCheckbox('no_alike_content', $lang['module_content']['dont_show_alike_content']);
					if (intval(sm_settings('content_use_path'))==1)
						$f->AddCheckbox('no_use_path', $lang['module_content']['no_use_path']);
					$f->AddSelect('can_view', $lang['can_view'], Array(0, 1, 2, 3), Array($lang['all_users'], $lang['logged_users'], $lang['power_users'], $lang['administrators']));
					$groups=get_groups_list();
					if (sm_count($groups)>0)
						{
							$f->Separator($lang['common']['groups_can_view']);
							for ($i = 0; $i < sm_count($groups); $i++)
								{
									$f->AddCheckbox('group_view_'.$groups[$i]['id'], $groups[$i]['title']);
								}
							$f->Separator($lang['common']['groups_can_modify']);
							for ($i = 0; $i < sm_count($groups); $i++)
								{
									$f->AddCheckbox('group_modify_'.$groups[$i]['id'], $groups[$i]['title']);
								}
						}
					if (sm_action('addctg'))
						sm_event('endcontentcategoryaddform');
					else
						sm_event('endcontentcategoryeditform', Array($info['id_category']));
					if (sm_action('editctg'))
						{
							$f->LoadValuesArray($info);
							if ($url=sm_fs_url('index.php?m=content&d=viewctg&ctgid='.$info['id_category'], true))
								$f->SetValue('url', $url);
							$selected_groups=get_array_groups($info['groups_view']);
							for ($i = 0; $i < sm_count($selected_groups); $i++)
								{
									$f->SetValue('group_view_'.$selected_groups[$i], 1);
								}
							$selected_groups=get_array_groups($info['groups_modify']);
							for ($i = 0; $i < sm_count($selected_groups); $i++)
								{
									$f->SetValue('group_modify_'.$selected_groups[$i], 1);
								}
						}
					if (!empty($sm['p']))
						$f->LoadAllValues($sm['p']);
					$ui->Add($f);
					if (sm_action('addctg'))
						sm_event('aftercontentcategoryaddform');
					else
						sm_event('aftercontentcategoryeditform', Array($info['id_category']));
					$ui->Output(true);
				}
			if (sm_action('postdeletectg') && intval(sm_getvars('ctgid'))!=1)
				{
					$id_ctg = intval(sm_getvars('ctgid'));
					if ($id_ctg!=1)
						{
							sm_saferemove('index.php?m=content&d=viewctg&ctgid='.intval($id_ctg));
							TQuery::ForTable(sm_table_prefix().'categories')
								->AddWhere('id_category', intval($id_ctg))
								->Remove();
							TQuery::ForTable(sm_table_prefix().'content')
								->Add('id_category_c', 1)
								->Update('id_category_c', intval($id_ctg));
							sm_notify($lang['operation_completed']);
							sm_redirect('index.php?m=content&d=listctg');
							sm_event('postdeletectgcontent', array($id_ctg));
						}
				}
			if (sm_action('listctg'))
				{
					sm_title($lang['module_content_name'].' - '.$lang['common']['categories']);
					add_path_modules();
					add_path($lang['module_content_name'], "index.php?m=content&d=admin");
					add_path_current();
					$m['ctg'] = siman_load_ctgs_content();
					sm_use('admintable');
					sm_use('admininterface');
					sm_use('adminbuttons');
					$ui = new UI();
					$t=new Grid('edit');
					$t->AddCol('title', $lang['common']['title'], '100%');
					$t->AddCol('search', '', '16', $lang['search'], '', 'search.gif');
					$t->AddEdit();
					$t->AddCol('html', '', '16', $lang['common']['edit'].' ('.$lang['common']['html'].')', '', 'edit_html.gif');
					$t->AddDelete();
					$t->AddCol('stick', '', '16', $lang["set_as_block"], '', 'stick.gif');
					$t->AddMenuInsert();
					for ($i = 0; $i < sm_count($m['ctg']); $i++)
						{
							$lev = '';
							for ($j = 1; $j < $m['ctg'][$i]['level']; $j++)
								{
									$lev .= '-';
								}
							$t->Label('title', $lev.$m['ctg'][$i]['title']);
							$t->URL('title', $m['ctg'][$i]['filename']);
							$t->URL('search', 'index.php?m=content&d=list&ctg='.$m['ctg'][$i]['id']);
							if ($m['ctg'][$i]['id'] != 1)
								$t->URL('delete', 'index.php?m=content&d=postdeletectg&ctgid='.$m['ctg'][$i]['id']);
							$t->URL('edit', 'index.php?m=content&d=editctg&ctgid='.$m['ctg'][$i]['id'].'&returnto='.urlencode(sm_this_url()));
							$t->URL('html', 'index.php?m=content&d=editctg&ctgid='.$m['ctg'][$i]['id'].'&exteditor=off'.'&returnto='.urlencode(sm_this_url()));
							$t->URL('tomenu', sm_tomenuurl($m['ctg'][$i]['title'], $m['ctg'][$i]['filename'], sm_this_url()));
							$t->URL('stick', sm_addblockurl($m['ctg'][$i]['title'], 'content', $m['ctg'][$i]['id'], 'rndctgview'));
							$t->NewRow();
						}
					$b=new Buttons();
					$b->AddButton('add', $lang['add_category'], 'index.php?m=content&d=addctg');
					$b->AddButton('addhtml', $lang['common']['add'].' ('.$lang['common']['html'].')', 'index.php?m=content&d=addctg&exteditor=off');
					$ui->AddButtons($b);
					$ui->AddGrid($t);
					$ui->AddButtons($b);
					$ui->Output(true);
				}
			if (sm_action('list'))
				{
					$ui=new UI();
					$f=new Form('index.php');
					$f->SetMethodGet();
					$f->AddHidden('m')->WithValue('content');
					$f->AddHidden('d')->WithValue('list');
					$f->AddHidden('search')->WithValue('yes');
					$ctgs=siman_load_ctgs_content();
					$v=Array();
					$l=Array();
					for ($i=0; $i<sm_count($ctgs); $i++)
						{
							$v[]=$ctgs[$i]['id'];
							$l[]=($ctgs[$i]['level']>1?str_repeat('- ', $ctgs[$i]['level']-1):'').$ctgs[$i]['title'];
						}
					$f->AddSelect('ctg', $lang['common']['category'], $v, $l);
					$f->SelectAddBeginVL('ctg', '', $lang['all_categories']);
					$f->AddSelect('showall', $lang['common']['show_all'], Array('', 'yes'), Array($lang['no'], $lang['yes']));
					$f->LoadValuesArray(sm_getvars());
					$f->SaveButton($lang['search']);
					$f->SetDOMID('content-search-form');
					if (empty(sm_getvars('ctg')) && empty(sm_getvars('showall')) && empty(sm_getvars('search')))
						$f->SetStyleGlobal('display:none;');
					$ui->Add($f);
					$b=new Buttons();
					$b->Button($lang['common']['add'], 'index.php?m=content&d=add&ctg='.intval(sm_getvars('ctg')));
					$b->Button($lang['common']['add'].' ('.$lang['common']['html'].')', 'index.php?m=content&d=add&exteditor=off&ctg='.intval(sm_getvars('ctg')));
					$b->AddToggle('searchswitch', $lang['search'], 'content-search-form');
					if (empty(sm_getvars('showall')))
						{
							$limit=sm_abs(sm_settings('admin_items_by_page'));
							$offset=sm_abs(sm_getvars('from'));
						}
					$ctg_id = intval(sm_getvars('ctg'));
					sm_title($lang['list_content']);
					add_path_modules();
					add_path($lang['module_content_name'], "index.php?m=content&d=admin");
					add_path($lang['list_content'], "index.php?m=content&d=list");
					$sql = "SELECT ".sm_table_prefix()."content.* FROM ".sm_table_prefix()."content";
					$sort = 0;
					if (!empty($ctg_id))
						{
							$sql .= " WHERE id_category_c = '$ctg_id'";
							for ($i = 0; $i < sm_count($ctgs); $i++)
								{
									if ($ctgs[$i]['id'] == $ctg_id)
										{
											$sort = $ctgs[$i]['sorting_category'];
											add_path($ctgs[$i]['title'], 'index.php?m=content&d=list&ctg='.$ctgs[$i]['id']);
											sm_title_append(' - '.$ctgs[$i]['title']);
										}
								}
						}
					if ($sort == 1)
						$sql .= " ORDER BY title_content DESC";
					elseif ($sort == 2)
						$sql .= " ORDER BY priority_content ASC";
					elseif ($sort == 3)
						$sql .= " ORDER BY priority_content DESC";
					else
						$sql .= " ORDER BY title_content ASC";
					if (empty(sm_getvars('showall')))
						{
							$sql.=" LIMIT ".intval($limit)." OFFSET ".intval($offset);
							$showall='';
						}
					else
						$showall='1';
					$t=new Grid('edit');
					$t->AddCol('title', $lang['common']['title'], '100%');
					$t->AddEdit();
					$t->AddCol('html', '', '16', $lang['common']['edit'].' ('.$lang['common']['html'].')', '', 'edit_html.gif');
					$t->AddDelete();
					$t->AddCol('stick', '', '16', $lang["set_as_block"], '', 'stick.gif');
					$t->AddMenuInsert();
					if ($sort == 2 || $sort == 3)
						{
							$t->AddCol('up', '', '16', $lang['up'], '', 'up.gif');
							$t->AddCol('down', '', '16', $lang['down'], '', 'down.gif');
						}
					$items = getsqlarray($sql);
					for ($i = 0; $i<sm_count($items); $i++)
						{
							$t->Label('title', $items[$i]['title_content']);
							$items[$i]['url']=sm_fs_url('index.php?m=content&d=view&cid='.$items[$i]['id_content']);
							$t->URL('title', $items[$i]['url'], true);
							$t->URL('edit', 'index.php?m=content&d=edit&cid='.$items[$i]['id_content'].'&returnto='.urlencode(sm_this_url()));
							$t->URL('html', 'index.php?m=content&d=edit&cid='.$items[$i]['id_content'].'&exteditor=off'.'&returnto='.urlencode(sm_this_url()));
							if ($items[$i]['id_content'] != 1)
								$t->URL('delete', 'index.php?m=content&d=postdelete&cid='.$items[$i]['id_content'].'&ctg='.$items[$i]['id_category_c'].'&returnto='.urlencode(sm_this_url()));
							$t->URL('tomenu', sm_tomenuurl($items[$i]['title_content'], $items[$i]['url'], sm_this_url()));
							$t->URL('stick', sm_addblockurl($items[$i]['title_content'], 'content', $items[$i]['id_content'], 'view', 'index.php?m=content&d=edit&cid='.$items[$i]['id_content']));
							if ($sort == 2 || $sort == 3)
								{
									if ($i>0)
										$t->URL('up', 'index.php?m=content&d=exchange&id1='.$items[$i]['id_content'].'&id2='.$items[$i-1]['id_content'].'&ctg='.$ctg_id.'&showall='.$showall);
									if ($i+1<sm_count($items))
										$t->URL('down', 'index.php?m=content&d=exchange&id1='.$items[$i]['id_content'].'&id2='.$items[$i+1]['id_content'].'&ctg='.$ctg_id.'&showall='.$showall);
								}
							$t->NewRow();
						}
					$ui->Add($b);
					$ui->Add($t);
					$ui->Add($b);
					if (empty(sm_getvars('showall')))
						{
							$sql = "SELECT count(*) FROM ".sm_table_prefix()."content";
							if (!empty($ctg_id)) $sql .= " WHERE id_category_c = ".intval($ctg_id);
							$ui->AddPagebarParams(intval(getsqlfield($sql)), $limit, $offset);
						}
					$ui->Output(true);
				}
			if (sm_action('exchange'))
				{
					$id1 = intval(sm_getvars('id1'));
					$id2 = intval(sm_getvars('id2'));
					$pr1 = getsqlfield("SELECT priority_content FROM ".sm_table_prefix()."content WHERE id_content=".intval($id1));
					$pr2 = getsqlfield("SELECT priority_content FROM ".sm_table_prefix()."content WHERE id_content=".intval($id2));
					if (!empty($pr1) || !empty($pr2))
						{
							execsql("UPDATE ".sm_table_prefix()."content SET priority_content=".intval($pr1)." WHERE id_content=".intval($id2));
							execsql("UPDATE ".sm_table_prefix()."content SET priority_content=".intval($pr2)." WHERE id_content=".intval($id1));
						}
					if (!empty(sm_getvars('returnto')))
						sm_redirect(sm_getvars('returnto'));
					else
						sm_redirect('index.php?m=content&d=list&ctg='.(intval(sm_getvars('ctg'))).'&showall='.(intval(sm_getvars('showall'))));
				}
		}
