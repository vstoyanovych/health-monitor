<?php

//------------------------------------------------------------------------------
//|            Content Management System SiMan CMS                             |
//|                http://www.simancms.org                                     |
//------------------------------------------------------------------------------

//==============================================================================
//#ver 1.6.7
//#revision 2014-06-06
//==============================================================================

if (!defined("SIMAN_DEFINED")) {
    print('Hacking attempt!');
    exit();
}

if (!defined("MANAGE_ACCOUNT_FUNCTIONS_DEFINED")) {

    define("MANAGE_ACCOUNT_FUNCTIONS_DEFINED", 1);
}
use NUWM\API\Auth\AccessToken;
	use SM\UI\Form;
	use SM\UI\UI;

	if ($userinfo['level'] > 0)
	{
		sm_default_action('add');
		if (sm_action('postadd'))
			{
				include 'includes/smcoreext.php';
				$error_message = '';

				if (empty(trim($_postvars['login_d']))) {
					$error_message = 'Login is required';
				}

				if (empty(trim($_postvars['passwd_d']))) {
					$error_message = 'Password is required';
				}

				if (empty($error_message)) {
					if ($uid = sm_check_user($_postvars["login_d"], $_postvars["passwd_d"])) {
						$access_token = AccessToken::Create($uid, 'webapp');
						$employee = new TEmployee($access_token->EmployeeID());
						$response = [
							'status' => 'success',
							'token' => $access_token->Token(),
							'name' => $employee->Email(),
							'login' => $employee->Login(),
						];
						if (isset($_postvars['current_token']) && $_postvars['current_token'] = 1) {
							$current_access_token = AccessToken::Create($userinfo['id'], 'webapp');
							$employee_info = new TEmployee($current_access_token->EmployeeID());
							$response['currentToken'] = [
								'token' => $current_access_token->Token(),
								'name' => $employee_info->Email(),
								'login' => $employee_info->Login(),
							];
						}
						sm_login($uid);
						exit(json_encode($response));
					} else {
						$error_message = "Invalid Credentials.";
					}

				}
				$response = [
					'status' => 'error',
					'error_message' => $error_message,
				];

				exit(json_encode($response));

			}

		if (sm_action('currentaccounttoken'))
			{
				$current_access_token = AccessToken::Create($userinfo['id'], 'webapp');
				$employee_info = new TEmployee($current_access_token->EmployeeID());
				$response = [
					'status' => 'success',
					'token' => $current_access_token->Token(),
					'name' => $employee_info->Email(),
					'login' => $employee_info->Login(),
				];
				exit(json_encode($response));
			}

		if (sm_action('add'))
			{

				sm_add_jsfile('manageaccount.js');
				add_path_home();
				add_path('Manage Accounts', 'index.php?m=manageaccount');
				sm_title($lang['common']['add']);

				$ui = new UI();
				if (!empty($error_message))
					$ui->NotificationError($error_message);

				$ui->html('<div class="alert alert-danger add-account-error-msg" role="alert"></div>');
				$f = new Form('index.php?m=' . sm_current_module() . '&d=postadd');
				$f->AddClassnameGlobal('add_account_form');
				$f->AddText('login_d', 'Login', true);
				$f->AddPassword('passwd_d', 'Password', true);
				$f->AddHidden('current_login', $userinfo['login']);
				$ui->AddForm($f);
				$ui->Output(true);
			}


	}

if (sm_action('switchaccount')) {
    include 'includes/smcoreext.php';

    if (!empty($_getvars['token'])) {
        $access_token = AccessToken::initWithToken($_getvars['token']);
        if ($access_token->Exists()) {
            sm_login($access_token->EmployeeID());
        }
    }

    sm_redirect('index.php');
}
