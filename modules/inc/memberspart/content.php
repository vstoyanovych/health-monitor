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
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (SM::isLoggedIn())
		{
			if (!defined("CONTENT_MEMBERSPART_FUNCTIONS_DEFINED"))
				{
					function siman_get_available_categories()
						{
							global $sm;
							$categories = siman_load_ctgs_content(
								-1,
								convert_groups_to_sql($sm['u']['groups'], 'groups_modify')
							);
							return $categories;
						}
					function siman_is_allowed_to_add_content()
						{
							global $sm;
							if (SM::User()->Level()>=intval(sm_settings('content_editor_level')))
								return true;
							elseif (!empty($sm['u']['groups']))
								{
									$categories = siman_get_available_categories();
									if (sm_count($categories)>0)
										return true;
								}
							return false;
						}
					function siman_is_allowed_to_edit_content($id)
						{
							global $sm;
							if (SM::User()->Level()>=intval(sm_settings('content_editor_level')))
								return true;
							elseif (!empty($sm['u']['groups']))
								{
									$categories = siman_get_available_categories();
									if (sm_count($categories)>0)
										{
											$content=TQuery::ForTable(sm_table_prefix().'content')
												->AddWhere('id_content', intval($id))
												->Get();
											if (empty($content['id_content']))
												return false;
											for ($i = 0; $i < sm_count($categories); $i++)
												{
													if (intval($categories[$i]['id'])==intval($content['id_category_c']))
														return true;
												}
										}
								}
							return false;
						}
					define("CONTENT_MEMBERSPART_FUNCTIONS_DEFINED", 1);
				}


			if (sm_action('postadd') && siman_is_allowed_to_add_content() || sm_action('postedit') && siman_is_allowed_to_edit_content(intval(sm_getvars('id'))))
				{
					if (sm_action('postadd'))
						sm_event('beforepostaddcontent');
					else
						{
							$cid=intval(sm_getvars('id'));
							sm_event('beforeposteditcontent', array($cid));
						}
					if (empty(sm_postvars('title_content')) || empty(sm_postvars('id_category_c')))
						$error=$lang['messages']['fill_required_fields'];
					elseif (sm_action('postadd') && !empty(sm_postvars('url')) && sm_fs_exists(sm_postvars('url')))
						$error=$lang['messages']['seo_url_exists'];
					elseif (sm_action('postedit') && !empty(sm_postvars('url')) && sm_fs_exists(sm_postvars('url')) && sm_strcmp(sm_postvars('url'), sm_fs_url('index.php?m=content&d=view&cid='.intval(sm_getvars('id'))))!=0)
						$error=$lang['messages']['seo_url_exists'];
					if (empty($error))
						{
							if (sm_action('postadd'))
								sm_event('startpostaddcontent');
							else
								sm_event('startposteditcontent', array($cid));
							$q=new TQuery(sm_table_prefix().'content');
							$q->Add('id_category_c', intval(sm_postvars('id_category_c')));
							$q->Add('title_content', dbescape(sm_postvars('title_content')));
							if (intval(sm_settings('content_use_preview'))==1)
								$q->Add('preview_content', dbescape(sm_postvars('preview_content')));
							$q->Add('text_content', dbescape(sm_postvars('text_content')));
							$q->Add('type_content', intval(sm_postvars('type_content')));
							$q->Add('keywords_content', dbescape(sm_postvars('keywords_content')));
							$q->Add('description_content', dbescape(sm_postvars('description_content')));
							$q->Add('refuse_direct_show', intval(sm_postvars('refuse_direct_show')));
							$q->Add('disable_search', intval(sm_postvars('disable_search')));
							if (sm_action('postadd'))
								{
									$cid=$q->Insert();
									sm_set_metadata('content', $cid, 'author_id', SM::User()->ID());
									sm_set_metadata('content', $cid, 'time_created', time());
									TQuery::ForTable(sm_table_prefix().'content')
										->Add('priority_content', intval($cid))
										->Update('id_content', intval($cid));
								}
							else
								{
									$q->Update('id_content', intval($cid));
								}
							sm_set_metadata('content', $cid, 'main_template', sm_postvars('tplmain'));
							sm_set_metadata('content', $cid, 'content_template', sm_postvars('tplcontent'));
							sm_set_metadata('content', $cid, 'seo_title', sm_postvars('seo_title'));
							sm_set_metadata('content', $cid, 'last_updated_time', time());
							if (sm_settings('content_use_image') == 1)
								{
									if (sm_settings('image_generation_type') == 'static' && file_exists($_uplfilevars['userfile']['tmp_name']))
										{
											move_uploaded_file($_uplfilevars['userfile']['tmp_name'], SM::TemporaryFilesPath().'content'.$cid.'.jpg');
											sm_resizeimage(
												SM::TemporaryFilesPath().'content'.$cid.'.jpg',
												SM::FilesPath().'thumb/content'.$cid.'.jpg',
												sm_settings('content_image_preview_width'),
												sm_settings('content_image_preview_height'),
												0, 100, 1);
											sm_resizeimage(
												SM::TemporaryFilesPath().'content'.$cid.'.jpg',
												SM::FilesPath().'fullimg/content'.$cid.'.jpg',
												sm_settings('content_image_fulltext_width'),
												sm_settings('content_image_fulltext_height'),
												0, 100, 1);
											unlink(SM::TemporaryFilesPath().'content'.$cid.'.jpg');
										}
									else
										{
											siman_upload_image($cid, 'content');
										}
								}
							if (sm_action('postedit'))
								{
									$attachments=sm_get_attachments('content', $cid);
									for ($i = 0; $i<sm_count($attachments); $i++)
										{
											if (!empty(sm_postvars('delete_attachment_'.$attachments[$i]['id'])))
												{
													sm_delete_attachment(intval($attachments[$i]['id']));
													sm_event('postdeleteattachment', array(intval($attachments[$i]['id'])));
												}
										}
								}
							for ($i = 0; $i < intval(sm_settings('content_attachments_count')); $i++)
								{
									sm_upload_attachment('content', $cid, $_uplfilevars['attachment'.$i]);
								}
							if (!empty(sm_postvars('url')))
								sm_fs_update(sm_postvars('title_content'), 'index.php?m=content&d=view&cid='.intval($cid), sm_postvars('url'));
								//TODO remove url if empty
							if (sm_action('postadd'))
								sm_notify($lang['messages']['add_successful']);
							else
								sm_notify($lang['messages']['edit_successful']);
							if (sm_action('postadd'))
								sm_event('postaddcontent', array($cid));
							else
								sm_event('posteditcontent', array($cid));
							if (!empty(sm_getvars('returnto')))
								sm_redirect(sm_getvars('returnto'));
							else
								{
									if (SM::User()->Level() < 3)
										sm_redirect('index.php?m=content&d=viewctg&ctgid='.intval(sm_postvars('id_category_c')));
									else
										sm_redirect('index.php?m=content&d=list&ctg='.intval(sm_postvars('id_category_c')));
								}
						}
					else
						sm_set_action(Array('postadd'=>'add', 'postedit'=>'edit'));
				}
			if (sm_action('add') && siman_is_allowed_to_add_content() || sm_action('edit') && siman_is_allowed_to_edit_content(intval(sm_getvars('id'))))
				{
					if (SM::User()->Level()>=intval(sm_settings('content_editor_level')))
						$categories = siman_load_ctgs_content(-1);
					elseif (!empty($sm['u']['groups']))
						$categories = siman_get_available_categories();
					$use_ext_editor=sm_strcmp(sm_getvars('exteditor'), 'off')!=0;
					if (sm_action('add'))
						{
							sm_event('onaddcontent');
							sm_title($lang['common']['text'].' - '.$lang['common']['add']);
						}
					else
						{
							$cid=intval(sm_getvars('cid'));
							$content=TQuery::ForTable(sm_table_prefix().'content')
								->AddWhere('id_content', intval(sm_getvars('cid')))
								->Get();
							sm_event('oneditcontent', array($content['id_content']));
							sm_title($lang['common']['text'].' - '.$lang['common']['edit']);
						}
					sm_add_cssfile('mediainsert.css');
					sm_add_cssfile('contentaddedit.css');
					if (SM::isAdministrator())
						{
							add_path_modules();
							add_path($lang['module_content_name'], "index.php?m=content&d=admin");
							add_path($lang['list_content'], "index.php?m=content&d=list");
						}
					else
						add_path_home();
					add_path_current();
					$ui = new UI();
					$b=new Buttons();
					if (sm_getvars('exteditor')!='off')
						{
							$b->AddMessageBox('exteditoroff', $lang['ext']['editors']['switch_to_standard_editor'], sm_this_url(Array('exteditor'=>'off')), $lang['common']['are_you_sure']."? ".$lang['messages']['changes_will_be_lost']);
							$modal=new \SM\UI\ModalHelper();
							$modal->SetAJAXSource('index.php?m=media&d=editorinsert&theonepage=1');
							$b->AddButton('insertimgmodal', $lang['add_image'])
								->OnClick($modal->GetJSCode());
						}
					else
						$b->AddMessageBox('exteditoron', $lang['ext']['editors']['switch_to_ext_editor'], sm_this_url(Array('exteditor'=>'')), $lang['common']['are_you_sure']."? ".$lang['messages']['changes_will_be_lost']);
					if (!empty($error))
						$ui->NotificationError($error);
					if (sm_action('add'))
						sm_event('beforecontentaddform');
					else
						sm_event('beforecontenteditform', Array($cid));
					if (sm_action('add'))
						{
							$f = new Form('index.php?m='.sm_current_module().'&d=postadd&returnto='.urlencode(sm_getvars('returnto')));
							sm_event('startcontentaddform');
						}
					else
						{
							$f = new Form('index.php?m='.sm_current_module().'&d=postedit&id='.$content['id_content'].'&returnto='.urlencode(sm_getvars('returnto')));
							sm_event('startcontenteditform', Array($cid));
						}
					$v=Array();
					$l=Array();
					for ($i = 0; $i < sm_count($categories); $i++)
						{
							$v[]=$categories[$i]['id'];
							$l[]=$categories[$i]['title'];
						}
					$f->AddText('title_content', $lang['title'], true)
						->SetFocus();
					$f->AddSelect('id_category_c', $lang['common']['category'], $v, $l, true)
						->WithValue(intval(sm_getvars('ctg')));
					if (intval(sm_settings('content_use_image'))==1)
						{
							$f->AddFile('userfile', $lang['common']['image']);
						}
					if (!empty($sm['contenteditor']['controlbuttonsclass']))
						$b->ApplyClassnameForAll($sm['contenteditor']['controlbuttonsclass']);
					$f->InsertButtons($b);
					if ($use_ext_editor)
						$f->AddEditor('text_content', $lang['common']['text'], true);
					else
						$f->AddTextarea('text_content', $lang['common']['text'], true);
					$f->MergeColumns('text_content');
					if (intval(sm_settings('content_use_preview'))==1)
						{
							if ($use_ext_editor)
								{
									$f->AddEditor('preview_content', $lang['common']['preview']);
									$f->SetFieldAttribute('preview_content', 'style', ';');//TinyMCE temporary fix
								}
							else
								$f->AddTextarea('preview_content', $lang['common']['preview']);
							$f->MergeColumns('preview_content');
						}
					if ($use_ext_editor)
						$f->AddHidden('type_content', 1);
					else
						$f->AddSelect('type_content', $lang['type_content'], Array(0, 1, 2), Array($lang['type_content_simple_text'], $lang['type_content_HTML'], $lang['type_content_simple_text'].' / Header: plain/text'));
					$f->Separator($lang['common']['seo']);
					$f->AddText('url', $lang['url'])
						->WithTooltip($lang['common']['leave_empty_for_default']);
					if (sm_action('edit'))
						$f->WithValue(sm_fs_url('index.php?m=content&d=view&cid='.intval($content['id_content']), true));
					$f->AddText('seo_title', $lang['common']['seo_title'])
						->WithTooltip($lang['common']['leave_empty_for_default']);
					$f->AddText('keywords_content', $lang['common']['seo_keywords']);
					$f->AddTextarea('description_content', $lang['common']['seo_description']);
					$f->Separator($lang['common']['additional_options']);
					$f->AddCheckbox('refuse_direct_show', $lang['module_content']['refuse_direct_show'])
						->LabelAfterControl();
					$f->AddCheckbox('disable_search', $lang['common']['disable_search'])
						->LabelAfterControl();
					if (count(sm_alternative_tpl_list_main())>0)
						{
							$v=[''];
							$l=[$lang['common']['default']];
							foreach (sm_alternative_tpl_list_main() as $tmp)
								{
									$v[]=$tmp['tpl'];
									$l[]=$tmp['name'];
								}
							$f->AddSelect('tplmain', $lang['common']['template'].' ('.$lang['common']['site'].')', $v, $l);
						}
					if (count(sm_alternative_tpl_list_content())>0)
						{
							$v=[''];
							$l=[$lang['common']['default']];
							foreach (sm_alternative_tpl_list_content() as $tmp)
								{
									$v[]=$tmp['tpl'];
									$l[]=$tmp['name'];
								}
							$f->AddSelect('tplcontent', $lang['common']['template'].' ('.$lang['common']['page'].')', $v, $l);
						}
					if (intval(sm_settings('content_attachments_count'))>0)
						{
							$f->Separator($lang['common']['attachments']);
							if (sm_action('edit'))
								$attachments=sm_get_attachments('content', $content['id_content']);
							else
								$attachments=Array();
							for ($i = 0; $i<intval(sm_settings('content_attachments_count')); $i++)
								{
									if ($i<sm_count($attachments))
										$f->AddCheckbox('delete_attachment_'.$attachments[$i]['id'], $lang['number_short'].($i+1).'. '.$lang['delete'].' - '.$attachments[$i]['filename'])
											->LabelAfterControl();
									else
										$f->AddFile('attachment'.$i, $lang['number_short'].($i+1));
								}
						}
					if (sm_action('add'))
						sm_event('endcontentaddform');
					else
						sm_event('endcontenteditform', Array($cid));
					if (sm_action('edit'))
						{
							$f->LoadValuesArray($content);
							$tmp=sm_load_metadata('content', intval($content['id_content']));
							$f->SetValue('seo_title', sm_get_array_value($tmp, 'seo_title'));
							$f->SetValue('tplmain', sm_get_array_value($tmp, 'main_template'));
							$f->SetValue('tplcontent', sm_get_array_value($tmp, 'content_template'));
						}
					$f->LoadValuesArray(sm_postvars());
					$ui->Add($f);
					if (sm_action('add'))
						sm_event('aftercontentaddform');
					else
						sm_event('aftercontenteditform', Array($cid));
					$ui->Output(true);
				}
			if (sm_action('delete') && (SM::User()->Level()>=intval(sm_settings('content_editor_level')) || !empty($sm['u']['groups'])))
				{
					$candelete=false;
					if (SM::User()->Level()<intval(sm_settings('content_editor_level')))
						$extsql = convert_groups_to_sql($sm['u']['groups'], 'groups_modify');
					else
						{
							$extsql = '';
							$candelete = true;
						}
					$m['ctgid'] = siman_load_ctgs_content(-1, $extsql);
					if (sm_count($m['ctgid']) > 0 && $candelete != 1)
						{
							$sql = "SELECT * FROM ".sm_table_prefix()."content  LEFT JOIN ".sm_table_prefix()."categories ON ".sm_table_prefix()."content.id_category_c=".sm_table_prefix()."categories.id_category  WHERE id_content='".intval(sm_getvars('cid'))."'";
							$sql .= " AND (".$extsql.')';
							$result = execsql($sql);
							while ($row = database_fetch_object($result))
								{
									$candelete = true;
								}
						}
					if ($candelete)
						{
							sm_title(sm_lang('delete').' - '.sm_lang('module_content_name'));
							$ui=new UI();
							$ui->p(sm_lang('module_content.really_want_delete_text'));
							$b=new Buttons();
							if (SM::User()->Level() < 3)
								$b->Button(sm_lang('no'), 'index.php?m=content&d=viewctg&ctgid='.intval(sm_getvars('ctg')));
							else
								$b->Button(sm_lang('no'), 'index.php?m=content&d=list&ctg='.intval(sm_getvars('ctg')));
							$b->Button(sm_lang('yes'), 'index.php?m=content&d=postdelete&cid='.intval(sm_getvars('cid')).'&ctg='.intval(sm_getvars('ctg')));
							$ui->Add($b);
							$ui->Output(true);
						}
				}
			if (sm_action('postdelete') && (SM::User()->Level()>=intval(sm_settings('content_editor_level')) || !empty($sm['u']['groups'])))
				{
					$candelete=false;
					if (SM::User()->Level()<intval(sm_settings('content_editor_level')))
						$extsql = convert_groups_to_sql($sm['u']['groups'], 'groups_modify');
					else
						{
							$extsql = '';
							$candelete=true;
						}
					$m['ctgid'] = siman_load_ctgs_content(-1, $extsql);
					if (sm_count($m['ctgid']) > 0 && $candelete != 1)
						{
							$sql = "SELECT * FROM ".sm_table_prefix()."content  LEFT JOIN ".sm_table_prefix()."categories ON ".sm_table_prefix()."content.id_category_c=".sm_table_prefix()."categories.id_category  WHERE id_content='".intval(sm_getvars('cid'))."'";
							$sql .= " AND (".$extsql.')';
							$result = execsql($sql);
							while ($row = database_fetch_object($result))
								{
									$candelete=true;
								}
						}
					if ($candelete)
						{
							sm_title(sm_lang('delete').' - '.sm_lang('module_content_name'));
							sm_template('content');
							execsql("DELETE FROM ".sm_table_prefix()."content WHERE id_content=".intval(sm_getvars('cid'))." AND id_content<>1");
							sm_saferemove('index.php?m=content&d=view&cid='.intval(sm_getvars('cid')));
							sm_delete_attachments('content', intval(sm_getvars('cid')));
							if (file_exists(SM::FilesPath().'thumb/content'.intval(sm_getvars('cid')).'.jpg'))
								unlink(SM::FilesPath().'thumb/content'.intval(sm_getvars('cid')).'.jpg');
							if (file_exists(SM::FilesPath().'fullimg/content'.intval(sm_getvars('cid')).'.jpg'))
								unlink(SM::FilesPath().'fullimg/content'.intval(sm_getvars('cid')).'.jpg');
							if (file_exists(SM::FilesPath().'img/content'.intval(sm_getvars('cid')).'.jpg'))
								unlink(SM::FilesPath().'img/content'.intval(sm_getvars('cid')).'.jpg');
							sm_notify($lang['messages']['delete_successful']);
							if (!empty(sm_getvars('returnto')))
								sm_redirect(sm_getvars('returnto'));
							else
								{
									if (SM::User()->Level() < 3)
										sm_redirect('index.php?m=content&d=viewctg&ctgid='.intval(sm_getvars('ctg')));
									else
										sm_redirect('index.php?m=content&d=list&ctg='.intval(sm_getvars('ctg')));
								}
							sm_event('postdeletecontent', array(intval(sm_getvars('cid'))));
						}
				}

			if (SM::User()->Level() > 2)
				include('modules/inc/adminpart/content.php');
		}
