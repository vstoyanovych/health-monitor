<?php

	//------------------------------------------------------------------------------
	//|                                                                            |
	//|            Content Management System SiMan CMS                             |
	//|                                                                            |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.23
	//#revision 2023-08-27
	//==============================================================================


	use SM\Common\Output\PageGeneration;
	use SM\Core\SessionMaintainer;
	use SM\Core\UserDataMaintainer;
	use SM\SM;

	function sm_delete_settings($settings_name, $mode = 'default')
		{
			execsql("DELETE FROM ".sm_table_prefix()."settings WHERE name_settings = '".dbescape($settings_name)."' AND mode='".dbescape($mode)."'");
		}

	function sm_get_settings($settings_name, $mode = 'default')
		{
			return getsqlfield("SELECT value_settings FROM ".sm_table_prefix()."settings WHERE name_settings = '".dbescape($settings_name)."' AND mode='".dbescape($mode)."' LIMIT 1");
		}

	//Alias for sm_new_settings
	function sm_add_settings($settings_name, $settings_value, $mode = 'default')
		{
			global $sm;
			execsql("INSERT INTO ".sm_table_prefix()."settings (name_settings, value_settings, mode) VALUES  ('".dbescape($settings_name)."', '".dbescape($settings_value)."', '".dbescape($mode)."')");
			if ($mode=='default')
				$sm['_s'][$settings_name]=$settings_value;
		}

	/** @deprecated */
	function sm_new_settings($settings_name, $settings_value, $mode = 'default')
		{
			sm_add_settings($settings_name, $settings_value, $mode);
		}

	function sm_update_settings($settings_name, $new_value, $mode = 'default')
		{
			global $sm;
			execsql("UPDATE ".sm_table_prefix()."settings SET value_settings = '".dbescape($new_value)."' WHERE name_settings = '".dbescape($settings_name)."' AND mode='".dbescape($mode)."'");
			if ($mode=='default')
				$sm['_s'][$settings_name]=$new_value;
		}

	function sm_set_settings($settings_name, $new_value, $mode = 'default')
		{
			$info=TQuery::ForTable(sm_table_prefix().'settings')
				->AddWhere('name_settings', dbescape($settings_name))
				->AddWhere('mode', dbescape($mode))
				->Get();
			if (empty($info['name_settings']))
				sm_add_settings($settings_name, $new_value, $mode);
			else
				sm_update_settings($settings_name, $new_value, $mode);
		}

	function sm_register_module($module_name, $module_title, $search_fields = '', $search_doing = '', $search_var = '', $search_table = '', $search_title = '', $search_idfield = '', $search_text = '')
		{
			execsql("INSERT INTO ".sm_table_prefix()."modules (module_name, module_title, search_fields, search_doing, search_var, search_table, search_title, search_idfield, search_text) VALUES ('".dbescape($module_name)."', '".dbescape($module_title)."', '".dbescape($search_fields)."', '".dbescape($search_doing)."', '".dbescape($search_var)."', '".dbescape($search_table)."', '".dbescape($search_title)."', '".dbescape($search_idfield)."', '".dbescape($search_text)."');");
			$installed_packages = addto_nllist(sm_settings('installed_packages'), $module_name);
			sm_update_settings('installed_packages', $installed_packages);
		}

	function sm_unregister_module($module_name)
		{
			execsql("DELETE FROM ".sm_table_prefix()."modules WHERE module_name = '".dbescape($module_name)."'");
			$installed_packages = removefrom_nllist(sm_settings('installed_packages'), $module_name);
			sm_update_settings('installed_packages', $installed_packages);
		}

	function sm_is_installed($module_name)
		{
			return in_array($module_name, nllistToArray(sm_settings('installed_packages')));
		}

	function sm_register_autoload($module_name)
		{
			$autoload_modules = addto_nllist(sm_settings('autoload_modules'), $module_name);
			sm_update_settings('autoload_modules', $autoload_modules);
		}

	function sm_unregister_autoload($module_name)
		{
			$autoload_modules = removefrom_nllist(sm_settings('autoload_modules'), $module_name);
			sm_update_settings('autoload_modules', $autoload_modules);
		}

	function sm_register_postload($module_name)
		{
			$postload_modules = addto_nllist(sm_settings('postload_modules'), $module_name);
			sm_update_settings('postload_modules', $postload_modules);
		}

	function sm_unregister_postload($module_name)
		{
			$postload_modules = removefrom_nllist(sm_settings('postload_modules'), $module_name);
			sm_update_settings('postload_modules', $postload_modules);
		}

	function sm_add_cssfile($fname, $includeAsIs = false)
		{
			global $sm;
			if (empty($fname))
				return false;
			if ($includeAsIs !== 1 && $includeAsIs !== true && sm_strpos($fname, '://') === false)
				{
					if (file_exists('themes/'.sm_current_theme().'/'.$fname))
						$fname = 'themes/'.sm_current_theme().'/'.$fname;
					else
						$fname = 'themes/default/'.$fname;
				}
			if (!is_array($sm['s']['customcss']) || !in_array($fname, $sm['s']['customcss']))
				$sm['s']['customcss'][]=$fname;
			return $sm['s']['customcss'][sm_count($sm['s']['customcss']) - 1];
		}

	function sm_add_jsfile($fname, $includeAsIs = false, $params=[], $document_position='headend')
		{
			global $sm;
			if (empty($fname))
				return false;
			if ($includeAsIs !== 1 && $includeAsIs !== true && sm_strpos($fname, '://') === false)
				{
					if (file_exists('themes/'.sm_current_theme().'/'.$fname))
						$fname = 'themes/'.sm_current_theme().'/'.$fname;
					else
						$fname = 'themes/default/'.$fname;
				}
			if (!is_array($sm['s']['customjs']) || !in_array($fname, $sm['s']['customjs']))
				{
					$sm['s']['customjs'][] = $fname;
					$sm['s']['customjs_params'][] = $params;
					$sm['s']['customjs_position'][] = $document_position;
				}
			return $sm['s']['customjs'][sm_count($sm['s']['customjs']) - 1];
		}

	function sm_userinfo($id, $srchfield = 'id_user')
		{
			if ($srchfield != 'email' && $srchfield != 'login')
				$srchfield = 'id_user';
			$sql = "SELECT * FROM ".sm_global_table_prefix()."users WHERE `".dbescape($srchfield)."`='".dbescape($id)."'";
			$result = execsql($sql);
			while ($row = database_fetch_assoc($result))
				{
					$userinfo['id'] = $row['id_user'];
					$userinfo['login'] = $row['login'];
					$userinfo['email'] = $row['email'];
					$userinfo['level'] = $row['user_status'];
					$userinfo['groups'] = $row['groups_user'];
					unset($row['password']);
					unset($row['question']);
					unset($row['answer']);
					$userinfo['info'] = $row;
				}
			if (empty($userinfo['id']))
				{
					$userinfo['id'] = '';
					$userinfo['login'] = '';
					$userinfo['email'] = '';
					$userinfo['session'] = '';
					$userinfo['level'] = 0;
					$userinfo['groups'] = '';
					$userinfo['info'] = [];
				}
			return $userinfo;
		}

	function sm_include_lang($modulename, $langname = '')
		{
			global $sm, $lang;
			if (empty($langname))
				$langname = sm_current_language();
			if (file_exists("./lang/modules/".$langname."_".$modulename.".php"))
				require("lang/modules/".$langname."_".$modulename.".php");
			elseif (file_exists("./lang/modules/en_".$modulename.".php"))
				require("lang/modules/en_".$modulename.".php");
			elseif (file_exists("./lang/modules/ukr_".$modulename.".php"))
				require("lang/modules/ukr_".$modulename.".php");
			$included_language=['module'=>$modulename, 'language'=>$langname];
			if (!isset($sm['other']['includedlanguages']) || !is_array($sm['other']['includedlanguages']) || !in_array($included_language, $sm['other']['includedlanguages']))
				$sm['other']['includedlanguages'][]=$included_language;
		}

	function sm_load_tree($tablename, $field_id, $field_root, $load_only_branches_of_this = -1, $extsqlwhere = '', $sortfield = '')
		{
			$addsql = '';
			if (!empty($extsqlwhere))
				$addsql .= ' WHERE '.$extsqlwhere;
			if ($load_only_branches_of_this>=0)
				{
					if (empty($addsql))
						$addsql .= " WHERE ";
					else
						$addsql .= " AND ";
					$addsql .= " `".dbescape($field_root)."`='".dbescape($load_only_branches_of_this)."'";
				}
			$sql = "SELECT * FROM ".sm_table_prefix().$tablename;
			$sql .= $addsql;
			$sql .= " ORDER BY `".dbescape($field_root)."`";
			if (!empty($sortfield))
				$sql .= ', `'.dbescape($sortfield).'`';
			$result = execsql($sql);
			$i = 0;
			while ($row = database_fetch_array($result))
				{
					$ctg[$i] = $row;
					$i++;
				}

			for ($i = 0; $i<sm_count($ctg); $i++)
				{
					$pos[$i] = 0;
				}
			$fistlevelposition = 0;
			$fistlevellastposition = 0;
			for ($i = 0; $i<sm_count($ctg); $i++)
				{
					if ($ctg[$i][$field_root] == 0)
						{
							$maxpos = 0;
							for ($j = 0; $j<sm_count($ctg); $j++)
								{
									if ($maxpos<$pos[$j])
										$maxpos = $pos[$j];
								}
							$pos[$i] = $maxpos+1;
							$fistlevelposition++;
							$ctg[$i]['sub_position'] = $fistlevelposition;
							$fistlevellastposition = $i;
						}
					else
						{
							$rootpos = 0;
							$childpos = -1;
							for ($j = 0; $j<sm_count($ctg); $j++)
								{
									if ($ctg[$j][$field_id] == $ctg[$i][$field_root])
										{
											$rootpos = $pos[$j];
											$ctg[$i]['level'] = $ctg[$j]['level']+1;
											$ctg[$j]['is_main'] = 1;
											$ctg[$j]['count_sub']++;
											$ctg[$j]['have_sub'] = 1;
											$ctg[$i]['sub_position'] = $ctg[$j]['count_sub'];
										}
									if ($ctg[$j][$field_root] == $ctg[$i][$field_root] && $j != $i && $childpos<$pos[$j])
										$childpos = $pos[$j];
								}
							$pos[$i] = ($rootpos>$childpos) ? ($rootpos+1) : ($childpos+1);
							for ($j = 0; $j<sm_count($ctg); $j++)
								{
									if ($pos[$j]>=$pos[$i] && $j != $i)
										$pos[$j]++;
								}
						}
				}
			if (sm_count($ctg)>0)
				{
					$ctg[0]['first'] = 1;
					$ctg[$fistlevellastposition]['last'] = 1;
				}
			for ($i = 0; $i<sm_count($ctg); $i++)
				{
					$rctg[$pos[$i]-1] = $ctg[$i];
				}

			return $rctg;
		}

	function sm_get_path_tree($tablename, $field_id, $field_root, $start_id, $stop_id = 0)
		{
			if ($start_id == $stop_id) return Array();
			$sql = "SELECT * FROM $tablename ORDER BY IF ($field_id=$start_id, 0 ,1), $field_id";
			$r = getsqlarray($sql);
			if (sm_count($r)<=0) return Array();
			$pos[0] = 0;
			$curpos = 0;
			$iteration = 0;
			while ($r[$pos[$curpos]][$field_root] != $stop_id && $iteration<=sm_count($r))
				{
					$u = 0;
					for ($i = 1; $i<sm_count($r); $i++)
						{
							if ($r[$i][$field_id] == $r[$pos[$curpos]][$field_root])
								{
									$curpos++;
									$pos[$curpos] = $i;
									$u = 1;
									break;
								}
						}
					if ($u == 0) return Array(); //broken tree
					$iteration++;
				}
			$res = Array();
			for ($i = sm_count($pos)-1; $i>=0; $i--)
				{
					$res[] = $r[$pos[$i]];
				}
			return $res;
		}

	function sm_add_title_modifier(&$title)
		{
			global $special;
			$special['titlemodifier'][] =& $title;
		}

	function sm_add_content_modifier(&$content)
		{
			global $special;
			if (is_array($content))
				{
					foreach ($content as &$item)
						{
							sm_add_content_modifier($item);
						}
				}
			else
				$special['contentmodifier'][] =& $content;
		}

	function sm_getnicename($str)
		{
			global $lang;
			$nice = '';
			if (sm_encoding()=='utf-8')
				{
					if (!array_key_exists('translitmap', $lang))
						include('lang/default_translitmap.php');
					$str = mb_strtolower($str, sm_encoding());
					for ($i = 0; $i<mb_strlen($str, sm_encoding()); $i++)
						{
							$c=mb_substr($str, $i, 1, sm_encoding());
							if ($c>='a' && $c<='z' || $c>='0' && $c<='9' || $c == '.' || $c == '_' || $c == '-')
								$nice .= $c;
							elseif (!empty($lang['translitmap'][$c]))
								$nice .= $lang['translitmap'][$c];
							else
								$nice .= '-';
						}
				}
			else
				{
					$str = strtolower($str);
					for ($i = 0; $i<sm_strlen($str); $i++)
						{
							if ($str[$i]>='a' && $str[$i]<='z' || $str[$i]>='0' && $str[$i]<='9' || $str[$i] == '.' || $str[$i] == '_' || $str[$i] == '-')
								$nice .= $str[$i];
							elseif (!empty($lang['translitmap'][$str[$i]]))
								$nice .= $lang['translitmap'][$str[$i]];
							else
								$nice .= '-';
						}
				}
			while (sm_strpos($nice, '--')!==false)
				$nice=str_replace('--', '-', $nice);
			return trim($nice, '-');
		}

	function sm_event($eventname, $paramsarray = Array())
		{
			global $sm;
			if (!isset($sm['eventlisteners'][$eventname]))
				return;
			for ($i = 0; $i<sm_count($sm['eventlisteners'][$eventname]); $i++)
				{
					$eventfn = $sm['eventlisteners'][$eventname][$i];
					if (is_callable($eventfn))
						{
							$eventfn($paramsarray);
						}
					elseif (function_exists($eventfn))
						{
							if (!is_array($paramsarray))
								$paramsarray = array($paramsarray);
							call_user_func_array($eventfn, $paramsarray);
						}
				}
		}

	function sm_event_handler($eventname, $functionname)
		{
			global $sm;
			if (empty($sm['eventlisteners']) || !in_array($functionname, $sm['eventlisteners']))
				$sm['eventlisteners'][$eventname][] = $functionname;
		}

	function sm_get_attachments($fromModule, $fromId)
		{
			$sql = "SELECT * FROM ".sm_table_prefix()."downloads WHERE userlevel_download<=".SM::User()->Level()." AND attachment_from='".dbescape($fromModule)."' AND attachment_id=".intval($fromId);
			$result = execsql($sql);
			$i = 0;
			$r = Array();
			while ($row = database_fetch_object($result))
				{
					$r[$i]['id'] = $row->id_download;
					$r[$i]['filename'] = sm_getnicename($row->file_download);
					$r[$i]['leveldownload'] = $row->userlevel_download;
					$r[$i]['attachment_from'] = $row->attachment_from;
					$r[$i]['attachment_id'] = $row->attachment_id;
					$r[$i]['type'] = $row->attachment_type;
					$r[$i]['is_image'] = ($row->attachment_type == 'image/jpeg' || $row->attachment_type == 'image/jpg' || $row->attachment_type == 'image/gif' || $row->attachment_type == 'image/png');
					$r[$i]['deleteurl'] = 'index.php?m=download&d=deleteattachment&id='.$r[$i]['id'];
					$r[$i]['realfilename'] = SM::FilesPath().'download/attachment'.$r[$i]['id'];
					if (file_exists($r[$i]['realfilename']))
						$r[$i]['filesize'] = filesize($r[$i]['realfilename']);
					else
						$r[$i]['filesize'] = 0;
					if ($r[$i]['filesize']>1048576)
						$r[$i]['filesize'] = round($r[$i]['filesize']/1048576, 2).' MB';
					elseif ($r[$i]['filesize']>1024)
						$r[$i]['filesize'] = round($r[$i]['filesize']/1024, 2).' KB';
					else
						$r[$i]['filesize'] = $r[$i]['filesize'].' B';
					$r[$i]['downloadurl'] = 'downloads/attachments/'.$r[$i]['id'].'-'.$r[$i]['filename'];
					$r[$i]['viewurl'] = 'downloads/viewattachment/'.$r[$i]['id'].'-'.$r[$i]['filename'];
					$i++;
				}
			return $r;
		}

	function sm_upload_attachment($fromModule, $fromId, &$filesPointer, $userlevel = 0)
		{
			if ($filesPointer['error'] <> UPLOAD_ERR_OK)
				return false;
			$fs = $filesPointer['tmp_name'];
			if (!empty($fs))
				{
					$q=new TQuery(sm_table_prefix()."downloads");
					$q->AddString('file_download', sm_getnicename($filesPointer['name']));
					$q->AddNumeric('userlevel_download', $userlevel);
					$q->AddString('attachment_from', $fromModule);
					$q->AddNumeric('attachment_id', intval($fromId));
					$q->AddString('attachment_type', $filesPointer['type']);
					$newid = $q->Insert();
					if (empty($newid))
						return false;
					$fd = SM::FilesPath().'download/attachment'.$newid;
					if (file_exists($fd))
						unlink($fd);
					$result = move_uploaded_file($fs, $fd);
					if ($result)
						sm_event('successuploadattachment', array($newid, $fd));
					return $result;
				}
			else
				return false;
		}

	function sm_delete_attachments($fromModule, $fromId)
		{
			$r = sm_get_attachments($fromModule, $fromId);
			for ($i = 0; $i<sm_count($r); $i++)
				{
					if (file_exists($r[$i]['realfilename']))
						unlink($r[$i]['realfilename']);
					deletesql(sm_table_prefix().'downloads', 'id_download', $r[$i]['id']);
				}
		}

	function sm_delete_attachment($id)
		{
			if (file_exists(SM::FilesPath().'download/attachment'.intval($id)))
				unlink(SM::FilesPath().'download/attachment'.intval($id));
			TQuery::ForTable(sm_table_prefix().'downloads')
				->AddWhere('id_download', intval($id))
				->Remove();
		}

	function sm_upload_file($upload_var = 'userfile', $upload_path = '', $secondary_index=NULL)
		{
			global $_uplfilevars;
			if ($secondary_index===NULL)
				$fs = $_uplfilevars[$upload_var]['tmp_name'];
			else
				$fs = $_uplfilevars[$upload_var]['tmp_name'][$secondary_index];
			if (empty($upload_path))
				$upload_path = SM::TemporaryFilesPath().md5(microtime(true).mt_rand());
			if (!empty($fs))
				{
					$fd = $upload_path;
					if (file_exists($fd))
						unlink($fd);
					$res = move_uploaded_file($fs, $fd);
					if ($res !== false)
						{
							sm_event('afteruploadedfile', array($fd));
							return $upload_path;
						}
					else
						return false;
				}
			else
				return false;
		}

	function sm_detect_device($useragent = '')
		{
			global $_servervars, $_settings, $special;
			if (!sm_empty_settings('resource_url_mobile') && sm_strpos($special['page']['url'], sm_settings('resource_url_mobile')) !== false)
				{
					$result['is_desktop'] = false;
					$result['is_mobile'] = true;
					$result['is_tablet'] = false;
					$result['devicename'] = 'unknown';
					return $result;
				}
			if (!empty(sm_settings('resource_url_tablet')) && sm_strpos($special['page']['url'], sm_settings('resource_url_tablet')) !== false)
				{
					$result['is_desktop'] = false;
					$result['is_mobile'] = false;
					$result['is_tablet'] = true;
					$result['devicename'] = 'unknown';
					return $result;
				}
			if (empty($useragent))
				{
					$useragent = sm_get_array_value($_servervars, 'HTTP_USER_AGENT');
					$wapprofile = sm_get_array_value($_servervars, 'HTTP_X_WAP_PROFILE');
					$httpprofile = sm_get_array_value($_servervars, 'HTTP_PROFILE');
					$httpaccept = sm_get_array_value($_servervars, 'HTTP_ACCEPT');
				}
			else
				{
					$wapprofile = '';
					$httpprofile = '';
					$httpaccept = '';
				}
			$result['is_desktop'] = false;
			$result['is_mobile'] = false;
			$result['is_tablet'] = false;
			$result['devicename'] = 'unknown';
			$mobileDevices = array(
				"android" => "android",
				"blackberry" => "blackberry",
				"iphone" => "(iphone|ipod)",
				"opera" => "opera mini",
				"palm" => "(avantgo|blazer|elaine|hiptop|palm|plucker|xiino)",
				"windows" => "windows ce; (iemobile|ppc|smartphone)",
				"generic" => "(kindle|mobile|mmp|midp|o2|pda|pocket|psp|symbian|smartphone|treo|up.browser|up.link|vodafone|wap)"
			);
			$tabletDevices = array(
				"ipad" => "ipad"
			);
			if (isset($wapprofile) || isset($httpprofile))
				{
					$result['is_mobile'] = true;
				}
			elseif (sm_strpos($useragent, 'text/vnd.wap.wml')>0 || sm_strpos($httpaccept, 'application/vnd.wap.xhtml+xml')>0)
				{
					$result['is_mobile'] = true;
				}
			foreach ($mobileDevices as $device => $regexp)
				{
					if (preg_match("/".$regexp."/i", $useragent))
						{
							$result['is_mobile'] = true;
							$result['devicename'] = $device;
							break;
						}
				}
			foreach ($tabletDevices as $device => $regexp)
				{
					if (preg_match("/".$regexp."/i", $useragent))
						{
							$result['is_mobile'] = false;
							$result['is_tablet'] = true;
							$result['devicename'] = $device;
							break;
						}
				}
			if ($result['is_mobile'] === false && $result['is_tablet'] === false)
				$result['is_desktop'] = true;
			return $result;
		}

	function sm_redirect($url, $message = '', $dontsendredirectheaders = false)
		{
			global $modules, $modules_index, $refresh_url, $lang, $sm;
			if (empty($modules[$modules_index]['title']))
				$modules[$modules_index]['title'] = $lang['common']['redirect'];
			sm_template('refresh');
			sm_set_action('redirect-view-action');
			if ($message === true)
				{
					$message = '';
					$dontsendredirectheaders = true;
				}
			$modules[$modules_index]['message'] = $message;
			$sm['s']['dontsendredirectheaders'] = $dontsendredirectheaders;
			if (is_array($url))
				{
					for ($i = 0; $i<sm_count($url); $i++)
						if (!empty($url[$i]))
							{
								$refresh_url = $url[$i];
								break;
							}
				}
			else
				$refresh_url = $url;
			if (sm_strpos($refresh_url, '://')===false && substr($refresh_url, 0, 1)!='/')
				$refresh_url=sm_homepage().$refresh_url;
			SessionMaintainer::WriteNotificationsFor($refresh_url);
		}

	function sm_redirect_now($url, $header_http_code='')
		{
			global $sm;
			if (is_numeric($header_http_code))
				{
					if (intval($header_http_code)==301)
						$header_http_code='301 Moved Permanently';
				}
			if (is_array($url))
				{
					for ($i = 0; $i<sm_count($url); $i++)
						if (!empty($url[$i]))
							{
								$refresh_url=$url[$i];
								break;
							}
				}
			else
				$refresh_url=$url;
			if (sm_strpos($refresh_url, '://')===false && substr($refresh_url, 0, 1)!='/')
				$refresh_url=sm_homepage().$refresh_url;
			SessionMaintainer::WriteNotificationsFor($refresh_url);
			sm_session_close();
			@header('Location: '.$refresh_url);
			if (!empty($header_http_code))
				@header($sm['server']['SERVER_PROTOCOL']." ".$header_http_code);
			exit;
		}

	function sm_is_redirection()
		{
			global $refresh_url;
			return !empty($refresh_url);
		}

	function sm_page_viewid($id, $rewriteanyway = false)
		{
			global $sm;
			if (sm_is_main_block() || $rewriteanyway)
				{
					$sm['s']['page']['viewid'] = $id;
					sm_add_body_class('sm-'.$sm['s']['page']['viewid']);
				}
		}

	/** @deprecated */
	function sm_extcore()
		{
		}

	function sm_set_userfield($userid, $fieldname, $value)
		{
			global $userinfo, $_sessionvars;
			$q = new TQuery(sm_global_table_prefix()."users");
			$q->AddString(dbescape($fieldname), $value);
			$q->Update('id_user', intval($userid));
			if (!in_array($fieldname, Array('info', 'groups', 'id', 'login', 'level')) && $userid == SM::User()->ID())
				{
					if (sm_strcmp($fieldname, 'email') == 0)
						$_sessionvars['userinfo_email'] = $value;
					$userinfo['info'][$fieldname] = $value;
					$_sessionvars['userinfo_allinfo'] = serialize($userinfo['info']);
				}
		}

	/**
	 * Initialize required vars on login
	 * @param $userid
	 * @param array $usrinfo
	 * @return bool
	 */
	function sm_login($userid, $usrinfo = Array())
		{
			global $_sessionvars;
			if (empty($usrinfo))
				$usrinfo = getsql("SELECT * FROM ".sm_global_table_prefix()."users WHERE id_user=".intval($userid)." AND user_status>0");
			if (!empty($usrinfo['id_user']))
				{
					if (empty($usrinfo['random_code']))
						{
							$usrinfo['random_code'] = md5(time().rand());
							$q = new TQuery(sm_global_table_prefix().'users');
							$q->AddString('random_code', $usrinfo['random_code']);
							$q->Update('id_user', intval($usrinfo['id_user']));
							unset($q);
						}
					$_sessionvars['userinfo_id'] = $usrinfo['id_user'];
					$_sessionvars['userinfo_login'] = $usrinfo['login'];
					$_sessionvars['userinfo_email'] = $usrinfo['email'];
					$_sessionvars['userinfo_level'] = $usrinfo['user_status'];
					$_sessionvars['userinfo_groups'] = sm_get_taxonomy('usergroups', $usrinfo['id_user']);
					unset($usrinfo['password']);
					unset($usrinfo['question']);
					unset($usrinfo['answer']);
					$_sessionvars['userinfo_allinfo'] = serialize($usrinfo);
					execsql("UPDATE ".sm_global_table_prefix()."users SET id_session='".dbescape(session_id())."', last_login='".time()."' WHERE id_user=".intval($usrinfo['id_user']));
					return true;
				}
			else
				return false;
		}

	/*
	* Return preloaded settings value for key $name without checking DB.
	* This is lightweight replacement of sm_get_settings function.
	*/
	function sm_settings($name)
		{
			global $sm;
			if (isset($sm['_s'][$name]))
				return $sm['_s'][$name];
			else
				return '';
		}

	function sm_has_settings($name)
		{
			global $sm;
			return array_key_exists($name, $sm['_s']);
		}

	function sm_empty_settings($name)
		{
			$s=sm_settings($name);
			return empty($s);
		}

	/** @deprecated */
	function sm_is_smarty_enabled()
		{
			return sm_is_tpl_engine_enabled();
		}

	function sm_is_tpl_engine_enabled()
		{
			global $sm;
			return empty($sm['s']['nosmarty']);
		}

	function sm_change_theme($themename)
		{
			global $sm;
			if (sm_is_tpl_engine_enabled())
				{
					sm_tpl_init_theme($themename);
				}
			$sm['s']['theme'] = $themename;
			if (sm_settings('sm_changetheme_default_theme') == 1)
				$sm['_s']['default_theme'] = $themename;
			if (file_exists('themes/'.$themename.'/themeinit.php'))
				include('themes/'.$themename.'/themeinit.php');
		}

	//Return true  if current action is in set $action1, $action2... or false otherwice
	// If some action is array - recurring sm_action for items will be applied
	function sm_action()
		{
			global $m;
			for ($i = 0; $i<func_num_args(); $i++)
				{
					$param = func_get_arg($i);
					if (is_array($param))
						{
							foreach ($param as $val)
								if (sm_action($val))
									return true;
						}
					elseif (sm_strcmp($m['mode'], $param) == 0)
						return true;
				}
			return false;
		}

	function sm_current_action()
		{
			global $m;
			return $m['mode'];
		}

	function sm_current_module()
		{
			global $m;
			return $m['current_module'];
		}

	//Return true  if not empty $_POST and current action is in set $action1, $action2... or false otherwice
	function sm_actionpost()
		{
			global $m, $sm;
			if (sm_count($sm['p']) == 0)
				return false;
			for ($i = 0; $i<func_num_args(); $i++)
				{
					$param = func_get_arg($i);
					if (is_array($param))
						{
							foreach ($param as $val)
								if (sm_actionpost($val))
									return true;
						}
					elseif (sm_strcmp($m['mode'], $param) == 0)
						return true;
				}
			return false;
		}

	//Change or format the parameters of the $url
	//sm_url($url, $get_param_name, $get_param_value)
	//sm_url($url, $param_replacers_array)
	// If $url is empty - using index.php
	function sm_url($url, $param_name = NULL, $param_value = NULL)
		{
			if ($param_name === NULL && $param_value === NULL)
				return $url;
			if (empty($url))
				$url = 'index.php';
			if (is_array($param_name) && $param_value === NULL)
				{
					foreach ($param_name as $key => $val)
						{
							$url = sm_url($url, $key, $val);
						}
					return $url;
				}
			if (!is_array($param_value))
				{
					$param_value=urlencode($param_value);
					if (sm_strpos($url, '?'.$param_name.'=')!==false || sm_strpos($url, '&'.$param_name.'=')!==false)
						{
							if (sm_strcmp($param_value, '')!=0)
								{
									$param_value=str_replace('$', '\\$', $param_value);
									$url=preg_replace('|(.*)([&\\?])'.$param_name.'=(.*?)&(.*)|is', '$1$2'.$param_name.'='.$param_value.'&$4', $url);
									$url=preg_replace('|(.*)([&\\?])'.$param_name.'=([^&#]*)$|is', '$1$2'.$param_name.'='.$param_value, $url);
								}
							else
								{
									$url=preg_replace('|(.*)([&\\?])'.$param_name.'=(.*?)&(.*)|is', '$1$2$4', $url);
									$url=preg_replace('|(.*)([&\\?])'.$param_name.'=([^&#]*)$|is', '$1', $url);
								}
						}
					elseif (sm_strcmp($param_value, '')!=0)
						{
							if (sm_strpos($url, '?')!==false)
								$url.='&'.$param_name.'='.$param_value;
							else
								$url.='?'.$param_name.'='.$param_value;
						}
				}
			return $url;
		}

	//Change or format the parameters of the current $url
	//sm_this_url($get_param_name, $get_param_value)
	//sm_this_url($param_replacers_array)
	//sm_this_url() - current url
	function sm_this_url($param_name = NULL, $param_value = NULL)
		{
			global $sm;
			return sm_url($sm['s']['page']['url'], $param_name, $param_value);
		}

	function sm_set_action($action)
		{
			global $m;
			if (!is_array($action))
				$m['mode'] = $action;
			else
				{
					if (array_key_exists(sm_current_action(), $action))
						$m['mode'] = $action[sm_current_action()];
					elseif (sm_count($action)>0)
						$m['mode'] = array_shift($action);
				}
		}

	function sm_default_action($action)
		{
			global $m;
			if (empty($m['mode']))
				$m['mode'] = $action;
		}

	function sm_title($title)
		{
			global $sm;
			$sm['m']['title'] = $title;
			if (sm_get_array_value($sm, 'index')==0 && isset($sm['s']['path']))
				for ($i = 0; $i < sm_count($sm['s']['path']); $i++)
					{
						if ($sm['s']['path'][$i]['tag']=='currentpage')
							$sm['s']['path'][$i]['title']=$title;
					}
			sm_add_title_modifier($sm['m']['title']);
		}

	function sm_get_title()
		{
			global $sm;
			if (empty($sm['m']['title']))
				return '';
			else
				return $sm['m']['title'];
		}

	function sm_is_empty_title()
		{
			return sm_strlen(trim(sm_get_title()))==0;
		}

	function sm_title_append($title_append)
		{
			global $sm;
			$title=$sm['m']['title'].$title_append;
			sm_title($title);
		}

	function sm_meta_title($title, $hide_site_title = true)
		{
			global $special, $_settings;
			$special['dont_take_a_title'] = 1;
			$special['pagetitle'] = $title;
			if ($hide_site_title)
				$_settings['meta_resource_title_position'] = 0;
		}

	function sm_get_meta_keywords()
		{
			global $special;
			if (!isset($special['meta']['keywords']))
				return '';
			else
				return $special['meta']['keywords'];
		}

	function sm_meta_keywords($keywodrs, $append = false)
		{
			global $special;
			if ($append)
				$special['meta']['keywords'] .= $keywodrs;
			else
				$special['meta']['keywords'] = $keywodrs;
		}

	function sm_meta_description($description, $append = false)
		{
			global $special;
			if ($append)
				$special['meta']['description'] .= $description;
			else
				$special['meta']['description'] = $description;
		}

	function sm_meta_tag($name, $content, $property='')
		{
			sm_html_headend('<meta'.(sm_strlen($property)==0?'':' property="'.htmlescape($property).'"').''.(sm_strlen($name)==0?'':' name="'.htmlescape($name).'"').' content="'.htmlescape($content).'"/>');
		}

	function sm_meta_canonical($canonical_url, $show_on_canonical_page=false)
		{
			global $sm;
			if (sm_is_index_page())
				return;
			if (sm_strpos($canonical_url, '://')===false)
				{
					if (sm_strcmp(substr($canonical_url, 0, 1), '/')==0)
						$canonical_url=substr($canonical_url, 1);
					$canonical_url='http://'.sm_settings('resource_url').$canonical_url;
				}
			if ($show_on_canonical_page || sm_strcmp(sm_this_url(), $canonical_url)!==0)
				sm_html_headend('<link rel="canonical" href="'.$canonical_url.'" />');
		}

	function sm_is_index_page()
		{
			global $sm;
			if (!array_key_exists('is_index_page', $sm['s']))
				{
					$get=$sm['g'];
					unset($get['utm_source']);
					unset($get['utm_medium']);
					unset($get['utm_campaign']);
					unset($get['utm_term']);
					unset($get['utm_content']);
					if (sm_count($get)==0)
						$sm['s']['is_index_page']=1;
					else
						$sm['s']['is_index_page']=0;
				}
			return intval($sm['s']['is_index_page'])==1;
		}
	
	function sm_homepage($use_base_resource_url=false)
		{
			global $sm;
			if (intval(sm_settings('resource_url_rewrite'))==1 && !$use_base_resource_url && !sm_is_cli())
				{
					$url=$sm['s']['page']['parsed_url']['scheme'].'://'.$sm['s']['resource_url'];
					$parts=@parse_url($url);
					return $parts['scheme'].'://'.$sm['s']['page']['parsed_url']['host'].(empty($parts['path'])?'/':$parts['path']);
				}
			else
				return $sm['s']['page']['parsed_url']['scheme'].'://'.sm_settings('resource_url');
		}

	function sm_use($libname)
		{
			global $sm;
			if ($libname=='ui' || $libname=='ui.interface') $libname='admininterface';
			if ($libname=='ui.grid') $libname='admintable';
			if ($libname=='ui.buttons') $libname='adminbuttons';
			if ($libname=='ui.form') $libname='adminform';
			if ($libname=='ui.navigation') $libname='adminnavigation';
			if ($libname=='ui.boardmessages') $libname='boardmessages';
			if ($libname=='ui.dashboard') $libname='admindashboard';
			if ($libname=='ui.tabs') $libname='admintabs';
			if ($libname=='ui.modal') $libname='ui/modal';
			if ($libname=='ui.exchange') $libname='ui/exchange';
			if ($libname=='ui.fa' || $libname=='ui.fontawesome') $libname='ui/fontawesome';
			if (file_exists('includes/'.$libname.'.php'))
				include_once('includes/'.$libname.'.php');
			elseif (file_exists('includes/lib/'.$libname.'.php'))
				include_once('includes/lib/'.$libname.'.php');
			elseif (sm_strcmp($libname, 'autocomplete')==0)
				include_once('ext/autocomplete/siman_config.php');
			elseif (sm_strcmp($libname, 'datepicker')==0)
				include_once('ext/tools/datepicker/siman_config.php');
			elseif (sm_strcmp($libname, 'maskedinput')==0)
				include_once('ext/tools/maskedinput/siman_config.php');
		}

	function sm_setfocus($dom_element, $noservicesymbol_as_id=true)
		{
			global $sm;
			if (!$noservicesymbol_as_id)
				$sm['s']['autofocus'] = $dom_element;
			else
				{
					if (!in_array(substr($dom_element, 0, 1), Array('.', '#')))
						$sm['s']['autofocus'] = '#'.$dom_element;
					else
						$sm['s']['autofocus'] = $dom_element;
				}
		}

	function sm_thumburl($filename, $maxwidth = 0, $maxheight = 0, $format = '', $quality = '', $path_null_files_img = NULL)
		{
			if ($path_null_files_img===NULL)
				$path_null_files_img = SM::FilesPath().'img/';
			$info = pathinfo($filename);
			$url = 'ext/showimage.php?img='.urlencode($info['filename']);
			if (!isset($info['extension']))
				$info['extension']='';
			if ($info['extension'] == 'png')
				$url .= '&png=1';
			if ($info['extension'] == 'gif')
				$url .= '&gif=1';
			if (sm_strpos($path_null_files_img, SM::FilesPath().'img/') == 0 && sm_strlen($path_null_files_img)>10)
				$url .= '&ext='.substr($path_null_files_img, 10);
			if (!empty($quality))
				$url .= '&quality='.$quality;
			if (!empty($format))
				$url .= '&format='.$format;
			if (!empty($maxwidth))
				$url .= '&width='.$maxwidth;
			if (!empty($maxheight))
				$url .= '&height='.$maxheight;
			return $url;
		}

	function sm_isuseringroup($userid_or_userinfo, $groupid)
		{
			if (is_array($userid_or_userinfo))
				$userid_or_userinfo = intval($userid_or_userinfo['id']);
			$groups = sm_get_taxonomy('usergroups', $userid_or_userinfo);
			return in_array($groupid, $groups);
		}

	function sm_fs_update($title, $system_url, $register_url = '', $default_extension = '.html')
		{
			if (empty($register_url))
				$register_url = sm_getnicename($title).$default_extension;
			$q = new TQuery(sm_table_prefix().'filesystem');
			$q->AddString('url_fs', $system_url);
			$q->OrderBy('id_fs');
			$info = $q->Get();
			unset($q);
			$q = new TQuery(sm_table_prefix().'filesystem');
			$q->AddString('url_fs', $system_url);
			$q->AddString('comment_fs', $title);
			$q->AddString('filename_fs', $register_url);
			if (empty($info['id_fs']))
				$q->Insert();
			else
				$q->Update('id_fs', intval($info['id_fs']));
		}

	function sm_fs_delete($system_url)
		{
			$q = new TQuery(sm_table_prefix().'filesystem');
			$q->AddString('url_fs', $system_url);
			$q->Remove();
		}

	function sm_fs_url($system_url, $return_false_on_nonexists=false, $return_cutom_url_on_nonexists='')
		{
			$q = new TQuery(sm_table_prefix().'filesystem');
			$q->AddString('url_fs', $system_url);
			$q->OrderBy('id_fs');
			$info = $q->Get();
			if (empty($info['filename_fs']))
				{
					if ($return_false_on_nonexists)
						return false;
					elseif (!empty($return_cutom_url_on_nonexists))
						return $return_cutom_url_on_nonexists;
					else
						return $system_url;
				}
			else
				return $info['filename_fs'];
		}
	
	function sm_html_headstart($html)
		{
			global $sm;
			$sm['s']['document']['headstart'].=$html;
		}

	function sm_html_headend($html)
		{
			global $sm;
			$sm['s']['document']['headend'].=$html;
		}

	function sm_html_bodystart($html)
		{
			global $sm;
			$sm['s']['document']['bodystart'].=$html;
		}

	function sm_html_bodyend($html)
		{
			global $sm;
			$sm['s']['document']['bodyend'].=$html;
		}

	function sm_html_beforepanel($html, $panelindex)
		{
			global $sm;
			$sm['s']['document']['panel'][$panelindex]['beforepanel'].=$html;
		}

	function sm_html_afterpanel($html, $panelindex)
		{
			global $sm;
			$sm['s']['document']['panel'][$panelindex]['afterpanel'].=$html;
		}

	function sm_html_beforeblock($html, $blockindex)
		{
			global $sm;
			$sm['s']['document']['block'][$blockindex]['beforeblock'].=$html;
		}

	function sm_html_afterblock($html, $blockindex)
		{
			global $sm;
			$sm['s']['document']['block'][$blockindex]['afterblock'].=$html;
		}

	function sm_notify($message, $title='', $type='success')
		{
			global $sm;
			$frompage=sm_relative_url(sm_this_url());
			if (!empty($sm['session']['notifications']) && is_array($sm['session']['notifications']))
				{
					foreach ($sm['session']['notifications'] as &$notification)
						{
							if (isset($notification['message']) && sm_strcmp($notification['message'], $message)!=0)
								break;
							if (isset($notification['title']) && sm_strcmp($notification['title'], $title)!=0)
								break;
							if (isset($notification['type']) && sm_strcmp($notification['type'], $type)!=0)
								break;
							if (isset($notification['frompage']) && sm_strcmp($notification['frompage'], $frompage)!=0)
								break;
							$notification['time']=time();
							return;
						}
				}
			$sm['session']['notifications'][]=['message'=>$message, 'title'=>$title, 'time'=>time(), 'type'=>$type, 'frompage'=>$frompage];
		}
	
	function sm_change_language($langname)
		{
			global $sm, $lang;
			require("lang/".$langname.".php");
			if (file_exists("./lang/user/".$langname.".php"))
				require("lang/user/".$langname.".php");
			$sm['s']['lang']=$langname;
			if (isset($sm['other']['includedlanguages']) && is_array($sm['other']['includedlanguages']))
				for ($i = 0; $i<sm_count($sm['other']['includedlanguages']); $i++)
					{
						sm_include_lang($sm['other']['includedlanguages'][$i]['module'], $sm['other']['includedlanguages'][$i]['language']);
					}
			if (sm_empty_settings('charset'))
				$sm['s']['charset']=$lang['charset'];
			else
				$sm['s']['charset']=sm_settings('charset');
		}
	
	function sm_current_theme()
		{
			global $sm;
			return $sm['s']['theme'];
		}

	function sm_current_language()
		{
			global $sm;
			return $sm['s']['lang'];
		}

	function sm_set_metadata($object_name, $object_id, $key_name, $val)
		{
			global $sm;
			$q=new TQuery(sm_table_prefix().'metadata');
			$q->AddString('object_name', $object_name);
			$q->AddString('object_id', $object_id);
			$q->AddString('key_name', $key_name);
			$info=$q->Get();
			if ($val===NULL)
				{
					$q->Remove();
					unset($sm['cache']['metadata'][$object_name][$object_id][$key_name]);
				}
			else
				{
					$q->AddString('val', $val);
					if (empty($info['id']))
						{
							$q->Insert();
						}
					else
						{
							$q->Update('id', intval($info['id']));
						}
					$sm['cache']['metadata'][$object_name][$object_id][$key_name]=$val;
				}
		}

	function sm_metadata($object_name, $object_id, $key_name, $dont_use_cache=false)
		{
			global $sm;
			if (isset($sm['cache']['metadata'][$object_name][$object_id][$key_name]) && !$dont_use_cache)
				return $sm['cache']['metadata'][$object_name][$object_id][$key_name];
			$q=new TQuery(sm_table_prefix().'metadata');
			$q->AddString('object_name', $object_name);
			$q->AddString('object_id', $object_id);
			$q->AddString('key_name', $key_name);
			$sm['cache']['metadata'][$object_name][$object_id][$key_name]=$q->GetField('val');
			return $sm['cache']['metadata'][$object_name][$object_id][$key_name];
		}

	function sm_load_metadata($object_name, $object_id)
		{
			global $sm;
			$q=new TQuery(sm_table_prefix().'metadata');
			$q->AddString('object_name', $object_name);
			$q->AddString('object_id', $object_id);
			$q->Open();
			$sm['cache']['metadata'][$object_name][$object_id]=[];
			while ($row=$q->Fetch())
				$sm['cache']['metadata'][$object_name][$object_id][$row['key_name']]=$row['val'];
			return $sm['cache']['metadata'][$object_name][$object_id];
		}
	
	function sm_has_metadata($object_name, $object_id, $key_name)
		{
			if (!isset($sm['cache']['metadata'][$object_name][$object_id]))
				sm_load_metadata($object_name, $object_id);
			return isset($sm['cache']['metadata'][$object_name][$object_id][$key_name]);
		}

	function sm_relative_url($url=NULL)
		{
			if ($url==NULL)
				$url=sm_this_url();
			if (sm_strpos($url, '//')===false)
				return $url;
			$parsed=@parse_url($url);
			$parsed_src=@parse_url('http://'.sm_settings('resource_url'));
			if (empty($parsed['path']))
				$parsed['path']='/';
			if (empty($parsed_src['path']))
				$parsed_src['path']='/';
			if (sm_strpos($parsed['path'], $parsed_src['path'])===false)
				return false;
			if (sm_strpos($parsed['path'], $parsed_src['path'])!=0)
				return false;
			if (sm_strcmp($parsed['path'], $parsed_src['path'])==0)
				return 'index.php';
			$r=substr($parsed['path'], sm_strlen($parsed_src['path']));
			if (!empty($parsed['query']))
				$r.='?'.$parsed['query'];
			return $r;
		}

	/**
	 * Set template for current module+action
	 *
	 * @param string $tpl_name - the name of the template without .tpl extension
	 */
	function sm_template($tpl_name)
		{
			global $modules, $modules_index;
			$modules[$modules_index]['module'] = $tpl_name;
		}

	function sm_is_template_defined()
		{
			global $modules, $modules_index;
			return !empty($modules[$modules_index]['module']);
		}

	function sm_set_main_template($tpl_filename)
		{
			global $sm;
			$sm['s']['main_tpl'] = $tpl_filename;
		}

	function sm_get_taxonomy($object_name, $object_id, $use_object_id_as_rel_id=false)
		{
			$q=new TQuery(sm_table_prefix().'taxonomy');
			$q->AddString('object_name', $object_name);
			if ($use_object_id_as_rel_id)
				{
					$q->AddString('rel_id', $object_id);
					$q->SelectFields('object_id as taxonomyid');
				}
			else
				{
					$q->AddString('object_id', $object_id);
					$q->SelectFields('rel_id as taxonomyid');
				}
			$q->Select();
			return $q->ColumnValues('taxonomyid');
		}

	function sm_log($object_name, $object_id, $description)
		{
			$q=new TQuery(sm_table_prefix().'log');
			$q->AddString('object_name', $object_name);
			$q->AddString('object_id', $object_id);
			$q->AddString('description', $description);
			$q->AddString('ip', @inet_pton(sm_ip_address()));
			$q->AddNumeric('time', time());
			$q->AddString('user', SM::User()->Login());
			$q->Insert();
		}

	function sm_nocache()
		{
			@header('Cache-Control: no-cache, no-store, must-revalidate');
			@header('Pragma: no-cache');
			@header('Expires: 0');
		}

	function sm_printmode()
		{
			PageGeneration::SetPrintMode();
		}
	
	/**
	 * Return true if print mode active
	 * @return bool
	 */
	function sm_is_printmode()
		{
			global $sm;
			return ($sm['s']['printmode'] == 'on');
		}

	function sm_add_body_class($add_classname)
		{
			global $sm;
			$sm['s']['body_class']=(empty($sm['s']['body_class'])?'':$sm['s']['body_class'].' ').$add_classname;
		}
	
	function sm_delayed_action($module, $action, $params=Array(), $bid=0, $panel='center', $no_borders=0)
		{
			global $sm;
			$sm['delayed_actions'][]=[
				'module'=>$module,
				'no_borders'=>$no_borders,
				'bid'=>$bid,
				'action'=>$action,
				'panel'=>$panel,
				'params'=>$params,
			];
		}
	
	function sm_ajax_load($url, $dom_selector)
		{
			if (!in_array(substr($dom_selector, 0, 1), Array('#', '.')))
				$dom_selector='#'.$dom_selector;
			return "\$('".$dom_selector."').load('".$url."');";
		}

	/**
	 * Unique page ID. Differs for the same URLs'.
	 * @return string
	 */
	function sm_pageid()
		{
			global $sm;
			return $sm['s']['page_system_id'];
		}

	/**
	 * Safely close the session
	 */
	function sm_session_close()
		{
			global $_sessionvars;
			if (!empty($_sessionvars))
				foreach ($_sessionvars as $key=>$val)
					{
						$_SESSION[sm_session_prefix().$key] = $val;
					}
			session_write_close();
		}

	/**
	 * Current encoding
	 * @return string
	 */
	function sm_encoding()
		{
			global $sm;
			return $sm['s']['charset'];
		}

	/**
	 * Website title
	 * @return string
	 */
	function sm_website_title()
		{
			global $sm;
			if (!empty($sm['s']['resource_title']))
				return $sm['s']['resource_title'];
			else
				return sm_settings('resource_title');
		}

	/**
	 * CMS regular tables prefix
	 * @return string
	 */
	function sm_table_prefix()
		{
			global $sm;
			return $sm['t'];
		}

	/**
	 * CMS global tables prefix (i.e. usres for multicms usage with the same users)
	 * @return string
	 */
	function sm_global_table_prefix()
		{
			global $sm;
			return $sm['tu'];
		}

	/*
	 * Is script running in CLI mode
	 * @return bool
	 */
	function sm_is_cli()
		{
			global $sm;
			if (empty($sm['s']['cli']))
				return false;
			else
				return $sm['s']['cli']===true;
		}

	/**
	 * Init for pagination. Require pagebar.tpl
	 * @param $count - total items count
	 * @param $limit - items per page
	 * @param $offset - current offset (items)
	 * @param null|string $url - url for pagination. Current URL will be used if NULL
	 */
	function sm_pagination_init($count, $limit, $offset, $url=NULL)
		{
			global $sm;
			if ($url===NULL)
				$url=sm_this_url();
			if ($limit<=0)
				$limit=1;
			$sm['m']['pages']['url'] = sm_url($url, 'from', '');
			$sm['m']['pages']['selected'] = ceil(($offset+1)/$limit);
			$sm['m']['pages']['interval'] = $limit;
			$sm['m']['pages']['records'] = $count;
			$sm['m']['pages']['selected'] = ceil(($offset+1)/$sm['m']['pages']['interval']);
			$sm['m']['pages']['pages'] = ceil(intval($sm['m']['pages']['records'])/$sm['m']['pages']['interval']);
		}

	/**
	 * Update URL for the paginator
	 * @param string $url - new url for pagination
	 */
	function sm_set_pagination_url($url)
		{
			global $sm;
			$sm['m']['pages']['url']=sm_url($url, 'from', '');;
		}

	/**
	 * Validate module name for inclusion
	 * @param $module_name
	 * @return bool
	 */
	function sm_is_valid_modulename($module_name)
		{
			if (empty($module_name) || sm_strpos($module_name, ':') || sm_strpos($module_name, '.') || sm_strpos($module_name, '/') || sm_strpos($module_name, '\\'))
				return false;
			else
				return true;
		}

	/**
	 * Return mask for formatting the date
	 * @return string
	 */
	function sm_date_mask()
		{
			return sm_lang('masks.date');
		}

	/**
	 * Return mask for formatting the time
	 * @return string
	 */
	function sm_time_mask()
		{
			return sm_lang('masks.time');
		}

	/**
	 * Return mask for formatting the date+time combination
	 * @return string
	 */
	function sm_datetime_mask()
		{
			return sm_lang('masks.date_time');
		}

	/*
	 * Disable title for current block
	 */
	function sm_no_title_in_block()
		{
			global $sm;
			$sm['m']['no_title_in_block']=true;
		}

	function sm_call_action($module_name_for_sm_call_action, $action_name_for_sm_call_action='', $params_for_sm_call_action=[])
		{
			global $m;
			global $sm;
			global $special;
			global $_settings;
			global $modules;
			global $modules_index;
			global $lang;
			global $userinfo;
			global $_getvars;
			global $_postvars;
			global $_cookievars;
			global $_servervars;
			global $_sessionvars;
			global $_uplfilevars;
			global $singleWindow;
			global $tableprefix;
			global $tableusersprefix;
			$m['current_module']=$module_name_for_sm_call_action;
			$m['params']=$params_for_sm_call_action;
			sm_set_action($action_name_for_sm_call_action);
			unset($module_name_for_sm_call_action);
			unset($action_name_for_sm_call_action);
			unset($params_for_sm_call_action);
			if ($m['current_module']!='404')
				{
					if (isset($sm['custom_router_execute_module_action_functions']) && is_array($sm['custom_router_execute_module_action_functions']))
						{
							foreach ($sm['custom_router_execute_module_action_functions'] as $custom_router_execute_module_action_function)
								{
									if ($custom_router_execute_module_action_function($m['current_module'], sm_current_action(), $m['params']))
										return;
								}
						}
					include(sm_file_path('modules/'.$m['current_module'].'.php'));
				}
		}

	/**
	 * @param string|array $action
	 * @param callable $function
	 */
	function sm_on_action($action, $function)
		{
			if (sm_action($action))
				$function();
		}

	/**
	 * @param string $action
	 * @param callable $function
	 */
	function sm_on_actionpost($action, $function)
		{
			if (sm_actionpost($action))
				$function();
		}

	function sm_alternative_tpl_list_main()
		{
			global $sm;
			if (isset($sm['themeinfo']['alttpl']['main']) && is_array($sm['themeinfo']['alttpl']['main']))
				return $sm['themeinfo']['alttpl']['main'];
			else
				return [];
		}

	function sm_alternative_tpl_list_content()
		{
			global $sm;
			if (isset($sm['themeinfo']['alttpl']['content']) && is_array($sm['themeinfo']['alttpl']['content']))
				return $sm['themeinfo']['alttpl']['content'];
			else
				return [];
		}

	function sm_is_main_block()
		{
			global $sm;
			return $sm['index']==0;
		}

	function sm_set_tpl_var($var_name, $var_value)
		{
			global $m;
			$m[$var_name]=$var_value;
		}

	function sm_add_user($login, $password, $email, $question = '', $answer = '', $user_status = '1')
		{
			$password = sm_password_hash($password, $login);
			$q = new TQuery(sm_global_table_prefix().'users');
			$q->AddString('login', $login);
			$q->AddString('password', $password);
			$q->AddString('email', $email);
			$q->AddString('question', $question);
			$q->AddString('answer', $answer);
			$q->AddNumeric('user_status', intval($user_status));
			$q->AddString('random_code', md5(time().rand()));
			$groups = get_groups_list();
			$u=[];
			for ($i = 0; $i < sm_count($groups); $i++)
				{
					if ($groups[$i]['auto'] == 1)
						{
							$u[] = $groups[$i]['id'];
						}
				}
			if (sm_count($u) > 0)
				{
					$groups_user = create_groups_str($u);
					$q->AddString('groups_user', $groups_user);
				}
			$id = $q->Insert();
			sm_set_metadata('user', $id, 'registration_time', time());
			return $id;
		}

	/*
	$showas values:
		text
		password
		textarea
		checkbox
		radio
	*/
	function sm_add_userfield($fieldname, $show_as = 'text', $allowed_values = '', $replaceforallvalue = '')
		{
			$sql = "ALTER TABLE `".sm_global_table_prefix()."users` ADD `".$fieldname."` TEXT NULL ;";
			execsql($sql);
			$allowed[] = 'text';
			$allowed[] = 'password';
			$allowed[] = 'textarea';
			$allowed[] = 'checkbox';
			$allowed[] = 'radio';
			if (!in_array($show_as, $allowed))
				$show_as = 'text';
			sm_add_settings($fieldname.'_show_as', $show_as, 'custom_user_fields');
			sm_add_settings($fieldname.'_allowed_values', $allowed_values, 'custom_user_fields');
			if (!empty($replaceforallvalue))
				execsql("UPDATE ".sm_global_table_prefix()."users SET `".$fieldname."`='".$replaceforallvalue."'");
		}

	function sm_delete_userfield($fieldname)
		{
			$sql = "ALTER TABLE `".sm_global_table_prefix()."users` DROP `".$fieldname."`;";
			execsql($sql);
			sm_delete_settings($fieldname.'_show_as', 'custom_user_fields');
			sm_delete_settings($fieldname.'_allowed_values', 'custom_user_fields');
			if (!empty($replaceforallvalue))
				execsql("UPDATE ".sm_global_table_prefix()."users SET `".$fieldname."`='".$replaceforallvalue."'");
		}

	function sm_get_offsetforpage($pagenumber, $limitcount)
		{
			if (intval($pagenumber) < 1)
				$pagenumber = 1;
			return abs((intval($pagenumber) - 1) * intval($limitcount));
		}

	function sm_get_pagescount($totalcount, $itemsperpage)
		{
			if ($totalcount == 0) return 1;
			return floor(($totalcount - 1) / $itemsperpage) + 1;
		}

	function sm_resizeimage($inputfile, $outputfile, $neededwidth, $neededheight, $skipifimageless = 1, $quality = 100, $needcrop = 0)
		{
			include_once('ext/resizer/resizer.php');
			$result = @resized_image($inputfile, $outputfile, $neededwidth, $neededheight, $skipifimageless, $quality, $needcrop);
			sm_event('afterresizedimagesave', array($outputfile));
			return $result;
		}

	function sm_add_group($title_group, $description_group, $autoaddtousers_group = 0)
		{
			$q = new TQuery(sm_table_prefix().'groups');
			$q->AddString('title_group', $title_group);
			$q->AddString('description_group', $description_group);
			$q->AddNumeric('autoaddtousers_group', $autoaddtousers_group);
			return $q->Insert();
		}

	function sm_set_group($id_group, $user_ids = Array())
		{
			for ($i = 0; $i < sm_count($user_ids); $i++)
				{
					sm_set_taxonomy('usergroups', $user_ids[$i], $id_group);
				}
		}

	function sm_unset_group($id_group, $user_ids = Array())
		{
			for ($i = 0; $i < sm_count($user_ids); $i++)
				{
					sm_unset_taxonomy('usergroups', $user_ids[$i], $id_group);
				}
		}

	function sm_delete_group($id_group)
		{
			$q = new TQuery(sm_table_prefix().'groups');
			$q->AddNumeric('id_group', intval($id_group));
			$q->Remove();
			sm_unset_group($id_group, sm_get_taxonomy('usergroups', $id_group, true));
		}

	function sm_tempdata_addtext($type, $identifier, $data, $timetolive = 3600)
		{
			$q = new TQuery(sm_table_prefix()."tempdata");
			$q->AddString('type_td', $type);
			$q->AddString('identifier_td', $identifier);
			$q->AddString('data_td_text', $data);
			$q->AddNumeric('deleteafter_td', time() + intval($timetolive));
			$q->Insert();
		}

	function sm_tempdata_updatetext($type, $identifier, $new_data_value, $timetolive = NULL)
		{
			$q=new TQuery(sm_table_prefix()."tempdata");
			$q->AddString('data_td_text', $new_data_value);
			if ($timetolive!==NULL)
				$q->AddNumeric('deleteafter_td', time()+intval($timetolive));
			$q->AddWhere('type_td', dbescape($type));
			$q->AddWhere('identifier_td', dbescape($identifier));
			$q->Update();
		}

	function sm_tempdata_addint($type, $identifier, $data, $timetolive = 3600)
		{
			$q = new TQuery(sm_table_prefix()."tempdata");
			$q->AddString('type_td', $type);
			$q->AddString('identifier_td', $identifier);
			$q->AddNumeric('data_td_int', intval($data));
			$q->AddNumeric('deleteafter_td', time() + intval($timetolive));
			$q->Insert();
		}

	function sm_tempdata_updateint($type, $identifier, $new_data_value, $timetolive = NULL)
		{
			$q=new TQuery(sm_table_prefix()."tempdata");
			$q->AddNumeric('data_td_int', intval($new_data_value));
			if ($timetolive!==NULL)
				$q->AddNumeric('deleteafter_td', time()+intval($timetolive));
			$q->AddWhere('type_td', dbescape($type));
			$q->AddWhere('identifier_td', dbescape($identifier));
			$q->Update();
		}

	function sm_tempdata_gettext($type, $identifier, $data = NULL)
		{
			$sql = "SELECT data_td_text FROM ".sm_table_prefix()."tempdata WHERE type_td='".dbescape($type)."' AND identifier_td='".dbescape($identifier)."'";
			if ($data !== NULL)
				$sql .= " AND data_td_text='".dbescape($data)."'";
			return getsqlfield($sql);
		}

	function sm_tempdata_getint($type, $identifier, $data = NULL)
		{
			$sql = "SELECT data_td_int FROM ".sm_table_prefix()."tempdata WHERE type_td='".dbescape($type)."' AND identifier_td='".dbescape($identifier)."'";
			if ($data !== NULL)
				$sql .= " AND data_td_int='".dbescape($data)."'";
			return getsqlfield($sql);
		}

	function sm_tempdata_remove($type, $identifier, $data = NULL)
		{
			$sql = "DELETE FROM ".sm_table_prefix()."tempdata WHERE type_td='".dbescape($type)."' AND identifier_td='".dbescape($identifier)."'";
			if ($data !== NULL)
				$sql .= " AND (data_td_int='".intval($data)."' OR data_td_text='".dbescape($data)."')";
			execsql($sql);
		}

	function sm_tempdata_clean($type = NULL, $identifier = NULL, $data = NULL)
		{
			$sql = "DELETE FROM ".sm_table_prefix()."tempdata WHERE deleteafter_td<=".time();
			if ($type !== NULL)
				$sql .= " AND type_td='".dbescape($type)."'";
			if ($identifier !== NULL)
				$sql .= " AND identifier_td='".dbescape($identifier)."'";
			if ($data !== NULL)
				$sql .= " AND (data_td_int='".intval($data)."' OR data_td_text='".dbescape($data)."')";
			execsql($sql);
		}

	define("SM_AGGREGATE_SUM", 'sum');
	define("SM_AGGREGATE_COUNT", 'count');
	define("SM_AGGREGATE_MAX", 'max');
	define("SM_AGGREGATE_MIN", 'min');
	define("SM_AGGREGATE_AVG", 'avg');

	function sm_tempdata_aggregate($type, $identifier, $resulttype = SM_AGGREGATE_COUNT, $data = NULL)
		{
			if ($resulttype == SM_AGGREGATE_COUNT)
				$returntype = 'count(*)';
			else
				$returntype = $resulttype.'(data_td_int)';
			$sql = "SELECT ".$returntype." FROM ".sm_table_prefix()."tempdata WHERE type_td='".dbescape($type)."' AND identifier_td='".dbescape($identifier)."'";
			if ($data !== NULL)
				$sql .= " AND data_td_int='".dbescape($data)."'";
			return getsqlfield($sql);
		}

	function sm_error_page($title, $message, $header_error_code = '')
		{
			global $special, $modules, $lang;
			$modules[0]['error_message'] = $message;
			$modules[0]['module'] = '';
			$modules[0]['mode'] = md5('error');
			if (empty($title))
				$modules[0]['title'] = $lang["error"];
			else
				$modules[0]['title'] = $title;
			$modules[0]['error_type'] = 'custom';
			if (!empty($header_error_code))
				$special['header_error_code'] = $header_error_code;
		}

	function sm_access_denied($message = NULL)
		{
			global $lang;
			if ($message === NULL)
				$message = $lang['access_denied'];
			sm_error_page($lang["error"], $message, '423 Locked');
		}

	function sm_autobannedip_cleanup()
		{
			if (!sm_empty_settings('autoban_ips'))
				{
					$newbanip = sm_settings('autoban_ips');
					$banip = nllistToArray(sm_settings('autoban_ips'));
					for ($i = 0; $i < count($banip); $i++)
						{
							if (intval(sm_tempdata_aggregate('bannedip', $banip[$i], SM_AGGREGATE_COUNT)) == 0)
								{
									$newbanip = removefrom_nllist($newbanip, $banip[$i]);
								}
						}
					if ($newbanip != sm_settings('autoban_ips'))
						sm_update_settings('autoban_ips', $newbanip);
				}
		}

	function sm_logout()
		{
			global $_sessionvars, $lang;
			$sql = "UPDATE ".sm_global_table_prefix()."users SET id_session=NULL WHERE id_user='".intval(SM::User()->ID())."'";
			execsql($sql);
			sm_event('userlogout', [SM::User()->ID()]);
			log_write(LOG_LOGIN, $lang['module_account']['log']['user_logout']);
			$_sessionvars['userinfo_id'] = '';
			$_sessionvars['userinfo_login'] = '';
			$_sessionvars['userinfo_email'] = '';
			$_sessionvars['userinfo_level'] = '0';
			$_sessionvars['userinfo_groups'] = '';
			$_sessionvars['userinfo_allinfo'] = '';
		}

	/**
	 * Process login and execute Success Login Events
	 * @param $user_id
	 */
	function sm_process_login($user_id)
		{
			global $userinfo;
			if (sm_login($user_id))
				{
					UserDataMaintainer::Init();
					sm_event('successlogin', array($userinfo['id']));
				}
		}

	function sm_url_content($url, $postvars=Array(), $timeout=5)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_REFERER, $url);
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			if (sm_settings('curl_default_useragent'))
				curl_setopt($ch, CURLOPT_USERAGENT, sm_settings('curl_default_useragent'));
			if (!empty($postvars))
				{
					$postvars=http_build_query($postvars);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
				}
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			if (!($out = curl_exec($ch)))
				$out=false;
			curl_close($ch);
			return $out;
		}

	function sm_download_file($url, $filename, $postvars=Array(), $timeout=5)
		{
			$ch = curl_init($url);
			if (file_exists($filename))
				unlink($filename);
			$fp = fopen($filename, "w");
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			if (sm_settings('curl_default_useragent'))
				curl_setopt($ch, CURLOPT_USERAGENT, sm_settings('curl_default_useragent'));
			if (!empty($postvars))
				{
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
				}
			curl_exec($ch);
			$tmperr = curl_error($ch);
			curl_close($ch);
			fclose($fp);
			if (!empty($tmperr))
				unlink($filename);
			return file_exists($filename);
		}

	function sm_set_password($user_id, $password)
		{
			$userinfo=sm_userinfo($user_id);
			$password_hash = sm_password_hash($password, $userinfo['login']);
			$random_code = md5($user_id.microtime().rand());
			execsql("UPDATE ".sm_global_table_prefix()."users SET password = '".dbescape($password_hash)."', random_code='".dbescape($random_code)."' WHERE id_user=".intval($user_id)." AND id_user>1");
		}

	function sm_user_exists($login)
		{
			return intval(TQuery::ForTable(sm_global_table_prefix().'users')->Add('login', dbescape($login))->GetField('id_user'))>0;
		}

	function sm_check_user($login, $password)
		{
			global $sm;
			$usr_name = dbescape(strtolower($login));
			$usr_passwd = dbescape(sm_password_hash($password, $login));
			if (sm_settings('signinwithloginandemail')==1)
				$id = getsqlfield("SELECT id_user FROM ".sm_global_table_prefix()."users WHERE (lower(login)='$usr_name' OR lower(email)='$usr_name') AND password='$usr_passwd' AND user_status>0 LIMIT 1");
			else
				$id = getsqlfield("SELECT id_user FROM ".sm_global_table_prefix()."users WHERE lower(login)='$usr_name' AND password='$usr_passwd' AND user_status>0 LIMIT 1");
			if (intval($id)!=0)
				return intval($id);
			else
				return false;
		}

	function sm_tomenuurl($title, $url, $returnto='')
		{
			return 'index.php?m=menu&d=addouter&p_caption='.urlencode($title).'&p_url='.urlencode($url).'&returnto='.urlencode($returnto);
		}

	function sm_addblockurl($block_title, $block_module, $block_action_id, $block_action='', $view_source_url='')
		{
			return 'index.php?m=blocks&d=add&b='.urlencode($block_module).'&id='.urlencode($block_action_id).'&db='.urlencode($block_action).'&c='.urlencode($block_title).'&src='.urlencode($view_source_url);
		}

	function sm_saferemove($url)
		{
			if (empty($url))
				return;
			global $sm;
			$items=Array();
			$q=new TQuery(sm_table_prefix().'menu_lines');
			$q->AddString('url', $url);
			$q->Remove();
			$q=new TQuery(sm_table_prefix().'filesystem');
			$q->AddString('url_fs', $url);
			$q->Select();
			for ($i = 0; $i < $q->Count(); $i++)
				{
					$items[]=$q->items[$i]['filename_fs'];
				}
			$q=new TQuery(sm_table_prefix().'filesystem');
			$q->AddString('url_fs', $url);
			$q->Remove();
			sm_event('saferemove', Array($url));
			for ($i = 0; $i < sm_count($items); $i++)
				{
					sm_saferemove($items[$i]);
				}
		}

	function sm_fs_exists($fs_url)
		{
			$q = new TQuery(sm_table_prefix().'filesystem');
			$q->AddString('filename_fs', $fs_url);
			return intval($q->GetField('id_fs'))>0;
		}

	function sm_fs_autogenerate($name, $extension='.html', $prefix_path='')
		{
			$name=$prefix_path.sm_getnicename($name);
			if (!sm_fs_exists($name.$extension))
				return $name.$extension;
			$i=2;
			while (true)
				{
					$tmp=$name.'-'.$i.$extension;
					if (!sm_fs_exists($tmp))
						return $tmp;
					$i++;
				}
		}

	function sm_is_allowed_to_upload($filename)
		{
			$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			$disallowed=explode('|', sm_settings('disallowed_upload_extensions'));
			if (sm_count($disallowed)==0)
				return false;
			return !in_array($ext, $disallowed);
		}

	function sm_ban_ip($bantime, $ip=NULL)
		{
			global $sm;
			if ($ip==NULL)
				$ip=sm_ip_address();
			sm_update_settings('autoban_ips', addto_nllist(sm_get_settings('autoban_ips'), $ip));
			sm_tempdata_addint('bannedip', $ip, time(), intval($bantime));
		}

	//Return array of ids or empty array
	function sm_metadata_objectids_for($object_name, $key_name, $val=NULL)
		{
			$q=new TQuery(sm_table_prefix().'metadata');
			$q->AddString('object_name', $object_name);
			$q->AddString('key_name', $key_name);
			if ($val!==NULL)
				$q->AddString('val', $val);
			$q->SelectFields('DISTINCT object_id as oid');
			$q->Select();
			return $q->ColumnValues('oid');
		}

	function sm_unset_taxonomy($object_name, $object_id, $rel_id)
		{
			if (is_array($rel_id))
				{
					for ($i = 0; $i<sm_count($rel_id); $i++)
						{
							sm_unset_taxonomy($object_name, $object_id, $rel_id[$i]);
							return;
						}
				}
			$q=new TQuery(sm_table_prefix().'taxonomy');
			$q->AddString('object_name', $object_name);
			$q->AddNumeric('object_id', intval($object_id));
			$q->AddNumeric('rel_id', intval($rel_id));
			$q->Remove();
		}

	function sm_set_taxonomy($object_name, $object_id, $rel_id)
		{
			if (is_array($rel_id))
				{
					for ($i = 0; $i<sm_count($rel_id); $i++)
						{
							sm_set_taxonomy($object_name, $object_id, $rel_id[$i]);
							return;
						}
				}
			if (in_array($rel_id, sm_get_taxonomy($object_name, $object_id)))
				return;
			$q=new TQuery(sm_table_prefix().'taxonomy');
			$q->AddString('object_name', $object_name);
			$q->AddNumeric('object_id', intval($object_id));
			$q->AddNumeric('rel_id', intval($rel_id));
			$q->Insert();
		}

	function sm_get_log($object_name, $object_id, $sort_desc=true, $limit=0, $offset=0)
		{
			$q=new TQuery(sm_table_prefix().'log');
			$q->AddString('object_name', $object_name);
			$q->AddString('object_id', $object_id);
			if ($sort_desc)
				$q->OrderBy('id_log DESC');
			else
				$q->OrderBy('id_log ASC');
			if ($limit!==0)
				{
					$q->Limit($limit);
					if ($offset!==0)
						$q->Offset($offset);
				}
			$q->Select();
			for ($i = 0; $i < $q->Count(); $i++)
				{
					$q->items[$i]['ip']=@inet_ntop($q->items[$i]['ip']);
				}
			return $q->items;
		}

	function sm_search_query_sql($query, $fields)
		{
			if (!is_array($fields))
				$fields=explode(' ', $fields);
			$keywords = explode(' ', preg_replace('/\s+/', ' ', $query));
			if (sm_count($fields)==0 || sm_count($keywords)==0)
				return '(1=2)';
			$r='';
			for ($i = 0; $i<sm_count($keywords); $i++)
				{
					if ($i>0)
						$r.=' AND ';
					$sql='(';
					for ($j = 0; $j<sm_count($fields); $j++)
						{
							if ($j>0)
								$sql.=' OR ';
							$sql.="`".$fields[$j]."` LIKE '%".dbescape($keywords[$i])."%'";
						}
					$r.=$sql.')';
				}
			return '('.$r.')';
		}

	function sm_output_replacer($functionname)
		{
			global $sm;
			if (empty($sm['output_replacers']) || !in_array($functionname, $sm['output_replacers']))
				$sm['output_replacers'][] = $functionname;
		}

	function sm_password_hash($password, $login)
		{
			global $siman_salt;
			if (sm_strlen($siman_salt)==0)
				return md5($password);
			else
				return md5(strtolower($login).$password.$siman_salt);
		}

	/**
	 * Maximum allowed size to upload (PHP limitations + SiMan CMS limitations)
	 * @return int
	 */
	function sm_maxuploadbytes()
		{
			if (!function_exists('ini_bytes_val'))
				{
					function ini_bytes_val($ini_v)
						{
							$ini_v = trim($ini_v);
							$s = Array('g' => 1 << 30, 'm' => 1 << 20, 'k' => 1 << 10);
							return intval($ini_v) * ($s[strtolower(substr($ini_v, -1))] ?: 1);
						}
				}
			$max=sm_settings('max_upload_filesize');
			$maxini = ini_bytes_val(ini_get('post_max_size'));
			if ($maxini<$max)
				$max=$maxini;
			$maxini = ini_bytes_val(ini_get('upload_max_filesize'));
			if ($maxini<$max)
				$max=$maxini;
			return $max;
		}

	/**
	 * Is record in settings table exist
	 * @return bool
	 */
	function sm_settings_exists_in_db($settings_name, $mode = 'default')
		{
			return sm_strlen(getsqlfield("SELECT name_settings FROM ".sm_table_prefix()."settings WHERE name_settings = '".dbescape($settings_name)."' AND mode='".dbescape($mode)."' LIMIT 1"))>0;
		}

	/**
	 * @param string $keys_with_dot_delimeter
	 * @return string
	 */
	function sm_lang($keys_with_dot_delimeter)
		{
			global $lang;
			$keys=explode('.', $keys_with_dot_delimeter);
			$data=&$lang;
			while (count($keys)>0)
				{
					$key=array_shift($keys);
					if (isset($data[$key]))
						$data=&$data[$key];
					else
						return '';
				}
			if ($data===NULL)
				return '';
			else
				return (string)$data;
		}

	/**
	 * Indicates possibility of module execution
	 * @param $module
	 * @return bool
	 */
	function sm_is_module_supported($module)
		{
			global $sm;
			if (isset($sm['custom_router_supports_module_functions']) && is_array($sm['custom_router_supports_module_functions']))
				{
					foreach ($sm['custom_router_supports_module_functions'] as $router_function)
						{
							if ($router_function($module))
								return true;
						}
				}
			if (!file_exists('modules/'.$module.'.php'))
				return false;
			else
				return true;
		}

	/**
	 * @return string
	 */
	function sm_current_protect_code()
		{
			global $_sessionvars;
			if (!isset($_sessionvars['protect_code']))
				return '';
			else
				return $_sessionvars['protect_code'];
		}
