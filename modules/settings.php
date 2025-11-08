<?php

	use SM\Common\Redirect;
	use SM\SM;
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\UI;

	if (sm_action('togglesidebar'))
		{
			if(!isset($_SESSION['nav_toggle_class']))
				$_SESSION['nav_toggle_class'] = '';

			if (empty($_SESSION['nav_toggle_class']))
				$_SESSION['nav_toggle_class'] = 'nav-toggle';
			else
				$_SESSION['nav_toggle_class'] = '';
		}

	if (SM::isLoggedIn() && SM::User()->Level() == 3)
		{
			sm_default_action('tags');
			sm_add_body_class('settings_section');
			sm_add_cssfile('settings_section.css');

			if (sm_action('system'))
				{
					add_path_home();
					add_path_current();
					sm_title('System Settings');

					$ui = new UI();
					$ui->AddTPL('settings_header.tpl', '', ['current_action' => 'systemsettings']);
					$ui->html('<div class="w-100">');
					$ui->AddTPL('system_settings_tabs.tpl', '', ['current_action' => 'systemsettings']);

					$ui->html('<div class="flex flex-align-center"><span style="margin-right: 10px;">Content Grabber</span>');
					$ui->div('<a href="index.php?m=system&d=grabbertoggle&returnto='.urlencode(sm_this_url()).'">'.( System::isGrabberEnabled()?'<i class="fa fa-toggle-on" style="font-size: 28px; color: darkgreen"></i>':'<i class="fa fa-toggle-off" style="font-size: 28px; color: #ccc"></i>' ).'</a>');
					$ui->html('</div>');
					$f = new Form('index.php?m='.sm_current_module().'&d=savesettings&tab=mailing');
					$f->Separator('MailJet');
					$f->AddText('mailjet_api_key', 'MailJet API Key')->WithValue(System::MailjetApiKey());
					$f->AddText('mailjet_api_secret', 'MailJet API Secret')->WithValue(System::MailjetApiSecret());
					$ui->Add($f);

					$ui->html('<div class="flex flex-align-center">');
					$employee = new TEmployee(SM::User()->ID());
					if ($employee->isFacebookConnected())
						{
							$ui->div('<a href="index.php?m=fbconnect&d=pages&id='.$employee->ID().'" class="btn btn-default btn-dark facebook">'.'<i class="fa fa-facebook"></i> Facebook Pages' .'</a>');
							$ui->div('<a href="index.php?m=fbconnect&d=disconnectfb&id='.$employee->ID().'&returnto='.urlencode(sm_this_url()).'" class="btn btn-default btn-dark facebook">'.'<i class="fa fa-facebook"></i> Disconnect Facebook' .'</a>');
						}
					else
						{
							$ui->div('<a href="index.php?m=fbconnect&d=view&id='.$employee->ID().'" class="btn btn-default btn-dark facebook">'.'<i class="fa fa-facebook"></i> Connect Facebook' .'</a>');
						}
					$ui->html('</div>');
					$ui->html('</div>');
					$ui->Output(true);
				}

			if (sm_action('emailsettings'))
				{
					add_path_home();
					add_path_current();
					sm_title('System Settings');

					$ui = new UI();
					$ui->AddTPL('settings_header.tpl', '', ['current_action' => 'systemsettings']);
					$ui->html('<div class="w-100">');
					$ui->AddTPL('system_settings_tabs.tpl', '', ['current_action' => 'emailsettings']);

					$f = new Form('index.php?m='.sm_current_module().'&d=savesettings');
					$f->Separator('MailJet');
					$f->AddText('mailjet_api_key', 'MailJet API Key')->WithValue(System::MailjetApiKey());
					$f->AddText('mailjet_api_secret', 'MailJet API Secret')->WithValue(System::MailjetApiSecret());
					$ui->Add($f);

					$ui->html('</div>');
					$ui->Output(true);
				}
		}
	else
		sm_redirect('index.php');