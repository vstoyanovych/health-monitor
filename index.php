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

	if (function_exists('get_magic_quotes_gpc') && !in_array(php_sapi_name(), Array('cli', 'cgi-fcgi')) && @get_magic_quotes_gpc() == 1)
		exit('Configuration error! magic_quotes_gpc is on.');
	if (!file_exists('files/temp'))
		exit('SiMan CMS is not installed!');

	define("SIMAN_DEFINED", 1);

	$special['rand'] = rand();
	$special['time']['generation_begin'] = microtime(true);
	require_once("includes/core/basic.php");
	require_once("includes/dbsettings.php");
	require_once("includes/dbengine".$serverDB.".php");
	require_once("includes/dbelite.php");
	require_once("includes/simplyquery.php");
	if (file_exists("includes/core/init_usr.php"))
		require_once("includes/core/init_usr.php");
	require_once("includes/core/init.php");
	require_once("includes/functions.php");
	require_once("includes/smcore.php");
	if (isset($sm['afterinit_usr']) && $sm['afterinit_usr'] && file_exists("includes/core/afterinit_usr.php"))
		require_once("includes/core/afterinit_usr.php");
	require_once('ext/tplengines/smarty2/siman_config.php');

	if (!isset($lnkDB))
		$lnkDB = @database_connect($hostNameDB, $userNameDB, $userPasswordDB, $nameDB);
	if ($lnkDB != false)
		{
			if (!empty($initialStatementDB))
				$result = database_query($initialStatementDB, $lnkDB);
			require_once("includes/core/rewrite.php");
			$special['page']['url'] = ((!empty($_SERVER['HTTPS'])) ? "https://" : "http://").$_SERVER['SERVER_NAME'].(empty($_SERVER['SERVER_PORT']) || $_SERVER['SERVER_PORT']=='80'?'':':'.$_SERVER['SERVER_PORT']).$_SERVER['REQUEST_URI'];
			$special['page']['parsed_url'] = @parse_url($special['page']['url']);
			$special['page']['scheme'] = $special['page']['parsed_url']['scheme'];
			require("includes/config.php");
			$sm['_s'] =& $_settings;
			if (intval(sm_settings('resource_url_rewrite')) == 1)
				$special['resource_url'] = $special['page']['parsed_url']['host'].substr(sm_settings('resource_url'), sm_strpos(sm_settings('resource_url'), '/'));
			else
				$special['resource_url'] = sm_settings('resource_url');
			if ($_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == substr($special['resource_url'], sm_strpos($special['resource_url'], '/')).'index.php')
				sm_redirect_now(sm_homepage(), 301);
			if (!sm_empty_settings('default_timezone'))
				date_default_timezone_set(sm_settings('default_timezone'));
			$sm['s']['home_url']=sm_homepage();
			if (sm_empty_settings('database_date'))
				$special['dberror'] = true;
		}
	else
		$special['dberror'] = true;
	
	if (sm_is_tpl_engine_enabled())
		sm_tpl_init_engine();

	if (empty($special['dberror']))
		{
			if ($special['deviceinfo']['is_mobile'])
				{
					if (!sm_empty_settings('resource_url_mobile') && $special['resource_url'] == sm_settings('resource_url'))
						{
							sm_redirect($special['page']['scheme'].'://'.sm_settings('resource_url_mobile'));
						}
				}
			if ($special['deviceinfo']['is_tablet'])
				{
					if (!sm_empty_settings('resource_url_tablet') && $special['resource_url'] == sm_settings('resource_url'))
						{
							sm_redirect($special['page']['scheme'].'://'.sm_settings('resource_url_tablet'));
						}
				}

			sm_change_language(sm_settings('default_language'));

			sm_change_theme(sm_settings('default_theme'));

			$module = !empty(sm_getvars('m'))?sm_getvars('m'):'';
			$mode = !empty(sm_getvars('d'))?sm_getvars('d'):'';

			$special['sql']['count'] = 0;

			sm_is_index_page();

			if (empty($module))
				{
					$module=sm_settings('default_module');
					$mode='';
					unset($_getvars['d']);
				}
			elseif (!sm_is_valid_modulename($module))
				$module='404';
			

			if (!sm_is_module_supported($module))
				$module = '404';

			if (!sm_empty_settings('banned_ip'))
				{
					$banip = explode(' ', sm_settings('banned_ip'));
					for ($i = 0; $i < sm_count($banip); $i++)
						{
							if (strcmp($banip[$i], sm_ip_address()) == 0)
								{
									@header('HTTP/1.0 403 Forbidden');
									@header('Retry-After: 3600');
									if (sm_is_tpl_engine_enabled())
										{
											sm_tpl_error('banerror');
										}
									else
										print('You are disallowed to view this website');
									exit;
								}
						}
				}
			if (!sm_empty_settings('autoban_ips'))
				{
					$banip = nllistToArray(sm_settings('autoban_ips'));
					for ($i = 0; $i < sm_count($banip); $i++)
						{
							if (strcmp($banip[$i], sm_ip_address()) == 0)
								{
									if (intval(sm_tempdata_aggregate('bannedip', sm_ip_address(), SM_AGGREGATE_COUNT)) > 0)
										{
											if (sm_is_tpl_engine_enabled())
												{
													@header('HTTP/1.0 403 Forbidden');
													@header('Retry-After: 3600');
													sm_tpl_error('banerror');
												}
											exit;
										}
									else
										{
											//unblock this person
											sm_update_settings('autoban_ips', removefrom_nllist(sm_get_settings('autoban_ips'), sm_ip_address()));
											sm_tempdata_clean('bannedip', sm_ip_address());
										}
								}
						}
				}
			if (!sm_empty_settings('install_not_erased'))
				{
					if (file_exists('./install') || file_exists('./upgrade') || file_exists('./includes/update.php'))
						{
							if (sm_is_tpl_engine_enabled())
								{
									sm_tpl_error('noterasedinstall');
								}
							exit;
						}
					else
						{
							sm_update_settings('install_not_erased', '');
						}
				}

			UserDataMaintainer::Init();
			$sm['u'] =& $userinfo;
			//Autologin feature
			if (!SM::isLoggedIn() && !empty($_cookievars[sm_settings('cookprefix').'simanautologin']))
				{
					$tmpusrinfo = getsql("SELECT * FROM ".sm_global_table_prefix()."users WHERE md5(concat('".sm_session_prefix()."', random_code, id_user))='".dbescape($_cookievars[sm_settings('cookprefix').'simanautologin'])."' AND user_status>0 LIMIT 1");
					if (!empty($tmpusrinfo['id_user']) && ($tmpusrinfo['user_status']<3 || $tmpusrinfo['user_status']==3 && $tmpusrinfo['id_user']!=1 && intval(sm_settings('disable_level3_autologin'))!=1 || $tmpusrinfo['id_user']==1 && intval(sm_settings('superuser_autologin_enabled'))==1))
						{
							sm_login($tmpusrinfo['id_user'], $tmpusrinfo);
							UserDataMaintainer::Init();
							log_write(LOG_LOGIN, $lang['module_account']['log']['user_logged'].' - '.$lang['common']['auto_login']);
							$sm['s']['autologin'] = 1;
						}
					else
						{
							setcookie(sm_settings('cookprefix').'simanautologin', '');
						}
					unset($tmpusrinfo);
				}

			if (SM::isAdministrator() && !sm_empty_settings('ext_editor'))
				require('ext/editors/'.sm_settings('ext_editor').'/siman_config.php');

			$special['meta']['keywords'] = sm_settings('meta_keywords');
			$special['meta']['description'] = sm_settings('meta_description');

			include('includes/core/preload.php');
			if ($singleWindow == 1)
				{
					$modules_index = 0;
					$sm['modules'] =& $modules;
					$sm['index'] =& $modules_index;
					$m =& $modules[$modules_index];
					sm_call_action($module, sm_getvars('d'));
					sm_event('aftermainsection');
					if (sm_is_tpl_engine_enabled())
						{
							sm_tpl_assign_by_ref('_settings', $_settings);
							sm_tpl_assign_by_ref('lang', $lang);
							sm_tpl_assign_by_ref('special', $special);
							sm_tpl_display($special['main_tpl']);
						}
				}
			else
				{
					if (sm_get_array_value($sm['s'], 'autologin') == 1)
						sm_event('successlogin', array($userinfo['id']));

					$special['categories']['id'] = 0;

					//Main module loading begin
					$modules_index = 0;
					$modules[$modules_index]['panel'] = 'center';
					$sm['modules'] =& $modules;
					$sm['index'] =& $modules_index;
					$m =& $modules[$modules_index];
					$sm['m'] =& $modules[$modules_index];
					if (!empty($special['no_borders_main_block']))
						$modules[$modules_index]['borders_off'] = 1;
					sm_event('beforemainblock');
					sm_call_action($module, sm_get_array_value($_getvars, 'd'));
					sm_event('aftermainblock');
					if (empty($modules[$modules_index]['module']))
						{
							$modules[$modules_index]['module'] = '404';
							$special['is_index_page'] = 0;
						}
					if (!empty($special['dont_take_a_title']) && $special['dont_take_a_title'] != 1)
						$special['pagetitle'] = $modules[$modules_index]['title'];
					if (sm_is_index_page() && !sm_empty_settings('rewrite_index_title'))
						$special['pagetitle'] = sm_settings('rewrite_index_title');
					sm_event('aftermainsection');
					//Main module loading end

					if (empty($special['no_blocks']))
						{
							sm_event('beforestaticblocks');
							include('includes/core/staticblocks.php');
							sm_event('afterstaticblocks');
						}

					include('includes/core/postload.php');

					//Final initialization
					sm_event('beforetplgenerate');
					$special['pathcount'] = sm_count($special['path']);
					if (sm_is_tpl_engine_enabled())
						{
							sm_tpl_assign_by_ref('userinfo', $userinfo);
							sm_tpl_assign_by_ref('modules', $modules);
							sm_tpl_assign_by_ref('refresh_url', $refresh_url);
							sm_tpl_assign_by_ref('lang', $lang);
							sm_tpl_assign_by_ref('_settings', $_settings);
							sm_tpl_assign_by_ref('sm', $sm);
							if (isset($sm['final_tpl_assignment_functions']) && is_array($sm['final_tpl_assignment_functions']))
								{
									foreach ($sm['final_tpl_assignment_functions'] as $final_tpl_assignment_function)
										$final_tpl_assignment_function();
								}
						}
					$special['time']['generation_end'] = microtime(true);
					$special['time']['generation_time'] = round($special['time']['generation_end'] - $special['time']['generation_begin'], 4);
					if (sm_is_tpl_engine_enabled())
						sm_tpl_assign_by_ref('special', $special);

					sm_session_close();

					//Send headers before output
					if (!headers_sent())
						{
							if (!empty($refresh_url) && $special['dontsendredirectheaders'] != true)
								@header('Location: '.$refresh_url);
							if ((empty($modules[0]['module']) || $modules[0]['module'] == '404') && !empty($special['header_error_code']))
								@header($_servervars['SERVER_PROTOCOL']." ".$special['header_error_code']);
							elseif (empty($modules[0]['module']) || $modules[0]['module'] == '404')
								@header("HTTP/1.0 404 Not Found");
							@header('Content-type: text/html; charset='.sm_encoding());
						}

					//Output page
					if (!empty($special['main_tpl']))
						if (sm_is_tpl_engine_enabled())
							{
								if (!empty($siman_cache) && $sm['cacheit'] && !SM::isLoggedIn() || is_array($sm['output_replacers']) && sm_count($sm['output_replacers'])>0)
									{
										$output = sm_tpl_fetch_output($special['main_tpl']);
										if (is_array($sm['output_replacers']) && sm_count($sm['output_replacers'])>0)
											{
												$output = sm_tpl_fetch_output($special['main_tpl']);
												for ($i = 0; $i < sm_count($sm['output_replacers']); $i++)
													{
														if (function_exists($sm['output_replacers'][$i]))
															$output=call_user_func_array($sm['output_replacers'][$i], Array($output));
													}
											}
										if (!empty($siman_cache) && $sm['cacheit'] && !SM::isLoggedIn())
											{
												$fname=SM::TemporaryFilesPath().'cache_'.md5($_SERVER['REQUEST_URI']);
												$fh=fopen($fname, 'w');
												fwrite($fh, $output);
												fclose($fh);
												if (intval($sm['cacheittime'])>0)
													touch($fname, time()+intval($sm['cacheittime']));
											}
										print($output);
									}
								else
									sm_tpl_display($special['main_tpl']);
							}
					sm_event('aftertplgenerate');
				}
		}
	else
		{
			@header('HTTP/1.0 503 Service Unavailable');
			@header('Retry-After: 3600');
			if (!sm_is_tpl_engine_enabled())
				exit('Service Unavailable');
			else
				{
					exit('<center><b>Error</b><br>Unable to connect to the database. Please try again later.</center>');
				}
		}
