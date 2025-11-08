<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.20
	//#revision 2021-08-31
	//==============================================================================

	use SM\SM;
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\Navigation;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (SM::isAdministrator())
		{
			if (sm_action('postdelete') && intval(sm_getvars('uid'))>1)
				{
					TQuery::ForTable(sm_global_table_prefix()."users")->Add('id_user', intval(sm_getvars('uid')))->Remove();
					sm_event('deleteuser', array(intval(sm_getvars('uid'))));
					sm_redirect(sm_getvars('returnto'));
				}
			if (sm_action('setstatus') && intval(sm_getvars('uid'))>1)
				{
					$q=new TQuery(sm_global_table_prefix()."users");
					$q->Add('user_status', intval(sm_getvars('status')));
					$q->Update('id_user', intval(sm_getvars('uid')));
					sm_redirect(sm_getvars('returnto'));
				}
			if (sm_actionpost('postedituser'))
				{
					$info=TQuery::ForTable(sm_global_table_prefix().'users')->Add('id_user', intval(sm_getvars('id')))->Get();
					if (!is_email(sm_postvars('email')))
						{
							$error=$lang['messages']['wrong_email'];
							sm_set_action('edituser');
						}
					elseif (!empty($info['id_user']) && intval($info['id_user'])!=1)
						{
							sm_set_userfield($info['id_user'], 'email', sm_postvars('email'));
							sm_set_userfield($info['id_user'], 'get_mail', intval(sm_postvars('get_mail')));
							$q=new TQuery(sm_table_prefix().'groups');
							$q->OrderBy('title_group');
							$q->Select();
							for ($i = 0; $i<$q->Count(); $i++)
								{
									if (intval(sm_postvars('group_'.$q->items[$i]['id_group']))==1)
										sm_set_group($q->items[$i]['id_group'], Array($info['id_user']));
									else
										sm_unset_group($q->items[$i]['id_group'], Array($info['id_user']));
								}
							sm_event('onchangeuserbyadmin', array($info['id_user']));
							if (!empty(sm_getvars('returnto')))
								sm_redirect(sm_getvars('returnto'));
							else
								sm_redirect('index.php?m=account&d=edituser&id='.$info['id_user']);
						}
				}
			if (sm_action('edituser'))
				{
					add_path_control();
					add_path($lang['user_list'], 'index.php?m=account&d=usrlist');
					add_path_current();
					sm_title($lang['change']);
					$info=TQuery::ForTable(sm_global_table_prefix().'users')->Add('id_user', intval(sm_getvars('id')))->Get();
					if (!empty($info['id_user']) && intval($info['id_user'])!=1)
						{
							sm_use('admininterface');
							sm_use('adminform');
							$ui = new UI();
							if (!empty($error))
								$ui->NotificationError($lang['messages']['wrong_email']);
							$f = new Form('index.php?m=account&d=postedituser&id='.$info['id_user'].'&returnto='.urlencode(sm_getvars('returnto')));
							$f->AddStatictext('login', $lang['login_str']);
							$f->AddText('email', $lang['email']);
							$f->AddCheckbox('get_mail', $lang['module_account']['get_mail_from_admin']);
							$f->LabelAfterControl();
							$q=new TQuery(sm_table_prefix().'groups');
							$q->OrderBy('title_group');
							$q->Select();
							if ($q->Count()>0)
								{
									$f->AddSeparator('groups', $lang['module_account']['groups']);
									for ($i = 0; $i<$q->Count(); $i++)
										{
											$f->AddCheckbox('group_'.$q->items[$i]['id_group'], $q->items[$i]['title_group'].(empty($q->items[$i]['description_group'])?'':' ('.$q->items[$i]['description_group'].')'));
											$f->LabelAfterControl();
											if (sm_isuseringroup($info['id_user'], $q->items[$i]['id_group']))
												$f->SetValue('group_'.$q->items[$i]['id_group'], 1);
										}
								}
							$f->LoadValuesArray($info);
							$f->LoadValuesArray(sm_postvars());
							$ui->AddForm($f);
							$ui->Output(true);
						}
				}
			if (sm_action('usrlist'))
				{
					add_path_control();
					add_path($lang['user_list'], 'index.php?m=account&d=usrlist');
					sm_title($lang['user_list']);
					if (SM::GET('sellogin')->isEmpty())
						SM::GET('sellogin')->SetValue(SM::POST('sellogin')->AsString());
					sm_use('admininterface');
					sm_use('admintable');
					sm_use('adminbuttons');
					$ui = new UI();
					$b = new Buttons();
					$b->AddButton('add', $lang['register_user'], 'index.php?m=account&d=adminregister');
					$ui->AddButtons($b);
					$t = new Grid();
					$limit = sm_settings('admin_items_by_page');
					$offset = sm_abs(sm_getvars('from'));
					$t->AddCol('user', $lang['user'], '40%');
					$t->AddCol('lastlogin', $lang['module_account']['last_login'], '20%');
					$t->AddCol('status', $lang['status'], '20%');
					$t->AddCol('action', $lang['action'], '20%');
					$q=new TQuery(sm_global_table_prefix()."users");
					if (!empty(sm_getvars('sellogin')))
						$q->Add("login LIKE '".dbescape(sm_getvars('sellogin'))."%'");
					if (!empty(sm_getvars('group')))
						{
							$groupinfo=TQuery::ForTable(sm_table_prefix().'groups')->Add('id_group', intval(sm_getvars('group')))->Get();
							add_path($groupinfo['title_group'], 'index.php?m=account&d=usrlist&group='.$groupinfo['id_group']);
							$q->Add("id_user IN (SELECT object_id FROM ".sm_table_prefix()."taxonomy WHERE object_name='usergroups' AND rel_id=".intval($groupinfo['id_group']).")");
						}
					$q->OrderBy("login");
					$q->Limit($limit);
					$q->Offset($offset);
					$q->Open();
					$i = 0;
					while ($row = $q->Fetch())
						{
							$t->Label('user', $row['login'].'<br />'.$row['email']);
							if ($row['user_status'] == 0)
								$t->Label('status', $lang['module_account']['unactivated_user']);
							elseif ($row['user_status'] == 1)
								$t->Label('status', $lang['normal_user']);
							elseif ($row['user_status'] == 2)
								$t->Label('status', $lang['privileged_user']);
							elseif ($row['user_status'] == 3)
								$t->Label('status', $lang['super_user']);
							if ($row['user_status'] != 0 && $row['id_user']!=1)
								$t->DropDownItem('status', $lang['module_account']['unactivated_user'], 'index.php?m=account&d=setstatus&uid='.$row['id_user'].'&status=0&returnto='.urlencode(sm_this_url()));
							if ($row['user_status'] != 1 && $row['id_user']!=1)
								$t->DropDownItem('status', $lang['normal_user'], 'index.php?m=account&d=setstatus&uid='.$row['id_user'].'&status=1&returnto='.urlencode(sm_this_url()));
							if ($row['user_status'] != 2 && $row['id_user']!=1)
								$t->DropDownItem('status', $lang['privileged_user'], 'index.php?m=account&d=setstatus&uid='.$row['id_user'].'&status=2&returnto='.urlencode(sm_this_url()));
							if ($row['user_status'] != 3 && $row['id_user']!=1)
								$t->DropDownItem('status', $lang['super_user'], 'index.php?m=account&d=setstatus&uid='.$row['id_user'].'&status=3&returnto='.urlencode(sm_this_url()));
							if ($row['last_login']>0)
								$t->Label('lastlogin', date(sm_datetime_mask(), $row['last_login']));
							$t->Label('action', $lang['details']);
							if ($row['id_user']!=1)
								{
									$t->DropDownItem('action', $lang['module_account']['set_password'], 'index.php?m=account&d=setpwd&uid='.$row['id_user'].'&returnto='.urlencode(sm_this_url()));
									$t->DropDownItem('action', $lang['common']['edit'], 'index.php?m=account&d=edituser&id='.$row['id_user'].'&returnto='.urlencode(sm_this_url()));
									$t->DropDownItem('action', $lang['delete'], 'index.php?m=account&d=postdelete&uid='.$row['id_user'].'&returnto='.urlencode(sm_this_url()), $lang['really_want_delete_user']);
								}
							$t->NewRow();
							$i++;
						}
					if ($t->RowCount()==0)
						$t->SingleLineLabel($lang['messages']['nothing_found']);
					$ui->AddGrid($t);
					$ui->div('<form action="index.php"><input type="hidden" name="m" value="account"><input type="hidden" name="d" value="usrlist">'.$lang['search'].': <input type="text" name="sellogin" value="'.htmlescape(sm_getvars('sellogin')).'"></form>');
					$ui->AddPagebarParams($q->TotalCount(), $limit, $offset);
					$ui->AddButtons($b);
					$ui->Output(true);
				}
			if (sm_action('postsetpwd'))
				{
					$usr = sm_userinfo(intval(sm_getvars('uid')));
					if (!empty($usr['id']))
						{
							if (empty(sm_postvars('newpwd')))
								{
									$errormessage=$lang['message_set_all_fields'];
									sm_set_action('setpwd');
								}
							else
								{
									sm_set_password($usr['id'], sm_postvars('newpwd'));
									sm_notify($lang['module_account']['message_set_password_finish']);
									sm_redirect(sm_getvars('returnto'));
								}
						}
				}
			if (sm_action('setpwd'))
				{
					$usr=sm_userinfo(intval(sm_getvars('uid')));
					if (!empty($usr['id']))
						{
							add_path_control();
							add_path($lang['user_list'], 'index.php?m=account&d=usrlist');
							add_path_current($lang['set_password']);
							sm_title($lang['module_account']['type_new_password_for_user']);
							$ui = new UI();
							if (!empty($errormessage))
								$ui->NotificationError($errormessage);
							$f = new Form('index.php?m=account&d=postsetpwd&uid='.$usr['id'].'&returnto='.urlencode(sm_getvars('returnto')));
							$f->AddLabel('login', $lang['login_str'], $usr['login']);
							$f->AddText('newpwd', $lang['password']);
							$f->LoadValuesArray(sm_postvars());
							$f->SaveButton($lang['set_password']);
							$ui->AddForm($f);
							$ui->Output(true);
							sm_setfocus('newpwd');
						}
				}
			if (sm_action('listgroups'))
				{
					add_path_control();
					add_path($lang['module_account']['groups'], 'index.php?m=account&d=listgroups');
					sm_title($lang['module_account']['groups']);
					sm_use('admintable');
					sm_use('admininterface');
					sm_use('adminbuttons');
					$ui = new UI();
					$t=new Grid();
					$t->AddCol('title', $lang['common']['title'], '100%');
					$t->AddCol('search', '', '16', $lang['search'], '', 'search.gif');
					$t->AddEdit();
					$t->AddDelete();
					$q=new TQuery(sm_table_prefix().'groups');
					$q->OrderBy('title_group');
					$q->Open();
					$i = 0;
					while ($row = $q->Fetch())
						{
							$t->Label('title', $row['title_group']);
							$t->Hint('title', htmlescape($row['description_group']));
							$t->URL('search', 'index.php?m=account&d=usrlist&group='.$row['id_group']);
							$t->URL('edit', 'index.php?m=account&d=editgroup&id='.$row['id_group']);
							$t->URL('delete', 'index.php?m=account&d=postdeletegroup&id='.$row['id_group']);
							$t->NewRow();
							$i++;
						}
					if ($t->RowCount()==0)
						$t->SingleLineLabel($lang['messages']['nothing_found']);
					$b=new Buttons();
					$b->AddButton('add', $lang['module_account']['add_group'], 'index.php?m=account&d=addgroup');
					$ui->AddButtons($b);
					$ui->AddGrid($t);
					$ui->AddButtons($b);
					$ui->Output(true);
				}
			if (sm_actionpost('postaddgroup'))
				{
					$q = new TQuery(sm_table_prefix().'groups');
					$q->AddPost('title_group');
					$q->AddPost('description_group');
					$q->Add('autoaddtousers_group', intval(sm_postvars('autoaddtousers_group')));
					$q->Insert();
					sm_redirect('index.php?m=account&d=listgroups');
				}
			if (sm_actionpost('posteditgroup'))
				{
					if (empty(sm_postvars('title_group')))
						$error_message=$lang['messages']['fill_required_fields'];
					if (empty($error_message))
						{
							$q = new TQuery(sm_table_prefix().'groups');
							$q->AddPost('title_group');
							$q->AddPost('description_group');
							$q->Add('autoaddtousers_group', intval(sm_postvars('autoaddtousers_group')));
							$q->Update('id_group', intval(sm_getvars('id')));
							sm_redirect('index.php?m=account&d=listgroups');
						}
					else
						sm_set_action(Array('postaddgroup'=>'addgroup', 'posteditgroup'=>'editgroup'));
				}
			if (sm_action('addgroup', 'editgroup'))
				{
					if (sm_action('addgroup'))
						sm_title($lang['module_account']['add_group']);
					else
						sm_title($lang['common']['edit']);
					sm_use('adminform');
					sm_use('admininterface');
					$ui = new UI();
					add_path_control();
					add_path($lang['module_account']['groups_management'], 'index.php?m=account&d=listgroups');
					add_path_current();
					if (!empty($error_message))
						$ui->NotificationError($error_message);
					if (sm_action('addgroup'))
						$f = new Form('index.php?m=account&d=postaddgroup');
					else
						$f = new Form('index.php?m=account&d=posteditgroup&id='.sm_getvars('id'));
					$f->AddText('title_group', $lang['module_account']['title_group'], true);
					$f->AddTextarea('description_group', $lang['module_account']['description_group']);
					$f->AddCheckbox('autoaddtousers_group', $lang['module_account']['add_to_new_users'], 1);
					if (sm_action('editgroup'))
						$f->LoadValuesArray(TQuery::ForTable(sm_table_prefix().'groups')->AddWhere('id_group', intval(sm_getvars('id')))->Get());
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					$ui->Output(true);
					sm_setfocus('title_group');
				}
			if (sm_action('postdeletegroup'))
				{
					sm_delete_group(intval(sm_getvars('id')));
					sm_redirect('index.php?m=account&d=listgroups');
				}
			if (sm_actionpost('postadminregister'))
				{
					if (intval(sm_settings('use_email_as_login'))==0)
						$login=trim(sm_postvars('login'));
					else
						$login=trim(sm_postvars('email'));
					$email=sm_postvars('email');
					if (intval(sm_settings('use_email_as_login'))==0 && empty(sm_postvars('login')) || empty(sm_postvars('password')) || empty($email))
						$error_message=$lang['messages']['fill_required_fields'];
					elseif (!is_email($email))
						{
							$error_message = $lang['message_bad_email'];
						}
					elseif (intval(TQuery::ForTable(sm_global_table_prefix().'users')->Add('login', dbescape($login))->GetField('id_user'))>0)
						{
							$error_message = $lang['message_this_login_present_try_another'];
						}
					elseif (intval(TQuery::ForTable(sm_global_table_prefix().'users')->Add('email', dbescape($email))->GetField('id_user'))>0)
						{
							$error_message = $lang['message_bad_email'];
						}
					if (empty($error_message))
						{
							$id_newuser = sm_add_user($login, sm_postvars('password'), $email, sm_postvars('secret_question'), sm_postvars('secret_answer_question'), 1);
							sm_event('successregister', array($id_newuser));
							log_write(LOG_LOGIN, $lang['module_account']['log']['user_registered'].': '.$login.'. '.$lang['email'].': '.$email);
							sm_redirect('index.php?m=account&d=usrlist&sellogin='.urlencode($login));
						}
					if (!empty($error_message))
						sm_set_action('adminregister');
				}
			if (sm_action('adminregister'))
				{
					add_path_control();
					add_path($lang['user_list'], 'index.php?m=account&d=usrlist');
					add_path_current();
					sm_title($lang['register']);
					$ui=new UI();
					if (!empty($error_message))
						$ui->NotificationError($error_message);
					$f=new Form('index.php?m='.sm_current_module().'&d=postadminregister');
					if (intval(sm_settings('use_email_as_login'))==0)
						$f->AddText('login', $lang['login_str'], true)
							->SetFocus();
					else
						$f->AddText('email', $lang['common']['email'], true)
							->SetFocus();
					$f->AddText('password', $lang['password'], true);
					if (intval(sm_settings('use_email_as_login'))==0)
						$f->AddText('email', $lang['common']['email'], true);
					if (intval(sm_settings('account_disable_secret_question'))!=1)
						{
							$f->AddText('secret_question', $lang['secret_question']);
							$f->AddText('secret_answer_question', $lang['secret_answer_question']);
						}
					$f->LoadValuesArray(sm_postvars());
					$f->SaveButton($lang['register']);
					$ui->Add($f);
					$ui->Output(true);
				}

			sm_on_action('admin', function ()
				{
					global $lang;
					add_path_modules();
					add_path_current();
					sm_title($lang['control_panel'].' - '.$lang['user_settings']);
					$ui = new UI();
					$nav=new Navigation();
					$nav->AddItem(sprintf('%s - %s', $lang['set_as_block'], $lang['login']), sm_addblockurl($lang['login'], 'account', 1));
					$nav->AddItem($lang['add_to_menu'].' - '.$lang['login'], sm_tomenuurl($lang['login'], sm_fs_url('index.php?m=account')));
					$nav->AddItem($lang['add_to_menu'].' - '.$lang['logout'], sm_tomenuurl($lang['logout'], sm_fs_url('index.php?m=account&d=logout')));
					$ui->Add($nav);
					$ui->Output(true);
				});
		}

