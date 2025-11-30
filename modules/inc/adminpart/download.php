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
	use SM\UI\Navigation;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	/** @var string[]|string[][]|string[][][] $lang */
	if (SM::isAdministrator() || (intval(sm_settings('perm_downloads_management_level'))>0 && sm_settings('perm_downloads_management_level')<=SM::User()->Level()))
		{
			sm_add_cssfile('stylesheetsadmin.css');
			if (sm_action('deleteattachment'))
				{
					sm_title($lang['common']['delete']);
					$ui=new UI();
					$ui->p($lang['module_download']['really_want_delete_file']);
					$b=new Buttons();
					$b->Button($lang['no'], 'index.php?m=download');
					$b->Button($lang['yes'], 'index.php?m=download&d=postdeleteattachment&id='.intval(sm_getvars("id")).'&returnto='.urlencode(sm_getvars('returnto')));
					$ui->Add($b);
					$ui->Output(true);
				}
			if (sm_action('postdeleteattachment'))
				{
					sm_delete_attachment(intval(sm_getvars('id')));
					sm_event('postdeleteattachment', array(intval(sm_getvars('id'))));
					if (!empty(sm_getvars('returnto')))
						sm_redirect(sm_getvars('returnto'));
					else
						sm_redirect('index.php?m=download&d=list');
				}
			if (sm_action('postdelete'))
				{
					$q=new TQuery(sm_table_prefix().'downloads');
					$q->Add('id_download', intval(sm_getvars('id')));
					$info=$q->Get();
					$filename=SM::FilesPath().'download/'.basename($info['file_download']);
					$q->Remove();
					if (file_exists($filename))
						unlink($filename);
					sm_saferemove($filename);
					//sm_notify($lang['module_download']['delete_file_successful']);
					if (!empty(sm_getvars('returnto')))
						sm_redirect(sm_getvars('returnto'));
					else
						sm_redirect('index.php?m=download&d=list');
				}
			if (sm_action('postadd'))
				{
					$descr = dbescape(sm_postvars('p_shortdesc'));
					$fs = $_uplfilevars['userfile']['tmp_name'];
					if (empty(sm_postvars('optional_name')))
						{
							$fd = basename($_uplfilevars['userfile']['name']);
						}
					else
						{
							$fd = basename(sm_postvars('optional_name'));
						}
					$fd = SM::FilesPath().'download/'.$fd;
					if (empty($fs))
						{
							$error = $lang['messages']['fill_required_fields'];
							sm_set_action('add');
						}
					elseif (!sm_is_allowed_to_upload($fd))
						{
							$error = $lang['error_file_upload_message'];
							sm_set_action('upload');
						}
					elseif (file_exists($fd))
						{
							$error = $lang['module_download']['file_already_exists'];
							sm_set_action('add');
						}
					elseif (!move_uploaded_file($fs, $fd))
						{
							$error=$lang['error_file_upload_message'];
							sm_set_action('add');
						}
					else
						{
							$q=new TQuery(sm_table_prefix().'downloads');
							$q->Add('file_download', dbescape(basename($fd)));
							$q->Add('description_download', dbescape(sm_postvars('description_download')));
							$q->Add('userlevel_download', intval(sm_postvars('userlevel_download')));
							$q->Insert();
							sm_notify($lang['operation_completed']);
							if (!empty(sm_getvars('returnto')))
								sm_redirect(sm_getvars('returnto'));
							else
								sm_redirect('index.php?m=download&d=list');
						}
				}
			if (sm_action('postupload'))
				{
					$q = new TQuery(sm_table_prefix().'downloads');
					$q->Add('id_download', intval(sm_getvars('id')));
					$info = $q->Get();
					if (!empty($info['id_download']))
						{
							$fs = $_uplfilevars['userfile']['tmp_name'];
							$fd = SM::FilesPath().'download/'.$info['file_download'];
							if (empty($fs))
								{
									$error = $lang["message_set_all_fields"];
									sm_set_action('upload');
								}
							elseif (!sm_is_allowed_to_upload($fd))
								{
									$error = $lang['error_file_upload_message'];
									sm_set_action('upload');
								}
							elseif (!file_exists($fs))
								{
									$error = $lang['error_file_upload_message'];
									sm_set_action('upload');
								}
							else
								{
									if (file_exists($fd))
										{
											$tmp['file'] = SM::TemporaryFilesPath().md5(time()).rand(1, 9999);
											$tmp['tmpfilecreated'] = true;
											rename($fd, $tmp['file']);
										}
									if (!move_uploaded_file($fs, $fd))
										{
											$error = $lang['error_file_upload_message'];
											sm_set_action('upload');
											if (isset($tmp) && $tmp['tmpfilecreated'])
												rename($tmp['file'], $fd);
										}
									else
										{
											if (isset($tmp) && $tmp['tmpfilecreated'])
												unlink($tmp['file']);
											//sm_notify($lang['operation_completed']);
											if (!empty(sm_getvars('returnto')))
												sm_redirect(sm_getvars('returnto'));
											else
												sm_redirect('index.php?m=download&d=view');
										}
								}
						}
				}
			if (sm_action('upload'))
				{
					add_path_modules();
					add_path($lang['module_download']['downloads'], 'index.php?m=download&d=admin');
					add_path($lang['common']['list'], 'index.php?m=download&d=list');
					add_path_current();
					$ui = new UI();
					if (!empty($error))
						$ui->NotificationError($error);
					sm_title($lang['module_download']['upload_file']);
					$f=new Form('index.php?m=download&d=postupload&id='.intval(sm_getvars('id')).'&returnto='.urlencode(sm_getvars('returnto')));
					$f->AddFile('userfile', $lang['common']['file'], true);
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					$ui->Output(true);
				}
			if (sm_action('postedit'))
				{
					$q = new TQuery(sm_table_prefix().'downloads');
					$q->Add('id_download', intval(sm_getvars('id')));
					$info = $q->Get();
					if (!empty($info['id_download']))
						{
							if (!empty(sm_postvars('optional_name')) && file_exists(SM::FilesPath().'download/'.basename(sm_postvars('optional_name'))))
								{
									$error = $lang['module_download']['file_already_exists'];
									sm_set_action('edit');
								}
							elseif (!empty(sm_postvars('optional_name')) && !sm_is_allowed_to_upload(sm_postvars('optional_name')))
								{
									$error = $lang['module_admin']['message_wrong_file_name'];
									sm_set_action('edit');
								}
							elseif (!empty(sm_postvars('optional_name')) && !rename(SM::FilesPath().'download/'.basename($info['file_download']), SM::FilesPath().'download/'.basename(sm_postvars('optional_name'))))
								{
									$error = $lang['error'];
									sm_set_action('edit');
								}
							else
								{
									$q = new TQuery(sm_table_prefix().'downloads');
									if (!empty(sm_postvars('optional_name')))
										$q->Add('file_download', dbescape(sm_postvars('optional_name')));
									$q->AddPost('description_download');
									$q->Add('userlevel_download', intval(sm_postvars('userlevel_download')));
									$q->Update('id_download', intval(sm_getvars('id')));
									if (!empty(sm_getvars('returnto')))
										sm_redirect(sm_getvars('returnto'));
									else
										sm_redirect('index.php?m=downloads&d=list');
								}
						}
				}
			if (sm_action('edit'))
				{
					$q=new TQuery(sm_table_prefix()."downloads");
					$q->Add('id_download', intval(sm_getvars('id')));
					$info=$q->Get();
					if (!empty($info['id_download']))
						{
							add_path_modules();
							add_path($lang['module_download']['downloads'], 'index.php?m=download&d=admin');
							add_path($lang['common']['list'], 'index.php?m=download&d=list');
							add_path_current();
							$ui = new UI();
							if (!empty($error))
								$ui->NotificationError($error);
							sm_title($lang['edit']);
							$f=new Form('index.php?m=download&d=postedit&id='.intval(sm_getvars('id')).'&returnto='.urlencode(sm_getvars('returnto')));
							$f->AddTextarea('description_download', $lang['module_download']['short_description_download'])
								->SetFocus();
							$f->AddSelect('userlevel_download', $lang['can_view'], Array(0, 1, 2, 3), Array($lang['all_users'], $lang['logged_users'], $lang['power_users'], $lang['administrators']));
							$f->AddText('optional_name', $lang['optional_file_name']);
							$f->LoadValuesArray($info);
							$f->LoadValuesArray(sm_postvars());
							$ui->AddForm($f);
							$ui->Output(true);
						}
				}
			if (sm_action('add'))
				{
					add_path_modules();
					add_path($lang['module_download']['downloads'], 'index.php?m=download&d=admin');
					add_path($lang['common']['list'], 'index.php?m=download&d=list');
					add_path_current();
					sm_use('smformatter');
					$ui = new UI();
					if (!empty($error))
						$ui->NotificationError($error);
					sm_title($lang['module_download']['upload_file']);
					$f=new Form('index.php?m=download&d=postadd&returnto='.urlencode(sm_getvars('returnto')));
					$f->AddFile('userfile', $lang['common']['file'], true);
					$f->Tooltip('userfile', sprintf($lang['messages']['max_upload_filesize'], SMFormatter::FileSize(sm_maxuploadbytes())));
					$f->AddTextarea('description_download', $lang['module_download']['short_description_download']);
					$f->AddSelect('userlevel_download', $lang['can_view'], Array(0, 1, 2, 3), Array($lang['all_users'], $lang['logged_users'], $lang['power_users'], $lang['administrators']));
					$f->AddText('optional_name', $lang['optional_file_name']);
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					$ui->Output(true);
				}
			if (sm_action('list'))
				{
					sm_use('smformatter');
					add_path_modules();
					add_path($lang['module_download']['downloads'], 'index.php?m=download&d=admin');
					add_path($lang['common']['list'], 'index.php?m=download&d=list');
					sm_title($lang['module_download']['downloads']);
					$offset=sm_abs(sm_getvars('from'));
					$limit=30;
					$ui = new UI();
					$b=new Buttons();
					$b->AddButton('add', $lang['common']['add'], 'index.php?m=download&d=add&returnto='.urlencode(sm_this_url()));
					$ui->AddButtons($b);
					$t=new Grid();
					$t->AddCol('file_download', $lang['file_name']);
					$t->AddCol('description_download', $lang['common']['description']);
					$t->AddCol('size', $lang['common']['size']);
					$t->AddCol('userlevel_download', $lang['can_view']);
					$t->AddCol('upload', $lang['module_download']['upload_file']);
					$t->AddActions();
					$t->AddEdit();
					$t->AddDelete();
					$q=new TQuery(sm_table_prefix().'downloads');
					$q->AddWhere('attachment_from', '-');
					$q->OrderBy('file_download');
					$q->Limit($limit);
					$q->Offset($offset);
					$q->Select();
					for ($i = 0; $i<sm_count($q->items); $i++)
						{
							$t->Label('file_download', $q->items[$i]['file_download']);
							$t->URL('file_download', SM::FilesPath().'download/'.$q->items[$i]['file_download'], true);
							if (file_exists(SM::FilesPath().'download/'.$q->items[$i]['file_download']))
								$t->Label('size', SMFormatter::FileSize(filesize(SM::FilesPath().'download/'.$q->items[$i]['file_download'])));
							$t->Label('description_download', $q->items[$i]['description_download']);
							if ($q->items[$i]['userlevel_download']==0)
								$t->Label('userlevel_download', $lang['all_users']);
							elseif ($q->items[$i]['userlevel_download']==1)
								$t->Label('userlevel_download', $lang['logged_users']);
							elseif ($q->items[$i]['userlevel_download']==2)
								$t->Label('userlevel_download', $lang['power_users']);
							else
								$t->Label('userlevel_download', $lang['administrators']);
							$t->Label('upload', $lang['module_download']['upload_file']);
							$t->DropDownItem('actions', $lang['add_to_menu'], sm_tomenuurl($q->items[$i]['file_download'], SM::FilesPath().'download/'.$q->items[$i]['file_download']));
							$t->URL('upload', 'index.php?m=download&d=upload&id='.$q->items[$i]['id_download'].'&returnto='.urlencode(sm_this_url()));
							$t->URL('edit', 'index.php?m=download&d=edit&id='.$q->items[$i]['id_download'].'&returnto='.urlencode(sm_this_url()));
							$t->URL('delete', 'index.php?m=download&d=postdelete&id='.$q->items[$i]['id_download'].'&returnto='.urlencode(sm_this_url()));
							$t->NewRow();
						}
					if ($t->RowCount()==0)
						$t->SingleLineLabel($lang['messages']['nothing_found']);
					$ui->AddGrid($t);
					$ui->AddPagebarParams($q->TotalCount(), $limit, $offset);
					$ui->AddButtons($b);
					$ui->Output(true);
				}
			if (sm_action('admin'))
				{
					add_path_modules();
					add_path_current();
					sm_title($lang['control_panel'].' - '.$lang['module_download']['downloads']);
					$ui = new UI();
					$nav=new Navigation();
					$nav->AddItem($lang['module_download']['downloads'].' - '.$lang['common']['list'], 'index.php?m=download&d=list');
					$nav->AddItem($lang['module_download']['upload_file'], 'index.php?m=download&d=add');
					$nav->AddItem($lang['add_to_menu'].' - '.$lang['module_download']['downloads'], sm_tomenuurl($lang['module_download']['downloads'], sm_fs_url('index.php?m=download&d=view')));
					$ui->Add($nav);
					$ui->Output(true);
				}
		}
	