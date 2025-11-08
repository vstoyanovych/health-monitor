<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	use SM\SM;

	if (isset($sm['delayed_actions']))
		{
			for ($tmpdelayedactionindex=0; $tmpdelayedactionindex<sm_count($sm['delayed_actions']); $tmpdelayedactionindex++)
				{
					if (sm_is_valid_modulename($sm['delayed_actions'][$tmpdelayedactionindex]['module']))
						{
							$modules_index++;
							$modules[$modules_index]['borders_off']=$sm['delayed_actions'][$tmpdelayedactionindex]['no_borders'];
							$modules[$modules_index]['bid']=$sm['delayed_actions'][$tmpdelayedactionindex]['bid'];
							if (is_numeric($sm['delayed_actions'][$tmpdelayedactionindex]['panel']))
								$modules[$modules_index]['panel']=$sm['delayed_actions'][$tmpdelayedactionindex]['panel'];
							else
								$modules[$modules_index]['panel']='center';
							$m=&$modules[$modules_index];
							$sm['m']=&$modules[$modules_index];
							sm_call_action(
								$sm['delayed_actions'][$tmpdelayedactionindex]['module'],
								$sm['delayed_actions'][$tmpdelayedactionindex]['action'],
								$sm['delayed_actions'][$tmpdelayedactionindex]['params']
							);
						}
				}
		}
	
	//Static blocks out
	$sql = "SELECT * FROM ".sm_table_prefix()."blocks ORDER BY position_block ASC";
	$pnlresult = database_query($sql, $lnkDB);
	while ($pnlrow = database_fetch_object($pnlresult))
		{
			$dont_show_high_priority = 0;
			if ((SM::User()->Level() < intval($pnlrow->level) && $pnlrow->thislevelonly == 0) && !compare_groups($userinfo['groups'], $pnlrow->groups_view))
				$dont_show_high_priority = 1;
			elseif ((SM::User()->Level() > intval($pnlrow->level) && $pnlrow->thislevelonly == -1) && !compare_groups($userinfo['groups'], $pnlrow->groups_view))
				$dont_show_high_priority = 1;
			elseif (SM::User()->Level() != intval($pnlrow->level) && $pnlrow->thislevelonly == 1)
				$dont_show_high_priority = 1;
			elseif (!sm_is_index_page() && sm_strcmp('#index#', sm_null_safe_str($pnlrow->show_on_module)) == 0 && $pnlrow->dont_show_modif != 1)
				$dont_show_high_priority = 1;
			if (!empty($pnlrow->showontheme) && $pnlrow->showontheme === sm_current_theme())
				$dont_show_high_priority = 1;
			if (!empty($pnlrow->showonlang) && $pnlrow->showonlang === sm_current_language())
				$dont_show_high_priority = 1;
			$show_panel = 1;
			if (!empty($pnlrow->show_on_module))
				{
					$show_panel = 0;
					if ((sm_strcmp($pnlrow->show_on_module, $module) == 0 || (empty($pnlrow->show_on_doing) && empty($modules[0]["mode"]) || strcmp($pnlrow->show_on_doing, $modules[0]["mode"]) == 0)) || (sm_is_index_page() && strcmp('#index#', $pnlrow->show_on_module) == 0))
						{
							if ($pnlrow->show_on_ctg != 0)
								{
									if ($special['categories']['id'] == $pnlrow->show_on_ctg)
										$show_panel = 1;
								}
							else
								$show_panel = 1;
						}
				}
			if ($pnlrow->dont_show_modif == 1)
				$show_panel = sm_abs($show_panel - 1);
			if ($show_panel == 0 && !empty($pnlrow->show_on_viewids) && !empty($special['page']['viewid']))
				{
					$tmpviewidslist = nllistToArray($pnlrow->show_on_viewids);
					for ($i = 0; $i < sm_count($tmpviewidslist); $i++)
						{
							if ($tmpviewidslist[$i] == $special['page']['viewid'])
								{
									$show_panel = 1;
									break;
								}
						}
					unset($tmpviewidslist);
				}
			if ($show_panel == 1 && !empty($pnlrow->show_on_device))
				{
					if ($pnlrow->show_on_device == 'desktop' && !$special['deviceinfo']['is_desktop'])
						$show_panel = 0;
					elseif ($pnlrow->show_on_device == 'mobile' && !$special['deviceinfo']['is_mobile'])
						$show_panel = 0;
					elseif ($pnlrow->show_on_device == 'tablet' && !$special['deviceinfo']['is_tablet'])
						$show_panel = 0;
				}
			if ($dont_show_high_priority == 1)
				$show_panel = 0;
			if ($show_panel == 1 && sm_is_valid_modulename($pnlrow->name_block))
				{
					$modules_index++;
					if ($pnlrow->panel_block == 'l')
						{
							$modules[$modules_index]["panel"] = "1";
						}
					elseif ($pnlrow->panel_block == 'r')
						{
							$modules[$modules_index]["panel"] = "2";
						}
					elseif (is_numeric($pnlrow->panel_block))
						{
							$modules[$modules_index]["panel"] = $pnlrow->panel_block;
						}
					else
						{
							$modules[$modules_index]["panel"] = "center";
						}
					$modules[$modules_index]["borders_off"] = $pnlrow->no_borders;
					$modules[$modules_index]["bid"] = $pnlrow->showed_id;
					if (sm_settings('blocks_use_image') == 1)
						{
							if (file_exists(SM::FilesPath().'img/block'.$pnlrow->id_block.'.jpg'))
								{
									$modules[$modules_index]['block_image'] = SM::FilesPath().'img/block'.$pnlrow->id_block.'.jpg';
								}
						}
					$modules[$modules_index]['rewrite_title_to'] = $pnlrow->rewrite_title;
					$m =& $modules[$modules_index];
					$sm['m'] =& $modules[$modules_index];
					if (empty($pnlrow->name_block) && !empty($pnlrow->text_block))
						{
							sm_title($pnlrow->rewrite_title);
							sm_set_action('view');
							sm_template('content');
							$m['content'][0]['can_view'] = 1;
							$m['content'][0]["text"] = $pnlrow->text_block;
							sm_add_content_modifier($m['content'][0]["text"]);
						}
					else
						{
							sm_call_action($pnlrow->name_block, $pnlrow->doing_block);
						}
				}
			else
				{
					$modules_index++;
					if ($pnlrow->panel_block == 'l')
						{
							$modules[$modules_index]["panel"] = "1";
						}
					elseif ($pnlrow->panel_block == 'r')
						{
							$modules[$modules_index]["panel"] = "2";
						}
					elseif (is_numeric($pnlrow->panel_block))
						{
							$modules[$modules_index]["panel"] = $pnlrow->panel_block;
						}
					else
						{
							$modules[$modules_index]["panel"] = "center";
						}
					$modules[$modules_index]["module"] = 'system_empty_block';
				}
		}

