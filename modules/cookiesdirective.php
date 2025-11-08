<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//------------------------------------------------------------------------------

	/*
	Module Name: Cookies Directive
	Module URI: http://simancms.apserver.org.ua/
	Description: Informing your visitors about how you use cookies on your website
	Version: 2019-09-20
	Author: SiMan CMS Team
	Author URI: http://simancms.apserver.org.ua/
	*/

	use SM\SM;
	use SM\UI\Form;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (SM::isAdministrator())
		{
			sm_include_lang('cookiesdirective');
			if (sm_action('savesettings'))
				{
					if (empty(sm_postvars('cookiesdirective_message')))
						$error_message=$lang['messages']['fill_required_fields'];
					elseif (intval(sm_postvars('cookiesdirective_duration'))<=0)
						$error_message=$lang['messages']['wrong_value'];
					if (empty($error_message))
						{
							sm_add_settings('cookiesdirective_on', intval(sm_postvars('cookiesdirective_on')));
							sm_add_settings('cookiesdirective_message', sm_postvars('cookiesdirective_message'));
							sm_add_settings('cookiesdirective_position', sm_postvars('cookiesdirective_position'));
							sm_add_settings('cookiesdirective_duration', intval(sm_postvars('cookiesdirective_duration')));
							sm_add_settings('cookiesdirective_background_color', sm_postvars('cookiesdirective_background_color'));
							sm_add_settings('cookiesdirective_background_opacity', intval(sm_postvars('cookiesdirective_background_opacity')));
							sm_add_settings('cookiesdirective_font_color', sm_postvars('cookiesdirective_font_color'));
							sm_add_settings('cookiesdirective_font_size', sm_postvars('cookiesdirective_font_size'));
							sm_add_settings('cookiesdirective_font_family', sm_postvars('cookiesdirective_font_family'));
							sm_add_settings('cookiesdirective_extra_container_style', sm_postvars('cookiesdirective_extra_container_style'));
							sm_add_settings('cookiesdirective_extra_button_style', sm_postvars('cookiesdirective_extra_button_style'));
							sm_add_settings('cookiesdirective_zindex', intval(sm_postvars('cookiesdirective_zindex')));
							sm_notify($lang['messages']['settings_updated']);
							sm_redirect('index.php?m='.sm_current_module().'&d=admin');
						}
					else
						sm_set_action('admin');
				}
			if (sm_action('admin'))
				{
					add_path_modules();
					add_path($lang['module_cookiesdirective']['module_cookiesdirective'], 'index.php?m=cookiesdirective&d=admin');
					sm_title($lang['module_cookiesdirective']['module_cookiesdirective'].' - '.$lang['settings']);
					$ui = new UI();
					if (!empty($error_message))
						$ui->NotificationError($error_message);
					$f=new Form('index.php?m='.sm_current_module().'&d=savesettings');
					$f->AddSelect('cookiesdirective_on', $lang['status'], Array(1, 0), Array($lang['common']['enabled'], $lang['common']['disabled']))->WithValue(sm_settings('cookiesdirective_on'));
					$f->AddSelect('cookiesdirective_position', $lang['position'], Array('top', 'bottom'), Array($lang['module_cookiesdirective']['top'], $lang['module_cookiesdirective']['bottom']))->WithValue(sm_settings('cookiesdirective_position'));
					$f->AddText('cookiesdirective_background_color', $lang['module_cookiesdirective']['background_color'])->WithValue(sm_settings('cookiesdirective_background_color'));
					$f->AddText('cookiesdirective_background_opacity', $lang['module_cookiesdirective']['background_opacity'])->WithValue(sm_settings('cookiesdirective_background_opacity'));
					$f->AddText('cookiesdirective_duration', $lang['module_cookiesdirective']['message_duration'])->WithValue(sm_settings('cookiesdirective_duration'));
					$f->AddText('cookiesdirective_font_color', $lang['module_cookiesdirective']['font_color'])->WithValue(sm_settings('cookiesdirective_font_color'));
					$f->AddText('cookiesdirective_font_size', $lang['module_cookiesdirective']['font_size'])->WithValue(sm_settings('cookiesdirective_font_size'));
					$f->AddText('cookiesdirective_font_family', $lang['module_cookiesdirective']['font_family'])->WithValue(sm_settings('cookiesdirective_font_family'));
					$f->AddText('cookiesdirective_zindex', $lang['module_cookiesdirective']['zindex'])->WithValue(sm_settings('cookiesdirective_zindex'));
					$f->AddTextarea('cookiesdirective_message', $lang['module_cookiesdirective']['message_at_banner'])->WithValue(sm_settings('cookiesdirective_message'));
					$f->AddText('cookiesdirective_extra_button_style', $lang['module_cookiesdirective']['extra_button_style'])->WithValue(sm_settings('cookiesdirective_extra_button_style'));
					$f->AddText('cookiesdirective_extra_container_style', $lang['module_cookiesdirective']['extra_container_style'])->WithValue(sm_settings('cookiesdirective_extra_container_style'));
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					$ui->Output(true);
				}
			if (sm_action('install'))
				{
					sm_register_module('cookiesdirective', $lang['module_cookiesdirective']['module_cookiesdirective']);
					sm_add_settings('cookiesdirective_on', 1);
					sm_add_settings('cookiesdirective_message', $lang['module_cookiesdirective']['default_messages'][0]);
					sm_add_settings('cookiesdirective_position', 'bottom');
					sm_add_settings('cookiesdirective_background_color', '#ececec');
					sm_add_settings('cookiesdirective_duration', 20);
					sm_add_settings('cookiesdirective_background_opacity', 80);
					sm_add_settings('cookiesdirective_font_color', '#000000');
					sm_add_settings('cookiesdirective_font_size', '12px');
					sm_add_settings('cookiesdirective_font_family', 'verdana');
					sm_add_settings('cookiesdirective_extra_button_style', '');
					sm_add_settings('cookiesdirective_extra_container_style', '');
					sm_add_settings('cookiesdirective_zindex', '65535');
					sm_register_autoload('cookiesdirective');
					sm_notify($lang['operation_completed']);
					sm_redirect('index.php?m=cookiesdirective&d=admin');
				}
			if (sm_action('uninstall'))
				{
					sm_unregister_module('cookiesdirective');
					sm_delete_settings('cookiesdirective_on');
					sm_delete_settings('cookiesdirective_message');
					sm_delete_settings('cookiesdirective_position');
					sm_delete_settings('cookiesdirective_background_color');
					sm_delete_settings('cookiesdirective_duration');
					sm_delete_settings('cookiesdirective_font_color');
					sm_delete_settings('cookiesdirective_font_size');
					sm_delete_settings('cookiesdirective_font_family');
					sm_delete_settings('cookiesdirective_extra_button_style');
					sm_delete_settings('cookiesdirective_extra_container_style');
					sm_delete_settings('cookiesdirective_zindex');
					sm_unregister_autoload('cookiesdirective');
					sm_notify($lang['operation_completed']);
					sm_redirect('index.php?m=admin&d=modules');
				}
		}
