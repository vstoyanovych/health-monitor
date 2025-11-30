<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	/*
	Module Name: Account
	Module URI: http://simancms.apserver.org.ua/modules/download/
	Description: Accounts module. Base CMS module
	Version: 1.6.23
	Revision: 2023-08-27
	Author URI: http://simancms.apserver.org.ua/
	*/

	use SM\Common\Redirect;
	use SM\SM;
	use SM\UI\Form;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	sm_default_action('show');

	/** @var string[]|string[][]|string[][][] $lang */
	if (sm_actionpost("postregister") && !sm_empty_settings('allow_register'))
		{
			sm_template('account');
			sm_title($lang['register']);
			$login = sm_postvars("p_login");
			$password = sm_postvars("p_password");
			$password2 = sm_postvars("p_password2");
			if (intval(sm_settings('use_email_as_login')) == 1)
				$email = $login;
			else
				$email = sm_postvars("p_email");
			$question = sm_postvars("p_question");
			$answer = sm_postvars("p_answer");
			sm_event('postregistercheckdata', [0]);
			$m['message']='';
			if (empty($login) || empty($password) || empty($password2) || empty($email) || (intval(sm_settings('account_disable_secret_question')!=1) && (empty($question) || empty($answer))) || !empty($special['postregistercheckdataerror']))
				{
					$m['message'] = $lang["message_set_all_fields"].(empty($special['postregistercheckdataerror']) ? '' : '. '.$special['postregistercheckdataerror']);
				}
			elseif (!is_email($email))
				{
					$m['message'] = $lang["message_bad_email"];
				}
			elseif (sm_strcmp($password, $password2) != 0)
				{
					$m['message'] = $lang["message_passwords_not_equal"];
				}
			elseif (intval(sm_settings('use_protect_code')) == 1 && (sm_strcmp(sm_current_protect_code(), sm_postvars('p_protect_code')) != 0 || empty(sm_postvars('p_protect_code'))))
				{
					$m['message'] = $lang['module_account']['wrong_protect_code'];
				}
			elseif (sm_user_exists($login))
				{
					$m['message'] = $lang["message_this_login_present_try_another"];
				}
			elseif (intval(TQuery::ForTable(sm_global_table_prefix().'users')->Add('email', dbescape($email))->GetField('id_user'))>0)
				{
					$m['message'] = $lang["message_bad_email"];
				}
			else
				{
					if (intval(sm_settings('user_activating_by_admin')) == 1)
						$user_status = '0';
					else
						$user_status = '1';
					$id_newuser = sm_add_user($login, $password, $email, $question, $answer, $user_status);
					sm_event('successregister', array($id_newuser));
					if (!sm_empty_settings('redirect_after_register'))
						{
							Redirect::Now(sm_settings('redirect_after_register'));
						}
					elseif (SM::isAdministrator())
						{
							Redirect::Now('index.php?m=account&d=usrlist');
						}
					sm_set_action('successregister');
					log_write(LOG_LOGIN, $lang['module_account']['log']['user_registered'].': '.$login.'. '.$lang['email'].': '.$email);
				}
			if (!empty($m['message']))
				sm_set_action('register');
		}

	sm_on_action('successregister', function ()
		{
			sm_title(sm_lang('register'));
			$ui = new UI();
			$ui->p(sm_lang('success_registration'));
			$ui->a('index.php?m=account&d=show', sm_lang('you_can_enter'));
			$ui->Output(true);
		});

	if (intval(sm_settings('allow_forgot_password')) == 1)
		{
			if (sm_action('getpasswd'))
				{
					sm_title($lang['get_password']);
					$ui=new UI();
					$f=new Form('index.php');
					$f->SetMethodGet();
					$f->AddHidden('m', sm_current_module());
					$f->AddHidden('d', 'getpasswd2');
					$f->AddText('login', $lang['login_str'])
						->SetFocus();
					$f->SaveButton($lang['get_password']);
					$ui->Add($f);
					$ui->Output(true);
				}
			if (sm_action('getpasswd3'))
				{
					sm_template('account');
					sm_title($lang['get_password']);
					$usr_name = dbescape(strtolower(sm_getvars("login")));
					$usr_answer = dbescape(sm_postvars("p_answ"));
					$usr_newpwd = dbescape(sm_password_hash(sm_postvars("p_newpwd"), sm_getvars("login")));
					$info = getsql("SELECT id_user FROM ".sm_global_table_prefix()."users WHERE lower(login)='$usr_name' AND answer='$usr_answer' AND answer<>''");
					if (!empty($info['id_user']))
						{
							execsql("UPDATE ".sm_global_table_prefix()."users SET password='$usr_newpwd', random_code='".dbescape(md5($usr_name.microtime(true).rand()))."' WHERE lower(login)='$usr_name' AND answer='$usr_answer' AND answer<>''");
							log_write(LOG_LOGIN, $lang['get_password'].' - '.$lang['common']['ok']);
							sm_event('onchangepassword', Array('login' => sm_getvars("login"), 'newpassword' => sm_postvars("p_newpwd")));
							sm_notify($lang['message_forgot_password_finish']);
							Redirect::Now('index.php?m=account');
						}
					else
						{
							log_write(LOG_LOGIN, $lang['get_password'].' - '.$lang["error"]);
							sm_set_action('getpasswd2');
						}
				}
			if (sm_action('getpasswd2'))
				{
					sm_template('account');
					sm_title($lang["get_password"]);
					$usr_name = sm_getvars("login");
					$sql = "SELECT * FROM ".sm_global_table_prefix()."users WHERE login='".dbescape(strtolower($usr_name))."'";
					$result = execsql($sql);
					while ($row = database_fetch_object($result))
						{
							$m['secret_question'] = $row->question;
							$m['userdata_login'] = $usr_name;
						}
					if (empty($m['secret_question']))
						sm_set_action('wronglogin');
				}
		}

	if (sm_action('register'))
		{
			if (!sm_empty_settings('allow_register') || SM::isAdministrator())
				{
					sm_template('account');
					sm_title($lang['register']);
					if (intval(sm_settings('use_protect_code')) == 1)
						siman_generate_protect_code();
					sm_event('onregister', array(''));
					sm_page_viewid('account-register');
				}
			else
				{
					sm_error_page($lang['error'], $lang['you_cant_register']);
				}
		}
	if (sm_action('login'))
		{
			sm_template('account');
			sm_title($lang['login_caption']);
			if (!empty(sm_postvars('login_d')))
				{
					sm_event('beforelogincheck');
					if ($uid=sm_check_user(sm_postvars('login_d'), sm_postvars('passwd_d')))
						{
							sm_event('beforelogin');
							sm_process_login($uid);
							sm_notify($lang['message_success_login']);
							if (intval(sm_postvars('autologin_d')) == 1 || intval(sm_settings('alwaysautologin')) == 1)
								{
									setcookie(sm_settings('cookprefix').'simanautologin', md5(sm_session_prefix().SM::User()->RandomCode().SM::User()->ID()), time() + (intval(sm_settings('autologinlifetime')) > 0 ? intval(sm_settings('autologinlifetime')) : 30758400));
								}
							log_write(LOG_LOGIN, $lang['module_account']['log']['user_logged']);
							if (intval(sm_settings('return_after_login')) == 1 && !empty(sm_postvars('p_goto_url')))
								{
									Redirect::Now(sm_postvars('p_goto_url'));
								}
							elseif (!sm_empty_settings('redirect_after_login_3') && SM::isAdministrator())
								{
									Redirect::Now(sm_settings('redirect_after_login_3'));
								}
							elseif (!sm_empty_settings('redirect_after_login_2') && SM::User()->Level() >= 2)
								{
									Redirect::Now(sm_settings('redirect_after_login_2'));
								}
							elseif (!sm_empty_settings('redirect_after_login_1') && SM::User()->Level() >= 1)
								{
									Redirect::Now(sm_settings('redirect_after_login_1'));
								}
							else
								{
									if (!sm_empty_settings('cabinet_module'))
										Redirect::Now('index.php?m='.sm_settings('cabinet_module'));
									else
										Redirect::Now('index.php?m=account&d=cabinet');
								}
						}
					else
						{
							sm_set_action('wronglogin');
							log_write(LOG_DANGER, $lang['module_account']['log']['user_not_logged'].': '.htmlescape(sm_postvars('login_d')));
							sm_setfocus('login_d');
							$autoban_time = sm_get_settings('autoban_time', 'general');
							sm_tempdata_addint('wronglogin', sm_ip_address(), time(), $autoban_time);
							//Autoban checking
							if (intval(sm_tempdata_aggregate('wronglogin', sm_ip_address(), SM_AGGREGATE_COUNT)) > intval(sm_get_settings('autoban_attempts', 'general')))
								{
									sm_ban_ip($autoban_time);
									sm_tempdata_remove('wronglogin', sm_ip_address());
									sm_access_denied();
								}
						}
				}
			else
				sm_set_action('show');
		}
	if (sm_action('show'))
		{
			if (sm_is_main_block() && SM::isLoggedIn())
				sm_set_action('cabinet');
			else
				{
					sm_title($lang['login_caption']);
					sm_template('account');
					$m['goto_url'] = sm_this_url();
					if (sm_is_main_block())
						sm_setfocus('login_d');
					if (!empty($userinfo['id']))
						{
							$m['cabinet_home_url'] = 'index.php?m=account&d=cabinet';
							if (!sm_empty_settings('cabinet_module'))
								$m['cabinet_home_url'] = 'index.php?m='.sm_settings('cabinet_module');
						}
					sm_event('onshowloginpage', ['']);
					sm_page_viewid('account-show');
				}
		}

	if (SM::isLoggedIn())
		include('modules/inc/memberspart/account.php');
	else
		if (sm_action('logout'))
			{
				if (!sm_empty_settings('redirect_after_logout'))
					Redirect::Now(sm_settings('redirect_after_logout'));
				else
					Redirect::Now(sm_homepage());
			}
