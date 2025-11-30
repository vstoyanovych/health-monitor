<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.22
	//#revision 2022-02-24
	//==============================================================================

	use SM\Core\UserDataMaintainer;
	use SM\SM;
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Navigation;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	/** @var string[]|string[][]|string[][][] $lang */
	if (SM::isLoggedIn())
		{
			if (sm_settings('allow_private_messages')==1 && !empty($userinfo['id']))
				include('modules/inc/memberspart/account_privatemessages.php');
			if (sm_action('postchange'))
				{
					sm_template('account');
					sm_title($lang['change']);
					$old_password=dbescape(sm_postvars("p_old_password"));
					$password=dbescape(sm_postvars("p_password"));
					$password2=dbescape(sm_postvars("p_password2"));
					$email=sm_postvars("p_email");
					$question=dbescape(sm_postvars("p_question"));
					$get_mail=intval(sm_postvars("p_get_mail"));
					$answer=dbescape(sm_postvars("p_answer"));
					sm_event('userdetailschangedcheckdata', array(0));
					if (empty($email) || (!empty($question) && empty($answer)) || !empty($special['userdetailschangedcheckdataerror']))
						{
							$m['message']=$lang["message_set_all_fields"].(empty($special['userdetailschangedcheckdataerror'])?'':'. '.$special['userdetailschangedcheckdataerror']);
							$m['mode']='change';
							$m['user_email']=$email;
							$m['user_question']=$question;
							$m['user_answer']=$answer;
							$m['user_get_mail']=$get_mail;
						}
					$sqlpasswd='';
					if (!empty($password))
						{
							if (sm_strcmp($password, $password2)!=0)
								{
									$m['message']=$lang["message_passwords_not_equal"];
									$m['mode']='change';
									$m['user_email']=$email;
									$m['user_question']=$question;
									$m['user_answer']=$answer;
									$m['user_get_mail']=$get_mail;
								}
							else
								{
									$password=sm_password_hash($password, SM::User()->Login());
									$random_code=md5(SM::User()->ID().microtime().rand());
									$sqlpasswd=", password = '".dbescape($password)."', random_code='".dbescape($random_code)."' ";
								}
						}
					if (!is_email($email))
						{
							$m['message']=$lang["message_bad_email"];
							$m['mode']='change';
							$m['user_login']=SM::User()->Login();
							$m['user_email']=$email;
							$m['user_question']=$question;
							$m['user_answer']=$answer;
							$m['user_get_mail']=$get_mail;
						}
					if (!sm_action('change'))
						{
							$sql="SELECT * FROM ".sm_global_table_prefix()."users WHERE id_user = ".SM::User()->ID();
							if (!empty($old_password))
								{
									$sql.=" AND password = '".sm_password_hash($old_password, SM::User()->Login())."'";
								}
							$result=execsql($sql);
							$u=0;
							while ($row=database_fetch_object($result))
								{
									$u=1;
								}
							if ($u==0)
								{
									$m['message']=$lang["error"];
									$m['mode']='change';
									$m['user_email']=$email;
									$m['user_question']=$question;
									$m['user_answer']=$answer;
									$m['user_get_mail']=$get_mail;
								}
							else
								{
									$sql="UPDATE ".sm_global_table_prefix()."users SET email = '$email', question = '$question', answer = '$answer', get_mail = '$get_mail' $sqlpasswd ";
									$sql.=" WHERE  id_user = ".SM::User()->ID();
									$result=execsql($sql);
									sm_event('userdetailschanged', [SM::User()->ID()]);
									sm_login(SM::User()->ID());
									UserDataMaintainer::Init();
									sm_notify($lang['message_success_change']);
									if (!empty($special['redirect_on_success_change_usrdata']))
										sm_redirect($special['redirect_on_success_change_usrdata']);
									elseif (sm_has_settings('redirect_on_success_change_usrdata'))
										sm_redirect(sm_settings('redirect_on_success_change_usrdata'));
									else
										sm_redirect('index.php?m=account&d=cabinet');
								}
						}
				}

			if (sm_action('change'))
				{
					sm_template('account');
					sm_title($lang['change']);
					$sql="SELECT * FROM ".sm_global_table_prefix()."users WHERE id_user = ".SM::User()->ID();
					$row=getsql($sql);
					$m['user_id']=$row['id_user'];
					$m['user_login']=$row['login'];
					$m['user_email']=$row['email'];
					$m['user_question']=$row['question'];
					$m['user_answer']=$row['answer'];
					$m['user_get_mail']=$row['get_mail'];
					$m['user_groups']=get_array_groups($row['groups_user']);
					sm_event('onchreginfo', [$m['user_id']]);
					sm_page_viewid('account-change');
				}
			if (sm_action('logout'))
				{
					sm_logout();
					sm_notify($lang['message_logout']);
					UserDataMaintainer::Init();
					setcookie(sm_settings('cookprefix').'simanautologin', '');
					if (sm_has_settings('redirect_after_logout'))
						sm_redirect_now(sm_settings('redirect_after_logout'));
					else
						sm_redirect_now(sm_homepage());
				}
			if (sm_action('cabinet') && !empty($userinfo['id']))
				{
					sm_title($lang["my_cabinet"]);
					$ui=new UI();
					if (intval(sm_settings('allow_private_messages'))==1)
						{
							$privmsgdata=siman_get_privmsgcount($userinfo['id']);
							$b=new Buttons();
							$b->Button($lang['module_account']['send_message'], 'index.php?m=account&d=sendprivmsg');
							$b->Button($lang['module_account']['inbox'].($privmsgdata['inbox']['unread']>0?' ('.$privmsgdata['inbox']['unread'].'/'.$privmsgdata['inbox']['all'].')':''), 'index.php?m=account&d=viewprivmsg&folder=inbox');
							$b->Button($lang['module_account']['outbox'], 'index.php?m=account&d=viewprivmsg&folder=outbox');
							$ui->Add($b);
						}
					$ui->p($lang['wellcome'].', <strong>'.SM::User()->Login().'</strong>!');
					if (!empty($userinfo['info']['notebook']))
						{
							$ui->AddBlock($lang['module_account']['notebook']);
							$ui->p(nl2br($userinfo['info']['notebook']));
						}
					$navigation=new Navigation();
					if (!sm_empty_settings('users_menu_id'))
						{
							$nav=new SMNavigation($user_menu);
							$nav->LoadFromDB(sm_settings('users_menu_id'));
							if (count($user_menu)>0)
								{
									foreach ($user_menu as $menu_line)
										{
											$navigation->AddItem($menu_line['caption'], $menu_line['url']);
										}
								}
						}
					if (SM::isAdministrator())
						$navigation->AddItem($lang['control_panel'], 'index.php?m=admin');
					$navigation->AddItem($lang['module_account']['notebook'], 'index.php?m=account&d=editnbook');
					$navigation->AddItem($lang['module_account']['change_personal_info'], 'index.php?m=account&d=change');
					$navigation->AddItem($lang['logout'], 'index.php?m=account&d=logout');
					if ($navigation->Count()>0)
						{
							$ui->AddBlock($lang['menu']);
							$ui->Add($navigation);
						}
					$ui->Output(true);
					sm_page_viewid('account-cabinet');
				}
			if (sm_actionpost('savenbook') && !empty($userinfo['id']))
				{
					sm_set_userfield(intval($userinfo['id']), 'notebook', htmlescape(sm_postvars('p_notebook')));
					sm_notify($lang['module_account']['message_notebook_text_saved']);
					sm_redirect('index.php?m=account&d=cabinet');
				}
			if (sm_action('editnbook') && !empty($userinfo['id']))
				{
					sm_title($lang['module_account']['notebook']);
					$ui=new UI();
					$f=new Form('index.php?m='.sm_current_module().'&d=savenbook');
					$f->AddTextarea('p_notebook', $lang['common']['text'])
					  ->WithValue($userinfo['info']['notebook'])
					  ->SetFocus();
					$ui->Add($f);
					$ui->Output(true);
				}
			if (SM::isAdministrator())
				include('modules/inc/adminpart/account.php');
		}