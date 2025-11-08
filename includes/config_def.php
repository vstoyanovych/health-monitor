<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------
	//|                                                                            |
	//| Config defaults. Do not edit or delete this file.                          |
	//| Use config_usr.php to define or rewrite them                               |
	//|                                                                            |
	//------------------------------------------------------------------------------

	//Use protect code (captcha). 1 - on, 0 - off
	$_settings['use_protect_code']=1;
	
	$_settings['disallowed_upload_extensions']='php|phps|php3|php4|php5|htm|xhtml|html|exe|sh|pl|py|py3|bash|zsh|csh|ksh|cmd|wsf|bat|bin|com|lnk|pif|vb|vbs|vbscript|ws';
	
	$_settings['packages_upload_allowed']=true;

	$_settings['show_script_info'] = 'off';
	
	$_settings['version'] = '1.6.23	';

	if (sm_empty_settings('htmlescapecharset'))
		{
			if (sm_strpos($initialStatementDB, '1251'))
				$_settings['htmlescapecharset']='cp1251';
			elseif (sm_strpos($initialStatementDB, '1252'))
				$_settings['htmlescapecharset']='cp1252';
			else
				$_settings['htmlescapecharset']='UTF-8';
		}
