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
	use SM\UI\ModalHelper;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (SM::isLoggedIn())
		{
			if (!defined("NEWS_MEMBERSPART_FUNCTIONS_DEFINED"))
				{
					function siman_get_available_categories_news()
						{
							global $sm;
							$q = new TQuery(sm_table_prefix().'categories_news');
							if (SM::User()->Level() < intval(sm_settings('news_editor_level')))
								$q->Add('('.convert_groups_to_sql($sm['u']['groups'], 'groups_modify').')');
							$q->OrderBy('title_category');
							$q->Select();
							$categories=Array();
							for ($i = 0; $i < $q->Count(); $i++)
								{
									$categories[$i]['id']=$q->items[$i]['id_category'];
									$categories[$i]['title']=$q->items[$i]['title_category'];
								}
							return $categories;
						}

					function siman_is_allowed_to_add_news()
						{
							global $sm;
							if (SM::User()->Level() >= intval(sm_settings('news_editor_level')))
								return true;
							elseif (!empty($sm['u']['groups']))
								{
									$categories = siman_get_available_categories_news();
									if (sm_count($categories) > 0)
										return true;
								}
							return false;
						}

					function siman_is_allowed_to_edit_news($id)
						{
							global $sm;
							if (SM::User()->Level() >= intval(sm_settings('news_editor_level')))
								return true;
							elseif (!empty($sm['u']['groups']))
								{
									$categories = siman_get_available_categories_news();
									if (sm_count($categories) > 0)
										{
											$content = TQuery::ForTable(sm_table_prefix().'news')
												->AddWhere('id_news', intval($id))
												->Get();
											if (empty($content['id_news']))
												return false;
											for ($i = 0; $i < sm_count($categories); $i++)
												{
													if (intval($categories[$i]['id']) == intval($content['id_category_n']))
														return true;
												}
										}
								}
							return false;
						}

					define("NEWS_MEMBERSPART_FUNCTIONS_DEFINED", 1);
				}

			if (sm_action('delete') && (SM::User()->Level() >= intval(sm_settings('news_editor_level')) || !empty($userinfo['groups'])))
				{
					$candelete = 0;
					if (SM::User()->Level() >= intval(sm_settings('news_editor_level')))
						{
							$candelete = 1;
						}
					elseif (!empty($userinfo['groups']))
						{
							$extsql = convert_groups_to_sql($userinfo['groups'], 'groups_modify');
							$sql = "SELECT ".sm_table_prefix()."news.*, ".sm_table_prefix()."categories_news.* FROM ".sm_table_prefix()."news, ".sm_table_prefix()."categories_news WHERE ".sm_table_prefix()."news.id_category_n=".sm_table_prefix()."categories_news.id_category AND id_news='".intval(sm_getvars("nid"))."'";
							$sql .= ' AND '.$extsql;
							$result = execsql($sql);
							while ($row = database_fetch_object($result))
								{
									$candelete = 1;
								}
						}
					if ($candelete == 1)
						{
							sm_title(sm_lang('delete').' - '.sm_lang('module_news_name'));
							$ui=new UI();
							$ui->p($lang['really_want_delete_news']);
							$b=new Buttons();
							if (SM::isAdministrator())
								$b->Button($lang['no'], 'index.php?m=news&d=list');
							else
								$b->Button($lang['no'], 'index.php?m=news&d=view&nid='.intval(sm_getvars('nid')));
							$b->Button($lang['yes'], 'index.php?m=news&d=postdelete&nid='.intval(sm_getvars('nid')).'&ctg='.intval(sm_getvars('ctg')));
							$ui->Add($b);
							$ui->Output(true);
						}
				}

			if (sm_action('postdelete') && (SM::User()->Level() >= intval(sm_settings('news_editor_level')) || !empty($userinfo['groups'])))
				{
					$candelete = 0;
					if (SM::User()->Level() >= intval(sm_settings('news_editor_level')))
						{
							$candelete = 1;
						}
					elseif (!empty($userinfo['groups']))
						{
							$extsql = convert_groups_to_sql($userinfo['groups'], 'groups_modify');
							$sql = "SELECT ".sm_table_prefix()."news.*, ".sm_table_prefix()."categories_news.* FROM ".sm_table_prefix()."news, ".sm_table_prefix()."categories_news WHERE ".sm_table_prefix()."news.id_category_n=".sm_table_prefix()."categories_news.id_category AND id_news='".intval(sm_getvars("nid"))."'";
							$sql .= ' AND '.$extsql;
							$result = execsql($sql);
							while ($row = database_fetch_object($result))
								{
									$candelete = 1;
								}
						}
					if ($candelete == 1)
						{
							sm_title(sm_lang('delete').' - '.sm_lang('module_news_name'));
							sm_template('news');
							$id_news = intval(sm_getvars("nid"));
							$sql = "DELETE FROM ".sm_table_prefix()."news WHERE id_news=".intval($id_news);
							$result = execsql($sql);
							sm_saferemove('index.php?m=news&d=view&nid='.$id_news);
							sm_delete_attachments('news', intval($id_news));
							if (file_exists(SM::FilesPath().'thumb/news'.$id_news.'.jpg'))
								unlink(SM::FilesPath().'thumb/news'.$id_news.'.jpg');
							if (file_exists(SM::FilesPath().'fullimg/news'.$id_news.'.jpg'))
								unlink(SM::FilesPath().'fullimg/news'.$id_news.'.jpg');
							if (file_exists(SM::FilesPath().'img/news'.$id_news.'.jpg'))
								unlink(SM::FilesPath().'img/news'.$id_news.'.jpg');
							sm_notify($lang['delete_news_successful']);
							sm_event('onnewsdeleted', array($id_news));
							if (SM::isAdministrator())
								sm_redirect('index.php?m=news&d=list&ctg='.intval(sm_getvars('ctg')));
							else
								sm_redirect('index.php?m=news&d=listnews&ctg='.intval(sm_getvars('ctg')));
						}
				}

			if (sm_action('postadd') && siman_is_allowed_to_add_news() || sm_action('postedit') && siman_is_allowed_to_edit_news(intval(sm_getvars('id'))))
				{
					if (sm_action('postadd'))
						sm_event('beforepostaddnews');
					else
						{
							$id_news=intval(sm_getvars('id'));
							sm_event('beforeposteditnews', array($id_news));
						}
					$timestamp=@mktime(intval(sm_postvars('time_hours')), intval(sm_postvars('time_minutes')), 0, intval(sm_postvars('date_month')), intval(sm_postvars('date_day')), intval(sm_postvars('date_year')));
					if (empty(sm_postvars('title_news')) || empty(sm_postvars('id_category')))
						$error=$lang['messages']['fill_required_fields'];
					elseif (sm_action('postadd') && !empty(sm_postvars('url')) && sm_fs_exists(sm_postvars('url')))
						$error=$lang['messages']['seo_url_exists'];
					elseif (sm_action('postedit') && !empty(sm_postvars('url')) && sm_fs_exists(sm_postvars('url')) && sm_strcmp(sm_postvars('url'), sm_fs_url('index.php?m=news&d=view&nid='.intval(sm_getvars('id'))))!=0)
						$error=$lang['messages']['seo_url_exists'];
					elseif ($timestamp===false || $timestamp==-1)
						$error=$lang['messages']['wrong_date'];
					if (empty($error))
						{
							if (sm_action('postadd'))
								sm_event('startpostaddnews');
							else
								sm_event('startposteditnews', array($id_news));
							$q=new TQuery(sm_table_prefix().'news');
							$q->Add('id_category_n', intval(sm_postvars('id_category')));
							if (sm_action('postadd'))
								$q->Add('id_author_news', SM::User()->ID());
							$q->Add('img_copyright_news', dbescape(sm_postvars('img_copyright_news')));
							$q->Add('date_news', intval($timestamp));
							$q->Add('title_news', dbescape(sm_postvars('title_news')));
							if (intval(sm_settings('news_use_preview'))==1)
								$q->Add('preview_news', dbescape(sm_postvars('preview_news')));
							$q->Add('text_news', dbescape(sm_postvars('text_news')));
							$q->Add('type_news', intval(sm_postvars('type_news')));
							$q->Add('keywords_news', dbescape(sm_postvars('keywords_news')));
							$q->Add('description_news', dbescape(sm_postvars('description_news')));
							$q->Add('disable_search', intval(sm_postvars('disable_search')));
							if (sm_action('postadd'))
								{
									$id_news=$q->Insert();
									sm_set_metadata('news', $id_news, 'author_id', SM::User()->ID());
									sm_set_metadata('news', $id_news, 'time_created', time());
								}
							else
								{
									$q->Update('id_news', intval($id_news));
								}
							$item = TQuery::ForTable(sm_table_prefix().'news')
								->AddWhere('id_news', intval($id_news))
								->Get();
							sm_set_metadata('news', $id_news, 'last_updated_time', time());
							sm_set_metadata('news', $id_news, 'news_template', sm_postvars('tplnews'));
							sm_set_metadata('news', $id_news, 'seo_title', sm_postvars('seo_title'));
							if (sm_settings('news_use_image') == 1)
								{
									if (sm_settings('image_generation_type') == 'static' && file_exists($_uplfilevars['userfile']['tmp_name']))
										{
											move_uploaded_file($_uplfilevars['userfile']['tmp_name'], SM::TemporaryFilesPath().'news'.$id_news.'.jpg');
											sm_resizeimage(
												SM::TemporaryFilesPath().'news'.$id_news.'.jpg',
												SM::FilesPath().'thumb/news'.$id_news.'.jpg',
												sm_settings('news_image_preview_width'),
												sm_settings('news_image_preview_height'),
												0, 100, 1);
											sm_resizeimage(
												SM::TemporaryFilesPath().'news'.$id_news.'.jpg',
												SM::FilesPath().'fullimg/news'.$id_news.'.jpg',
												sm_settings('news_image_fulltext_width'),
												sm_settings('news_image_fulltext_height'),
												0, 100, 1);
											unlink(SM::TemporaryFilesPath().'news'.$id_news.'.jpg');
										}
									else
										{
											siman_upload_image($id_news, 'news');
										}
								}
							if (sm_action('postedit'))
								{
									$attachments=sm_get_attachments('news', $id_news);
									for ($i = 0; $i<sm_count($attachments); $i++)
										{
											if (!empty(sm_postvars('delete_attachment_'.$attachments[$i]['id'])))
												{
													sm_delete_attachment(intval($attachments[$i]['id']));
													sm_event('postdeleteattachment', array(intval($attachments[$i]['id'])));
												}
										}
								}
							for ($i = 0; $i < intval(sm_settings('news_attachments_count')); $i++)
								{
									sm_upload_attachment('news', $id_news, $_uplfilevars['attachment'.$i]);
								}
							if (!empty(sm_postvars('url')))
								sm_fs_update(sm_postvars('title_news'), 'index.php?m=news&d=view&nid='.intval($id_news), sm_postvars('url'));
							//TODO remove url if empty
							if (sm_action('postadd'))
								sm_notify($lang['messages']['add_successful']);
							else
								sm_notify($lang['messages']['edit_successful']);
							if (sm_action('postadd'))
								{
									sm_event('postaddnews', array($id_news));
									sm_notify($lang['add_news_successful']);
								}
							else
								{
									sm_event('posteditnews', array($id_news));
									sm_notify($lang['edit_news_successful']);
								}
							if (!empty(sm_getvars('returnto')))
								sm_redirect(sm_getvars('returnto'));
							else
								{
									if (SM::User()->Level() < 3)
										sm_redirect('index.php?m=news&d=listnews&ctg='.intval(sm_postvars('id_category')));
									else
										sm_redirect('index.php?m=news&d=list&ctg='.intval(sm_postvars('id_category')));
								}
						}
					else
						sm_set_action(Array('postadd'=>'add', 'postedit'=>'edit'));
				}
			if (sm_action('add') && siman_is_allowed_to_add_news() || sm_action('edit') && siman_is_allowed_to_edit_news(intval(sm_getvars('id'))))
				{
					if (!isset($cid))
						$cid=0;
					if (sm_action('add'))
						{
							sm_event('onaddnews');
							sm_title($lang['news'].' - '.$lang['common']['add']);
						}
					else
						{
							$item = TQuery::ForTable(sm_table_prefix().'news')
								->AddWhere('id_news', intval(sm_getvars('nid')))
								->Get();
							sm_event('oneditnews', array($item['id_news']));
							sm_title($lang['news'].' - '.$lang['common']['edit']);
						}
					sm_add_cssfile('mediainsert.css');
					sm_add_cssfile('newsaddedit.css');
					if (SM::isAdministrator())
						{
							add_path_modules();
							add_path($lang['module_news']['module_news_name'], "index.php?m=news&d=admin");
							add_path($lang['module_news']['list_news'], "index.php?m=news&d=list");
						}
					else
						add_path_home();
					add_path_current();
					$ui = new UI();
					$b = new Buttons();
					if (sm_getvars('exteditor') != 'off')
						{
							$b->AddMessageBox('exteditoroff', $lang['ext']['editors']['switch_to_standard_editor'], sm_this_url(Array('exteditor' => 'off')), $lang['common']['are_you_sure']."? ".$lang['messages']['changes_will_be_lost']);
							$modal = new ModalHelper();
							$modal->SetAJAXSource('index.php?m=media&d=editorinsert&theonepage=1');
							$b->AddButton('insertimgmodal', $lang['add_image'])
								->OnClick($modal->GetJSCode());
							$use_ext_editor=true;
						}
					else
						{
							$b->AddMessageBox('exteditoron', $lang['ext']['editors']['switch_to_ext_editor'], sm_this_url(Array('exteditor' => '')), $lang['common']['are_you_sure']."? ".$lang['messages']['changes_will_be_lost']);
							$use_ext_editor=false;
						}
					if (!empty($error))
						$ui->NotificationError($error);
					if (sm_action('add'))
						sm_event('beforenewsaddform');
					else
						sm_event('beforenewseditform', Array($cid));
					if (sm_action('add'))
						{
							$f = new Form('index.php?m='.sm_current_module().'&d=postadd&returnto='.urlencode(sm_getvars('returnto')));
							sm_event('startnewsaddform');
						}
					else
						{
							$item['url'] = sm_fs_url('index.php?m=news&d=view&nid='.$item['id_news'], true);
							$f = new Form('index.php?m='.sm_current_module().'&d=postedit&id='.$item['id_news'].'&returnto='.urlencode(sm_getvars('returnto')));
							sm_event('startnewseditform', Array($cid));
						}
					$f->AddText('title_news', $lang['common']['title'])
						->SetFocus();
					$categories=siman_get_available_categories_news();
					$categories_v=Array();
					$categories_l=Array();
					for ($i = 0; $i < sm_count($categories); $i++)
						{
							$categories_v[]=$categories[$i]['id'];
							$categories_l[]=$categories[$i]['title'];
						}
					$f->AddSelectVL('id_category', $lang['common']['category'], $categories_v, $categories_l);
					if (intval(sm_settings('news_use_image')) == 1)
						{
							$f->AddFile('userfile', $lang['common']['image']);
							$f->AddText('img_copyright_news', $lang['common']['copyright'].' ('.$lang['common']['image'].')');
						}
					//-- Date and time begin -------
					$years = Array();
					for ($i = 2006; $i <= intval(date('Y') + 10); $i++)
						{
							$years[] = $i;
						}
					$days = Array();
					for ($i = 1; $i <= 31; $i++)
						{
							$days[] = $i;
						}
					$months_v = Array();
					$months_l = Array();
					for ($i = 1; $i <= 12; $i++)
						{
							$months_v[] = $i;
							$months_l[] = $lang['month_'.$i];
						}
					$f->AddSelect('date_day', $lang['common']['date'], $days);
					$f->HideEncloser();
					$f->AddSelectVL('date_month', $lang['common']['date'], $months_v, $months_l);
					$f->HideDefinition();
					$f->HideEncloser();
					$f->AddSelect('date_year', $lang['common']['date'], $years);
					$f->HideDefinition();
					if (intval(sm_settings('news_use_time')) == 1)
						{
							$hrs = Array();
							for ($i = 0; $i < 24; $i++)
								{
									$hrs[] = ($i < 10 ? '0' : '').$i;
								}
							$min = Array();
							for ($i = 0; $i < 60; $i++)
								{
									$min[] = ($i < 10 ? '0' : '').$i;
								}
							$f->HideEncloser();
							$f->AddSelect('time_hours', $lang['common']['date'], $hrs);
							$f->SetFieldBeginText('time_hours', $lang['common']['time']);
							$f->HideDefinition();
							$f->HideEncloser();
							$f->AddSelect('time_minutes', $lang['common']['date'], $min);
							$f->HideDefinition();
						}
					//-- Date and time end -------
					//-- Editors begin -------
					if (!empty($sm['contenteditor']['controlbuttonsclass']))
						$b->ApplyClassnameForAll($sm['contenteditor']['controlbuttonsclass']);
					$f->InsertButtons($b);
					if ($use_ext_editor)
						$f->AddEditor('text_news', $lang['common']['text'], true);
					else
						$f->AddTextarea('text_news', $lang['common']['text'], true);
					$f->MergeColumns('text_news');
					if (intval(sm_settings('news_use_preview')) == 1)
						{
							if ($use_ext_editor)
								{
									$f->AddEditor('preview_news', $lang['common']['preview']);
									$f->SetFieldAttribute('preview_news', 'style', ';');//TinyMCE temporary fix
								}
							else
								$f->AddTextarea('preview_news', $lang['common']['preview']);
							$f->MergeColumns('preview_news');
						}
					if ($use_ext_editor)
						$f->AddHidden('type_news', 1);
					else
						$f->AddSelectVL('type_news', $lang['type_content'], Array(0, 1), Array($lang['type_content_simple_text'], $lang['type_content_HTML']));
					//-- Editors end -------
					$f->Separator($lang['common']['seo']);
					$f->AddText('url', $lang['url'])
						->WithTooltip($lang['common']['leave_empty_for_default']);
					if (sm_action('edit'))
						$f->WithValue(sm_fs_url('index.php?m=news&d=view&nid='.intval($item['id_news']), true));
					$f->AddText('seo_title', $lang['common']['seo_title'])
						->WithTooltip($lang['common']['leave_empty_for_default']);
					$f->AddText('keywords_news', $lang['common']['seo_keywords']);
					$f->AddTextarea('description_news', $lang['common']['seo_description']);
					$f->Separator($lang['common']['additional_options']);
					$f->AddCheckbox('disable_search', $lang['common']['disable_search'])
						->LabelAfterControl();
					if (!empty($sm['themeinfo']['alttpl']['news']) && sm_count($sm['themeinfo']['alttpl']['news']) > 0)
						{
							$v = Array('');
							$l = Array($lang['common']['default']);
							for ($i = 0; $i < sm_count($sm['themeinfo']['alttpl']['news']); $i++)
								{
									$v[] = $sm['themeinfo']['alttpl']['news'][$i]['tpl'];
									$l[] = $sm['themeinfo']['alttpl']['news'][$i]['name'];
								}
							$f->AddSelect('tplnews', $lang['common']['template'], $v, $l);
						}
					if (intval(sm_settings('news_attachments_count')) > 0)
						{
							$f->Separator($lang['common']['attachments']);
							if (sm_action('edit'))
								$attachments = sm_get_attachments('news', $item['id_news']);
							else
								$attachments = [];
							for ($i = 0; $i < intval(sm_settings('news_attachments_count')); $i++)
								{
									if ($i < sm_count($attachments))
										$f->AddCheckbox('delete_attachment_'.$attachments[$i]['id'], $lang['number_short'].($i + 1).'. '.$lang['delete'].' - '.$attachments[$i]['filename'])
											->LabelAfterControl();
									else
										$f->AddFile('attachment'.$i, $lang['number_short'].($i + 1));
								}
						}
					//-------------------------------
					if (sm_action('add'))
						sm_event('endnewsaddform');
					else
						sm_event('endnewseditform', Array($cid));
					if (sm_action('add'))
						{
							$m['type_news'] = sm_settings('default_news_text_style');
							$f->SetValue('id_category', intval(sm_getvars('ctg')));
							$f->SetValue('date_day', intval(date('d')));
							$f->SetValue('date_month', intval(date('m')));
							$f->SetValue('date_year', intval(date('Y')));
							if (intval(sm_settings('news_use_time')) == 1)
								{
									$f->SetValue('time_hours', date('H'));
									$f->SetValue('time_minutes', date('i'));
								}
							if (!$use_ext_editor)
								$f->SetValue('type_news', intval(sm_settings('default_news_text_style')));
						}
					else
						{
							$f->LoadValuesArray($item);
							$tmp = sm_load_metadata('news', intval($item['id_news']));
							$f->SetValue('id_category', $item['id_category_n']);
							if (!empty($tmp['seo_title']))
								$f->SetValue('seo_title', $tmp['seo_title']);
							if (!empty($tmp['news_template']))
								$f->SetValue('tplnews', $tmp['news_template']);
							$f->SetValue('url', $item['url']);
							$f->SetValue('date_day', intval(date('d', $item['date_news'])));
							$f->SetValue('date_month', intval(date('m', $item['date_news'])));
							$f->SetValue('date_year', intval(date('Y', $item['date_news'])));
							if (intval(sm_settings('news_use_time')) == 1)
								{
									$f->SetValue('time_hours', date('H', $item['date_news']));
									$f->SetValue('time_minutes', date('i', $item['date_news']));
								}
						}
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					if (sm_action('add'))
						sm_event('afternewsaddform');
					else
						sm_event('afternewseditform', Array($item['id_news']));
					$ui->Output(true);
				}
		}

	if (SM::isAdministrator())
		include('modules/inc/adminpart/news.php');
	