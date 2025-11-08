<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	/*
	Module Name: Content
	Module URI: http://simancms.apserver.org.ua/modules/content/
	Description: Pages management. Base CMS module
	Version: 1.6.23
	Revision: 2023-08-27
	Author URI: http://simancms.apserver.org.ua/
	*/

	use SM\SM;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	/** @var string[]|string[][]|string[][][] $lang */
	/** @var $m */
	/** @var $modules */
	if (!defined("CONTENT_FUNCTIONS_DEFINED"))
		{
			function siman_load_ctgs_content($id_mainctg = -1, $extsql = '')
				{
					$addsql='';
					if (!empty($extsql))
						$addsql = ' WHERE '.$extsql;
					if ($id_mainctg >= 0)
						{
							if (empty($addsql))
								$addsql = " WHERE ";
							else
								$addsql .= " AND ";
							$addsql .= " id_maincategory=".intval($id_mainctg);
						}
					$sql = "SELECT * FROM ".sm_table_prefix()."categories $addsql";
					$sql .= " ORDER BY id_maincategory, IF(id_category=1, 0, 1), title_category";
					$result = execsql($sql);
					$i = 0;
					$ctg=[];
					while ($row = database_fetch_assoc($result))
						{
							$ctg[$i]['id'] = $row['id_category'];
							$ctg[$i]['title'] = $row['title_category'];
							$ctg[$i]['can_view'] = $row['can_view'];
							$ctg[$i]['main_ctg'] = $row['id_maincategory'];
							$ctg[$i]['sorting_category'] = $row['sorting_category'];
							$ctg[$i]['preview_category'] = $row['preview_category'];
							$ctg[$i]['groups_view'] = $row['groups_view'];
							$ctg[$i]['groups_modify'] = $row['groups_modify'];
							$ctg[$i]['level'] = 1;
							$ctg[$i]['filename'] = sm_fs_url('index.php?m=content&d=viewctg&ctgid='.$row['id_category']);
							$i++;
						}

					$pos=[];
					for ($i = 0; $i < sm_count($ctg); $i++)
						{
							$pos[$i] = 0;
						}
					for ($i = 0; $i < sm_count($ctg); $i++)
						{
							if ($ctg[$i]['main_ctg'] == 0)
								{
									$maxpos = 0;
									for ($j = 0; $j < sm_count($ctg); $j++)
										{
											if ($maxpos < $pos[$j])
												$maxpos = $pos[$j];
										}
									$pos[$i] = $maxpos + 1;
								}
							else
								{
									$rootpos = 0;
									$childpos = -1;
									for ($j = 0; $j < sm_count($ctg); $j++)
										{
											if ($ctg[$j]['id'] == $ctg[$i]['main_ctg'])
												{
													$rootpos = $pos[$j];
													$ctg[$i]['level'] = $ctg[$j]['level'] + 1;
													$ctg[$j]['is_mainctg'] = 1;
												}
											if ($ctg[$j]['main_ctg'] == $ctg[$i]['main_ctg'] && $j != $i && $childpos < $pos[$j])
												$childpos = $pos[$j];
										}
									$pos[$i] = ($rootpos > $childpos) ? ($rootpos + 1) : ($childpos + 1);
									for ($j = 0; $j < sm_count($ctg); $j++)
										{
											if ($pos[$j] >= $pos[$i] && $j != $i)
												$pos[$j]++;
										}
								}
						}
					$rctg=[];
					for ($i = 0; $i < sm_count($ctg); $i++)
						{
							$rctg[$pos[$i] - 1] = $ctg[$i];
						}

					return $rctg;
				}

			define("CONTENT_FUNCTIONS_DEFINED", 1);
		}

	$tmp_load_preview_only = 0;
	$tmp_dont_set_title = 0;

	sm_default_action('view');
	if (sm_action('view'))
		{
			if (!empty($m['bid'])) $m['cid'] = intval($m['bid']);
			$content_id = intval(sm_get_array_value($m, 'cid'));
			if (empty($content_id) && sm_is_main_block())
				{
					$content_id = SM::GET('cid')->AsInt();
					if (sm_is_index_page() && empty($content_id))
						$content_id=1;
				}
			if (empty($content_id))
				{
					sm_title(sm_lang('error'));
					$m['text'] = sm_lang('messages.nothing_found');
					$content_error = 1;
				}
			else
				{
					sm_template('content');
					sm_page_viewid('content-view-'.$content_id);
					$sql = "SELECT ".sm_table_prefix()."content.*, ".sm_table_prefix()."categories.* FROM ".sm_table_prefix()."content, ".sm_table_prefix()."categories WHERE ".sm_table_prefix()."content.id_category_c=".sm_table_prefix()."categories.id_category AND id_content=".$content_id;
					if (sm_is_main_block())
						$sql .= " AND refuse_direct_show <> 1";
					$sql .= " LIMIT 1";
				}
			if (intval(sm_settings('allow_alike_content')) != 1)
				$tmp_no_alike_content = true;
		}

	if (sm_action('viewlast') || sm_action('viewfirst'))
		{
			sm_page_viewid('content-viewlast');
			sm_template('content');
			$sql = "SELECT ".sm_table_prefix()."content.*, ".sm_table_prefix()."categories.* FROM ".sm_table_prefix()."content, ".sm_table_prefix()."categories WHERE ".sm_table_prefix()."content.id_category_c=".sm_table_prefix()."categories.id_category";
			if (!SM::GET('ctg')->isEmpty())
				$sql .= " AND ".sm_table_prefix()."content.id_category_c=".SM::GET('ctg')->AsInt();
			if (sm_action('viewlast'))
				$sql .= " ORDER BY ".sm_table_prefix()."content.id_content DESC LIMIT 1";
			else
				$sql .= " ORDER BY ".sm_table_prefix()."content.id_content ASC LIMIT 1";
			sm_set_action('view');
			if (sm_settings('allow_alike_content')!=1)
				$tmp_no_alike_content = true;
		}

	if (sm_action('multiview'))
		{
			sm_template('content');
			if (!empty($m["bid"]))
				$ctg_id = intval($m['bid']);
			else
				$ctg_id = SM::GET('ctgid')->AsInt();
			if (!empty($ctg_id))
				{
					sm_page_viewid('content-multiview-'.$ctg_id);
					$m['subcategories'] = siman_load_ctgs_content($ctg_id);
					$m['subcategories_present'] = 1;
					$sql = "SELECT * FROM ".sm_table_prefix()."categories WHERE id_category=".$ctg_id;
					$result = execsql($sql);
					while ($row = database_fetch_object($result))
						{
							$m['category']['id_ctg'] = $row->id_category;
							$m['category']['title_category'] = $row->title_category;
							$m['category']['category_can_view'] = $row->can_view;
							$m['category']['main_ctg'] = $row->id_maincategory;
							$m['category']['preview_ctg'] = $row->preview_category;
						}
				}
			else
				sm_page_viewid('content-multiview');
			$sql = "SELECT ".sm_table_prefix()."content.*, ".sm_table_prefix()."categories.* FROM ".sm_table_prefix()."content, ".sm_table_prefix()."categories WHERE ".sm_table_prefix()."content.id_category_c=".sm_table_prefix()."categories.id_category";
			$sql .= ' AND '.sm_table_prefix().'categories.can_view<='.SM::User()->Level();
			if (!empty($ctg_id))
				$sql .= ' AND '.sm_table_prefix().'content.id_category_c='.$ctg_id;
			$sql .= ' ORDER BY '.sm_table_prefix().'content.priority_content DESC"';
			if (sm_settings('content_multiview') == 'off')
				{
					$sql .= ' LIMIT 1';
				}
			else
				{
					if (!SM::GET('count')->isEmpty())
						{
							if (is_numeric(SM::GET('count')->AsString()))
								$sql .= ' LIMIT '.SM::GET('count')->AsInt();
							else
								$sql .= ' LIMIT '.intval(sm_settings('content_per_page_multiview'));
						}
					else
						{
							$sql .= ' LIMIT '.intval(sm_settings('content_per_page_multiview'));
						}
				}
			$tmp_dont_set_title = 1;
			$tmp_load_preview_only = 1;
			$tmp_no_alike_content = true;
			sm_set_action('view');
		}

	if (sm_action('rndctgview'))
		{
			sm_page_viewid('content-rndctgview');
			sm_template('content');
			if (!empty($m["bid"]))
				$ctg_id = intval($m['bid']);
			else
				$ctg_id = SM::GET('ctgid')->AsInt();
			$sql = "SELECT ".database_get_fn_name('rand')."() as rndrow,".sm_table_prefix()."content.*, ".sm_table_prefix()."categories.* FROM ".sm_table_prefix()."content, ".sm_table_prefix()."categories WHERE ".sm_table_prefix()."content.id_category_c=".sm_table_prefix()."categories.id_category";
			$sql .= ' AND '.sm_table_prefix().'categories.can_view<='.SM::User()->Level();
			if (!empty($ctg_id))
				$sql .= ' AND '.sm_table_prefix().'content.id_category_c='.intval($ctg_id);
			$sql .= ' ORDER BY rndrow LIMIT 1';
			sm_set_action('view');
			$tmp_no_alike_content = true;
		}

	if (sm_action('view'))
		{
			if (!isset($content_error) || $content_error != 1)
				{
					if (!isset($tmp_no_alike_content))
						$tmp_no_alike_content=false;
					$result = execsql($sql);
					$i = 0;
					while ($row = database_fetch_assoc($result))
						{
							if ($row['type_content'] == 2)
								{
									@header('Content-type: text/plain; charset='.sm_encoding());
									print($row['text_content']);
									exit();
								}
							sm_event('onbeforecontentprocessing', $i);
							if (sm_is_main_block() && $i==0 && !empty($content_id))
								sm_meta_canonical(sm_fs_url('index.php?m=content&d=view&cid='.$content_id));
							if (!isset($content_id))
								$content_id=intval($row['id_content']);
							$m['content'][$i]["title"] = $row['title_content'];
							sm_add_title_modifier($m['content'][$i]["title"]);
							if ($tmp_dont_set_title != 1)
								sm_title($m['content'][$i]["title"]);
							if ($tmp_load_preview_only == 1)
								{
									$m['content'][$i]["text"] = $row['preview_content'];
									if (empty($m['content'][$i]["text"]))
										$m['content'][$i]["text"] = cut_str_by_word($row['text_content'], 300, '...');
									$m['content'][$i]['fullink'] = sm_fs_url('index.php?m=content&d=view&cid='.$row['id_content']);
								}
							else
								$m['content'][$i]["text"] = $row['text_content'];
							sm_add_content_modifier($m['content'][$i]["text"]);
							$m['content'][$i]["id_category"] = $row['id_category_c'];
							if (sm_is_main_block())
								$special['categories']['id'] = $row['id_category_c'];
							$m['content'][$i]["title_category"] = $row['title_category'];
							if (sm_is_main_block() && $i == 0 && sm_settings('content_use_path') == 1 && $row['no_use_path'] != 1 && !sm_is_index_page())
								{
									$tmppath = sm_get_path_tree(sm_table_prefix()."categories", 'id_category', 'id_maincategory', $row['id_category_c']);
									add_path_home();
									for ($tmpi = 0; $tmpi < sm_count($tmppath); $tmpi++)
										{
											add_path(
												$tmppath[$tmpi]['title_category'],
												'index.php?m=content&d=viewctg&ctgid='.$tmppath[$tmpi]['id_category']
											);
										}
								}
							if (sm_is_main_block() && $i == 0)
								$m['content'][$i]['attachments'] = sm_get_attachments('content', $row['id_content']);
							if (!$tmp_no_alike_content)
								if ($row['no_alike_content'] == 1)
									$tmp_no_alike_content = true;
							if ($row['can_view'] <= SM::User()->Level())
								$m['content'][$i]["can_view"] = 1;
							else
								{
									if (!empty($userinfo['groups']))
										{
											if (compare_groups($userinfo['groups'], $row['groups_view']))
												$m['content'][$i]["can_view"] = 1;
											else
												$m['content'][$i]["can_view"] = 0;
										}
									else
										$m['content'][$i]["can_view"] = 0;
									if ($m['content'][$i]["can_view"] == 0)
										{
											$m['content'][$i]["title"] = sm_lang('access_denied');
										}
								}
							if ($row['type_content'] == 0)
								{
									$m['content'][$i]["text"] = nl2br($m['content'][$i]["text"]);
								}
							if (SM::User()->Level()>=intval(sm_settings('content_editor_level')) && sm_is_main_block())
								{
									$m['content'][$i]["can_edit"] = 1;
									$m['content'][$i]["can_delete"] = 1;
								}
							elseif (!empty($userinfo['groups']))
								{
									if (compare_groups($userinfo['groups'], $row['groups_modify']) && sm_is_main_block())
										{
											$m['content'][$i]["can_edit"] = 1;
											$m['content'][$i]["can_delete"] = 1;
										}
								}
							$m['content'][$i]["cid"] = $content_id;
							if (sm_settings('content_use_image') == 1)
								{
									if (file_exists(SM::FilesPath().'fullimg/content'.$content_id.'.jpg'))
										{
											if ($tmp_load_preview_only == 1)
												$m['content'][$i]['image'] = SM::FilesPath().'thumb/content'.$content_id.'.jpg';
											else
												$m['content'][$i]['image'] = SM::FilesPath().'fullimg/content'.$content_id.'.jpg';
										}
									elseif (file_exists(SM::FilesPath().'img/content'.$content_id.'.jpg'))
										{
											$m['content'][$i]['image'] = 'ext/showimage.php?img=content'.$content_id;
											if ($tmp_load_preview_only == 1)
												{
													if (!sm_empty_settings('content_image_preview_width'))
														$m['content'][$i]['image'] .= '&width='.sm_settings('content_image_preview_width');
													if (!sm_empty_settings('content_image_preview_height'))
														$m['content'][$i]['image'] .= '&height='.sm_settings('content_image_preview_height');
												}
											else
												{
													if (!sm_empty_settings('content_image_fulltext_width'))
														$m['content'][$i]['image'] .= '&width='.sm_settings('content_image_fulltext_width');
													if (!sm_empty_settings('content_image_fulltext_height'))
														$m['content'][$i]['image'] .= '&height='.sm_settings('content_image_fulltext_height');
												}
										}
								}
							if (sm_is_main_block())
								{
									if (!empty($special['meta']['keywords']) && !empty($row['keywords_content']))
										{
											$special['meta']['keywords'] = ($row['keywords_content']).', '.$special['meta']['keywords'];
										}
									elseif (!empty($row['keywords_content']))
										{
											$special['meta']['keywords'] = $row['keywords_content'];
										}
									if (!empty($row['description_content']))
										$special['meta']['description'] = $row['description_content'];
									if (isset($m['content'][$i]['can_edit']) && $m['content'][$i]['can_edit']==1)
										$m['content'][$i]['edit_url']='index.php?m=content&d=edit&cid='.$m['content'][$i]["cid"].'&returnto='.urlencode(sm_this_url());
									if (isset($m['content'][$i]['can_delete']) && $m['content'][$i]['can_delete']==1)
										$m['content'][$i]['delete_url']='index.php?m=content&d=delete&cid='.$m['content'][$i]["cid"].'&ctg='.$m['content'][$i]["id_category"].'&returnto='.urlencode(sm_this_url());
								}
							if (!$tmp_no_alike_content && sm_is_main_block() && $m['panel'] == 'center' && $m['content'][$i]["can_view"] != 0 && !sm_is_index_page())
								{
									$tmpsql = "SELECT * FROM ".sm_table_prefix()."content WHERE id_content<>".intval($m['content'][$i]["cid"])." AND id_category_c=".intval($m['content'][$i]['id_category'])." ORDER BY priority_content DESC LIMIT ".intval(sm_settings('alike_content_count'));
									$tmpresult = execsql($tmpsql);
									$j = 0;
									while ($tmprow = database_fetch_assoc($tmpresult))
										{
											$m['content'][$i]['alike_texts'][$j]['id'] = $tmprow['id_content'];
											$m['content'][$i]['alike_texts'][$j]['title'] = $tmprow['title_content'];
											$m['content'][$i]['alike_texts'][$j]['fullink'] = sm_fs_url('index.php?m=content&d=view&cid='.$tmprow['id_content']);
											$m['content'][$i]['alike_texts'][$j]['preview'] = $tmprow['preview_content'];
											if (empty($m['content'][$i]['alike_texts'][$j]['preview']))
												$m['content'][$i]['alike_texts'][$j]['preview'] = cut_str_by_word($tmprow['text_content'], 300, '...');
											sm_add_title_modifier($m['content'][$i]['alike_texts'][$j]['title']);
											sm_add_content_modifier($m['content'][$i]['alike_texts'][$j]['preview']);
											$j++;
										}
									$m['content'][$i]['alike_texts_present'] = $j;
								}
							else
								$m['content'][$i]['alike_texts_present'] = 0;
							$m['content'][$i]['data']=$row;
							$tmp=sm_load_metadata('content', $row['id_content']);
							if (!empty($tmp['main_template']) && sm_is_main_block())
								sm_set_main_template($tmp['main_template']);
							if (!empty($tmp['content_template']) && $i==0)
								sm_template($tmp['content_template']);
							if (!empty($tmp['seo_title']) && sm_is_main_block())
								sm_meta_title($tmp['seo_title']);
							sm_event('oncontentprocessed', $i);
							$i++;
						}
					if ($i == 0)
						sm_template('');
					elseif (sm_is_main_block())
						sm_event('onviewcontent', array($m['content'][0]["cid"]));
				}
		}

	if (sm_action('viewctg'))
		{
			sm_template('content');
			if (SM::GET('ctgid')->isEmpty() && !SM::GET('ctg')->isEmpty())
				SM::GET('ctgid')->SetValue(SM::GET('ctg')->AsInt());
			$ctg_id = SM::GET('ctgid')->AsInt();
			sm_page_viewid('content-viewctg-'.$ctg_id);
			$sql = "SELECT * FROM ".sm_table_prefix()."categories WHERE id_category=".$ctg_id;
			$result = execsql($sql);
			$i=0;
			while ($row = database_fetch_assoc($result))
				{
					sm_event('onbeforecontentcategoriespathprocessing', $i);
					if (sm_is_main_block() && sm_settings('content_use_path') == 1 && $row['no_use_path'] != 1)
						{
							$tmppath = sm_get_path_tree(sm_table_prefix()."categories", 'id_category', 'id_maincategory', $row['id_maincategory']);
							add_path_home();
							for ($tmpi = 0; $tmpi < sm_count($tmppath); $tmpi++)
								{
									add_path(
										$tmppath[$tmpi]['title_category'],
										sm_fs_url('index.php?m=content&d=viewctg&ctgid='.$tmppath[$tmpi]['id_category'])
									);
								}
						}
					if (sm_is_main_block())
						$special['categories']['id'] = $row['id_category'];
					sm_title($row['title_category']);
					$m['preview_category'] = $row['preview_category'];
					$m['sorting_category'] = $row['sorting_category'];
					if ($row['can_view'] <= SM::User()->Level())
						$m['category']['can_view'] = 1;
					else
						{
							if (!empty($userinfo['groups']))
								{
									if (compare_groups($userinfo['groups'], $row['groups_view']))
										$m['category']['can_view'] = 1;
									else
										$m['category']['can_view'] = 0;
								}
							else
								$m['category']['can_view'] = 0;
							if ($m['category']['can_view'] == 0)
								sm_title($lang['access_denied']);
						}
					$m['subcategories'] = siman_load_ctgs_content($row['id_category']);
					sm_add_content_modifier($m['preview_category']);
					$i++;
				}
			$sql = "SELECT ".sm_table_prefix()."content.* FROM ".sm_table_prefix()."content WHERE ".sm_table_prefix()."content.id_category_c=".$ctg_id;
			if ($m['sorting_category'] == 3)
				$sql .= " ORDER BY priority_content DESC";
			elseif ($m['sorting_category'] == 1)
				$sql .= " ORDER BY title_content DESC";
			elseif ($m['sorting_category'] == 2)
				$sql .= " ORDER BY priority_content ASC";
			else
				$sql .= " ORDER BY title_content ASC";
			$result = execsql($sql);
			$i = 0;
			while ($row = database_fetch_assoc($result))
				{
					sm_event('onbeforeviewctgcontentprocessing', $i);
					$m['category']['ctg'][$i]['title'] = $row['title_content'];
					$m['category']['ctg'][$i]['id'] = $row['id_content'];
					$m['category']['ctg'][$i]['url'] = sm_fs_url('index.php?m=content&d=view&cid='.$row['id_content']);
					if (sm_settings('content_use_preview') == 1)
						{
							$m['category']['ctg'][$i]['preview'] = $row['preview_content'];
						}
					if (sm_settings('content_use_image') == 1)
						{
							if (file_exists(SM::FilesPath().'thumb/content'.$m['category']['ctg'][$i]['id'].'.jpg'))
								{
									$m['category']['ctg'][$i]['image'] = SM::FilesPath().'thumb/content'.$m['category']['ctg'][$i]['id'].'.jpg';
								}
							elseif (file_exists(SM::FilesPath().'img/content'.$m['category']['ctg'][$i]['id'].'.jpg'))
								{
									$m['category']['ctg'][$i]['image'] = 'ext/showimage.php?img=content'.$m['category']['ctg'][$i]['id'];
									if (!sm_empty_settings('content_image_preview_width'))
										$m['category']['ctg'][$i]['image'] .= '&width='.sm_settings('content_image_preview_width');
									if (!sm_empty_settings('content_image_preview_height'))
										$m['category']['ctg'][$i]['image'] .= '&height='.sm_settings('content_image_preview_height');
								}
						}
					sm_add_title_modifier($m['category']['ctg'][$i]['title']);
					sm_add_content_modifier($m['category']['ctg'][$i]['preview']);
					$i++;
				}
		}

	if (sm_action('blockctgview'))
		{
			sm_template('content');
			if (isset($modules[0]['content'][0]["id_category"]))
				$ctg_id = intval($modules[0]['content'][0]["id_category"]);
			else
				$ctg_id = 0;
			if (empty($ctg_id) || $ctg_id == 1)
				sm_set_action('donotshow');
			else
				{
					$sql = "SELECT * FROM ".sm_table_prefix()."categories WHERE id_category=".$ctg_id;
					$result = execsql($sql);
					$i=0;
					while ($row = database_fetch_assoc($result))
						{
							sm_event('onbeforeblockctgviewcontentprocessing', $i);
							sm_title($row['title_category']);
							$m['sorting_category'] = $row['sorting_category'];
							if ($row['can_view'] <= SM::User()->Level())
								$m['category']['can_view'] = 1;
							else
								{
									if (!empty($userinfo['groups']))
										{
											if (compare_groups($userinfo['groups'], $row['groups_view']))
												$m['category']['can_view'] = 1;
											else
												$m['category']['can_view'] = 0;
										}
									else
										$m['category']['can_view'] = 0;
									if ($m['category']['can_view'] == 0)
										sm_set_action('donotshow');
								}
							$i++;
						}
					$sql = "SELECT ".sm_table_prefix()."content.* FROM ".sm_table_prefix()."content WHERE ".sm_table_prefix()."content.id_category_c=".$ctg_id;
					if ($m['sorting_category'] == 3)
						$sql .= " ORDER BY priority_content DESC";
					elseif ($m['sorting_category'] == 1)
						$sql .= " ORDER BY title_content DESC";
					elseif ($m['sorting_category'] == 2)
						$sql .= " ORDER BY priority_content ASC";
					else
						$sql .= " ORDER BY title_content ASC";
					$result = execsql($sql);
					$i = 0;
					$m['menu'] = Array();
					while ($row = database_fetch_assoc($result))
						{
							$m['category']['ctg'][$i]['title'] = $row['title_content'];
							$m['category']['ctg'][$i]['id'] = $row['id_content'];
							$m['category']['ctg'][$i]['url'] = sm_fs_url('index.php?m=content&d=view&cid='.$row['id_content']);
							sm_add_menuitem($m['menu'], $row['title_content'], $m['category']['ctg'][$i]['url']);
							sm_add_title_modifier($m['category']['ctg'][$i]['title']);
							$i++;
						}
					if ($i > 0)
						{
							sm_template('menu');
							sm_set_action('view');
						}
					else
						sm_set_action('donotshow');
				}
		}
	
	if (SM::isLoggedIn())
		include('modules/inc/memberspart/content.php');

