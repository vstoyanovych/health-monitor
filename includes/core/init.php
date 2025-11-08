<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.23
	//#revision 2023-08-27
	//==============================================================================

	use SM\Common\Output\PageGeneration;
	use SM\SM;

	if (is_array($siman_useragent_blacklist))
		for ($i = 0; $i < sm_count($siman_useragent_blacklist); $i++)
			{
				if (sm_strpos(strtolower($_SERVER['HTTP_USER_AGENT']), strtolower($siman_useragent_blacklist[$i])) !== false)
					{
						@header("HTTP/1.0 403 Forbidden");
						exit('Acceess denied');
					}
			}
	if ($siman_block_empty_useragent && sm_strlen($_SERVER['HTTP_USER_AGENT'])==0 && $special['cli']!==true)
		{
			@header("HTTP/1.0 403 Forbidden");
			exit('Acceess denied');
		}

	if (!empty($siman_cache) && file_exists(SM::TemporaryFilesPath().'cache_'.md5($_SERVER['REQUEST_URI'])))
		{
			if (filectime(SM::TemporaryFilesPath().'cache_'.md5($_SERVER['REQUEST_URI']))+$siman_cache<time())
				unlink(SM::TemporaryFilesPath().'cache_'.md5($_SERVER['REQUEST_URI']));
			else
				{
					$fh = fopen(SM::TemporaryFilesPath().'cache_'.md5($_SERVER['REQUEST_URI']), 'rb');
					fpassthru($fh);
					exit;
				}
		}

	if (empty($sm['disable_session']))
		{
			session_start();
		}

	$_getvars = $_GET;
	$_postvars = $_POST;
	$_cookievars = $_COOKIE;
	$_servervars = $_SERVER;
	$_uplfilevars = $_FILES;
	if (isset($_getvars['m']))
		$_getvars['m']=(string)$_getvars['m'];
	if (isset($_getvars['d']))
		$_getvars['d']=(string)$_getvars['d'];
	if (empty($sm['disable_session']))
		{
			if (!empty($_SESSION) && is_array($_SESSION))
				foreach ($_SESSION as $key=>$val)
					{
						if (strcmp(substr($key, 0, sm_strlen(sm_session_prefix())), sm_session_prefix()) == 0)
							{
								$key = substr($key, sm_strlen(sm_session_prefix()));
								$_sessionvars[$key] = $val;
							}
					}
		}

	$special['main_tpl'] = 'index';
	$special['page_url'] = 'index.php';
	if (!empty($_servervars['QUERY_STRING']))
		$special['page_url'] .= '?'.$_servervars['QUERY_STRING'];
	$singleWindow = 0;

	$special['printmode'] = 'off';
	if (!empty(sm_getvars('printmode')))
		{
			if (sm_getvars('printmode') == 'on' || sm_getvars('printmode') == 1)
				{
					PageGeneration::SetPrintMode();
				}
		}
	if (!empty(sm_getvars('ajax')))
		{
			if (sm_getvars('ajax') == 1 || sm_getvars('ajax') == 'on')
				{
					$special['ajax'] = 1;
					$special['main_tpl'] = 'simpleout';
					$singleWindow = 1;
				}
		}
	if (!empty(sm_getvars('theonepage')))
		{
			if (sm_getvars('theonepage')==1 || sm_getvars('theonepage')=='on')
				{
					PageGeneration::SetOutputMainBlockOnly();
				}
		}
	if (!empty(sm_getvars('chngdsrc')))
		{
			if (is_numeric(sm_getvars('chngdsrc')))
				{
					if (!empty($_settings['allowed_db_prefixes'][sm_getvars('chngdsrc')]))
						$_sessionvars['overwritedbprefix'] = $_settings['allowed_db_prefixes'][sm_getvars('chngdsrc')];
				}
		}
	if (!empty($_sessionvars['overwritedbprefix']))
		{
			if ($tableusersprefix == $tableprefix)
				$tableusersprefix = $_sessionvars['overwritedbprefix'];
			$tableprefix = $_sessionvars['overwritedbprefix'];
		}

	$sm['g'] =& $_getvars;
	$sm['p'] =& $_postvars;
	$sm['server'] =& $_servervars;
	$sm['cookies'] =& $_cookievars;
	$sm['files'] =& $_uplfilevars;
	$sm['session'] =& $_sessionvars;
	$sm['s'] =& $special;
	$sm['t'] =& $tableprefix;
	$sm['tu'] =& $tableusersprefix;
	$sm['output_replacers']=[];
	$sm['cacheit']=false;

	$sm['other']['includedlanguages']=[];

	$sm['s']['page_system_id'] = 'smp'.microtime(true).$sm['s']['rand'];
	$sm['s']['customcss']=[];
	$sm['s']['cssfiles']=[];
	$sm['s']['customjs']=[];
	$sm['s']['path']=[];
	$sm['s']['pagetitle']='';
	$sm['s']['document']['headdef']='';
	$sm['s']['document']['headend']='';
	$sm['s']['document']['bodyend']='';
	$sm['s']['document']['body_onload']='';
	$sm['s']['document']['bodymodifier']='';
	$sm['s']['textout']='';
