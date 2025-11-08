<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	/*
	Module Name: News
	Module URI: http://simancms.apserver.org.ua/modules/news/
	Description: News management. Base CMS module
	Version: 1.6.23
	Revision: 2023-08-27
	Author URI: http://simancms.apserver.org.ua/
	*/

	use SM\SM;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (!defined("NEWS_FUNCTIONS_DEFINED"))
		{
			function sm_news_url($id, $timestamp)
				{
					return 'news/'.date('Y/m/d/', $timestamp).$id.'.html';
				}
			
			define("NEWS_FUNCTIONS_DEFINED", 1);
		}

	/** @var string[]|string[][]|string[][][] $lang */
	/** @var $m */
	if (SM::User()->Level()>=intval(sm_settings('news_view_level')))
		{ // user level view restrictions start
			$tmp_view_ctg = '';

			if (sm_strpos(sm_current_action(), '|') !== false)
				{
					$tmp = explode('|', sm_current_action());
					sm_set_action($tmp[0]);
					$m['limitnews'] = $tmp[1];
					if (!empty($tmp[2]))
						$m["bid"] = $tmp[2];
					unset($tmp);
				}

			if (!empty($m['bid']) && $m['bid'] == 1 && empty(sm_current_action()))
				{
					sm_set_action('shortnews');
					$m['bid'] = '';
				}

			sm_default_action('listnews');

			$tmp_short_news = 0;

			if (sm_action('listnews') || sm_action('listdate'))
				{
					$tmp_view_ctg = sm_getvars('ctg');
				}
			elseif (sm_action('shortnews'))
				{
					$tmp_short_news = 1;
					sm_set_action('listnews');
					$tmp_view_ctg = $m["bid"];
				}
			elseif (sm_action('viewctg'))
				{
					SM::GET('ctg')->SetValue(SM::GET('ctgid')->AsString());
					$tmp_view_ctg = sm_getvars('ctg');
					sm_set_action('listnews');
				}

			if (sm_action('listnews') || sm_action('listdate'))
				{
					sm_template('news');
					if (!empty($tmp_view_ctg))
						{
							$tmp_view_ctg_first = explode(',', $tmp_view_ctg);
							$tmp_view_ctg_first = $tmp_view_ctg_first[0];
							$sql = "SELECT * FROM ".sm_table_prefix()."categories_news WHERE id_category=".intval($tmp_view_ctg_first);
							$result = execsql($sql);
							while ($row = database_fetch_assoc($result))
								{
									sm_title($row['title_category']);
									if (sm_is_main_block())
										$special['categories']['id'] = $row['id_category'];
								}
						}
					$ctg_id = $tmp_view_ctg;
					if (sm_action('listnews'))
						{
							if (!empty($ctg_id))
								sm_page_viewid('news-'.sm_current_action().'-'.$ctg_id);
							else
								sm_page_viewid('news-'.sm_current_action());
						}
					else
						{
							sm_page_viewid('news-'.sm_current_action().'-'.sm_getvars('dy').'-'.sm_getvars('dm').'-'.sm_getvars('dd'));
						}
					$from_record = sm_abs(SM::GET('from')->AsInt());
					$from_page = ceil(($from_record+1)/sm_settings('news_by_page'));
					if (sm_action('listdate'))
						$m['pages']['url'] = 'index.php?m=news&d=listdate&dy='.sm_getvars('dy').'&dm='.sm_getvars('dm').'&dd='.sm_getvars('dd');
					elseif (!empty($tmp_view_ctg))
						$m['pages']['url'] = 'index.php?m=news&d=listnews&ctg='.$tmp_view_ctg;
					else
						$m['pages']['url'] = 'index.php?m=news&d=listnews';
					$m['pages']['selected'] = $from_page;
					$m['pages']['interval'] = sm_settings('news_by_page');
					if (sm_is_empty_title())
						sm_title($lang['news']);
					$sql2 = " WHERE date_news<=".time();
					if (sm_action('listdate'))
						{
							if (!empty(sm_getvars('dy')))
								{
									if (empty(sm_getvars('dm')))
										{
											$tmp['monthstart'] = 1;
											$tmp['monthend'] = intval(date('m', time()));
										}
									else
										{
											$tmp['monthstart'] = SM::GET('dm')->AsInt();
											$tmp['monthend'] = SM::GET('dm')->AsInt();
										}
									if (empty(sm_getvars('dd')))
										{
											$tmp['daystart'] = 1;
											$tmp['dayend'] = date('d', mktime(23, 59, 59, ($tmp['monthend']==12 ? 1 : $tmp['monthend'] + 1), 1, ($tmp['monthend']<12 ? SM::GET('dy')->AsInt() : SM::GET('dy')->AsInt()+1))-86400);
										}
									else
										{
											$tmp['daystart'] = SM::GET('dd')->AsInt();
											$tmp['dayend'] = SM::GET('dd')->AsInt();
										}
									$tmp_date_filter1 = mktime(0, 0, 0, $tmp['monthstart'], $tmp['daystart'], SM::GET('dy')->AsInt());
									$tmp_date_filter2 = mktime(23, 59, 59, $tmp['monthend'], $tmp['dayend'], SM::GET('dy')->AsInt());
									$sql2 .= " AND date_news>=$tmp_date_filter1 AND date_news<=$tmp_date_filter2 ";
								}
							sm_set_action('listnews');
						}
					$m['id_category_n'] = $tmp_view_ctg;
					if (!empty($ctg_id) /* && $tmp_short_news!=1*/)
						{
							if (sm_strpos($ctg_id, ',') !== false)
								{
									$ctg_id = explode(',', $ctg_id);
									for ($i = 0; $i<sm_count($ctg_id); $i++)
										{
											$ctg_id[$i] = intval($ctg_id[$i]);
										}
									$ctg_id = implode(', ', $ctg_id);
									$sql2 .= " AND id_category_n IN ($ctg_id) ";
								}
							else
								{
									$sql2 .= " AND id_category_n = ".intval($ctg_id);
								}
						}
					$sql = "SELECT * FROM ".sm_table_prefix()."news";
					$sql .= " $sql2 ORDER BY date_news DESC";
					if ($tmp_short_news == 0)
						{
							$sql .= " LIMIT ".intval(sm_settings('news_by_page'))." OFFSET ".intval($from_record);
						}
					elseif (!empty($m['limitnews']))
						{
							$sql .= " LIMIT ".intval($m['limitnews']);
						}
					else
						{
							$sql .= " LIMIT ".intval(sm_settings('short_news_count'));
						}
					$result = execsql($sql);
					$i = 0;
					$u = 0;
					while ($row = database_fetch_assoc($result))
						{
							sm_event('onbeforelistnewsprocessing', $i);
							$m["list"][$i]['id'] = $row['id_news'];
							$m["list"][$i]['date'] = date(sm_date_mask(), $row['date_news']);
							$m["list"][$i]['time'] = date(sm_time_mask(), $row['date_news']);
							$m["list"][$i]['text'] = $row['text_news'];
							$m["list"][$i]['title'] = $row['title_news'];
							$m["list"][$i]['url'] = sm_fs_url('index.php?m=news&d=view&nid='.$row['id_news'], false, sm_news_url($row['id_news'], $row['date_news']));
							if (sm_settings('news_use_image') == 1)
								{
									if (file_exists(SM::FilesPath().'thumb/news'.$row['id_news'].'.jpg'))
										{
											$m["list"][$i]['image'] = SM::FilesPath().'thumb/news'.$row['id_news'].'.jpg';
										}
									elseif (file_exists(SM::FilesPath().'img/news'.$row['id_news'].'.jpg'))
										{
											$m["list"][$i]['image'] = 'ext/showimage.php?img=news'.$row['id_news'];
											if (!empty(sm_settings('news_image_preview_width')))
												$m["list"][$i]['image'] .= '&width='.sm_settings('news_image_preview_width');
											if (sm_has_settings('news_image_preview_height'))
												$m["list"][$i]['image'] .= '&height='.sm_settings('news_image_preview_height');
										}
								}
							if ($tmp_short_news == 0)
								{
									$tmp_cut_news = sm_settings('news_anounce_cut');
								}
							else
								{
									$tmp_cut_news = sm_settings('short_news_cut');
								}
							if (sm_settings('news_use_preview') == 1 && !empty($row['preview_news']))
								{
									$m["list"][$i]['preview'] = $row['preview_news'];
									$m["list"][$i][4] = 1;
									$u = 1;
								}
							else
								{
									if (sm_strlen($row['text_news'])>$tmp_cut_news && $u != 1)
										$m["list"][$i]['preview'] = cut_str_by_word($row['text_news'], $tmp_cut_news, '...');
									else
										$m["list"][$i]['preview'] = $row['text_news'];
									$u = 0;
								}
							if ($row['type_news'] == 0)
								{
									$m["list"][$i]['text'] = nl2br($m["list"][$i]['text']);
									$m["list"][$i]['preview'] = nl2br($m["list"][$i]['preview']);
								}
							sm_event('onlistnewsprocessed', $i);
							sm_add_title_modifier($m["list"][$i]['title']);
							sm_add_content_modifier($m["list"][$i]['text']);
							sm_add_content_modifier($m["list"][$i]['preview']);
							$i++;
						}
					if ($tmp_short_news == 0)
						{
							$m['pages']['records']=intval(getsqlfield("SELECT count(*) FROM ".sm_table_prefix()."news".$sql2));
							$m['pages']['pages'] = ceil($m['pages']['records']/sm_settings('news_by_page'));
							$m['short_news'] = 0;
							if ($i==0 && SM::GET('from')->AsInt()>0)
								sm_template('404');
						}
					else
						{
							$m['pages']['pages'] = 0;
							$m['short_news'] = 1;
						}
				}

			if (sm_action('view'))
				{
					if (!empty($m['bid']))
						$news_id = intval($m['bid']);
					else
						$news_id = 0;
					if (sm_settings('allow_alike_news') == 1)
						$tmp_no_alike_news = 0;
					else
						$tmp_no_alike_news = 1;
					if (empty($news_id) && sm_is_main_block()) $news_id = SM::GET('nid')->AsInt();
					if (!empty($news_id))
						{
							$sql = "SELECT ".sm_table_prefix()."news.*, ".sm_table_prefix()."categories_news.* FROM ".sm_table_prefix()."news, ".sm_table_prefix()."categories_news WHERE ".sm_table_prefix()."news.id_category_n=".sm_table_prefix()."categories_news.id_category AND id_news=".$news_id." LIMIT 1";
							$result = execsql($sql);
							while ($row = database_fetch_assoc($result))
								{
									sm_template('news');
									sm_event('onbeforenewsprocessing', 0);
									if (sm_is_main_block())
										sm_meta_canonical(sm_fs_url('index.php?m=news&d=view&nid='.$row['id_news'], false, sm_news_url($row['id_news'], $row['date_news'])));
									sm_page_viewid('news-'.sm_current_action().'-'.$row['id_news']);
									$m['row'] = $row;
									$m['id'] = $row['id_news'];
									$tmp=sm_load_metadata('news', $row['id_news']);
									if (!empty($tmp['seo_title']) && sm_is_main_block())
										sm_meta_title($tmp['seo_title']);
									if (!empty($tmp['news_template']))
										sm_template($tmp['news_template']);
									if (empty($row['title_news']))
										{
											if (sm_settings('news_use_time') == '1')
												sm_title(date(sm_datetime_mask(), $row['date_news']));
											else
												sm_title(date(sm_date_mask(), $row['date_news']));
										}
									else
										sm_title($row['title_news']);
									$m["date"] = $row['date_news'];
									$m["news_time"] = date(sm_time_mask(), $row['date_news']);
									$m["news_date"] = date(sm_date_mask(), $row['date_news']);
									$m["date"] = date(sm_date_mask(), $m["date"]);
									$m["text"] = $row['text_news'];
									$m["preview"] = $row['preview_news'];
									if (empty($m["preview"]))
										$m["preview"] = cut_str_by_word($row['text_news'], sm_settings('news_anounce_cut'), '...');
									$m["id_category"] = intval($row['id_category_n']);
									if (sm_is_main_block())
										$special['categories']['id'] = $row['id_category_n'];
									if ($row['no_alike_news'] == 1)
										$tmp_no_alike_news = 1;
									if (sm_settings('news_use_image') == 1)
										{
											if (file_exists(SM::FilesPath().'fullimg/news'.$m["id"].'.jpg'))
												{
													$m['news_image'] = SM::FilesPath().'fullimg/news'.$m["id"].'.jpg';
												}
											elseif (file_exists(SM::FilesPath().'img/news'.$m['id'].'.jpg'))
												{
													$m['news_image'] = 'ext/showimage.php?img=news'.$m["id"];
													if (sm_has_settings('news_image_fulltext_width'))
														$m['news_image'] .= '&width='.sm_settings('news_image_fulltext_width');
													if (sm_has_settings('news_image_fulltext_height'))
														$m['news_image'] .= '&height='.sm_settings('news_image_fulltext_height');
												}
										}
									if ($row['type_news'] == 0)
										{
											$m["text"] = nl2br($m["text"]);
										}
									if (SM::User()->Level()>=intval(sm_settings('news_editor_level')))
										{
											$m["can_edit"] = 1;
											$m["can_delete"] = 1;
										}
									elseif (!empty($userinfo['groups']))
										{
											if (compare_groups($userinfo['groups'], $row['groups_modify']))
												{
													$m["can_edit"] = 1;
													$m["can_delete"] = 1;
												}
										}
									if ($tmp_no_alike_news != 1 && $m['panel'] == 'center')
										{
											$tmpsql = "SELECT * FROM ".sm_table_prefix()."news WHERE id_category_n=".$m["id_category"]." AND id_news<>".$news_id." ORDER BY date_news DESC LIMIT ".intval(sm_settings('alike_news_count'));
											$tmpresult = execsql($tmpsql);
											$j = 0;
											while ($tmprow = database_fetch_assoc($tmpresult))
												{
													$m['alike_news'][$j]['id'] = $tmprow['id_news'];
													$m['alike_news'][$j]['title'] = $tmprow['title_news'];
													$m['alike_news'][$j]['date'] = date(sm_date_mask(), $tmprow['date_news']);
													$m['alike_news'][$j]['fullink'] = sm_fs_url('index.php?m=news&d=view&nid='.$tmprow['id_news'], false, sm_news_url($tmprow['id_news'], $tmprow['date_news']));
													$m['alike_news'][$j]['preview'] = $tmprow['preview_news'];
													if (empty($m['alike_news'][$j]['preview']))
														$m['alike_news'][$j]['preview'] = cut_str_by_word($tmprow['text_news'], sm_settings('news_anounce_cut'), '...');
													if (empty($m['alike_news'][$j]['title']))
														$m['alike_news'][$j]['title'] = $m['alike_news'][$j]['preview'];
													sm_add_title_modifier($m['alike_news'][$j]['title']);
													sm_add_content_modifier($m['alike_news'][$j]['preview']);
													$j++;
												}
											$m['alike_news_present'] = $j;
										}
									else
										$m['alike_news_present'] = 0;
									$m['attachments'] = sm_get_attachments('news', $row['id_news']);
									if (sm_is_main_block())
										{
											if (!empty(sm_get_meta_keywords()) && !empty($row['keywords_news']))
												sm_meta_keywords($row['keywords_news'].', '.sm_get_meta_keywords());
											elseif (!empty($row['keywords_news']))
												sm_meta_keywords($row['keywords_news']);
											if (!empty($row['description_news']))
												sm_meta_description($row['description_news']);
										}
									sm_event('onnewsprocessed', 0);
									sm_event('onviewnews', array($m["id"]));
								}
							sm_add_content_modifier($m["text"]);
						}
				}

			if (SM::isLoggedIn())
				include('modules/inc/memberspart/news.php');
		}// user level view restrictions end

