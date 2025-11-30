<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	/*
	Module Name: Search
	Module URI: http://simancms.apserver.org.ua/modules/search/
	Description: Search module. Base CMS module
	Version: 1.6.23
	Revision: 2023-08-27
	Author URI: http://simancms.apserver.org.ua/
	*/

	use SM\SM;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	/** @var string[]|string[][]|string[][][] $lang */
	sm_default_action('search');

	if (intval(sm_settings('search_module_disabled'))==0)
		{
			if (sm_action('search'))
				{
					if (!empty($m["bid"]))
						{
							sm_set_action('shortview');
						}
					else
						{
							$search_request=trim(SM::GET('q')->AsString());
							sm_template('search');
							sm_event('beforesearch', [$search_request]);
							while (sm_strpos($search_request, '  '))
								str_replace('  ', ' ', $search_request);
							$special['search_text']=$search_request;
							if (empty($search_request))
								sm_title($lang['module_search']['search']);
							else
								{
									sm_title($lang['module_search']['search_results']);
									$result=execsql("SELECT * FROM ".sm_table_prefix()."modules");
									$srch_elem=0;
									$i=0;
									while ($row=database_fetch_object($result))
										{
											$from_record=SM::GET('from')->AsAbsInt();
											$from_page=ceil(($from_record+1)/sm_settings('search_items_by_page'));
											if (empty($row->search_doing) || empty($row->search_enabled))
												continue;
											$srch_table=sm_table_prefix().$row->search_table;
											$srch_module=$row->module_name;
											$srch_doing=$row->search_doing;
											$srch_var=$row->search_var;
											$srch_title=$row->search_title;
											$srch_fields=$row->search_fields;
											$srch_idfield=$row->search_idfield;
											$srch_text=$row->search_text;
											$srch_mode=' AND ';
											$srch_comparefull=0;
											$srch_fields=explode(' ', $srch_fields);
											$srch_query=explode(' ', $search_request);
											$filter='';
											for ($j=0; $j<count($srch_fields); $j++)
												{
													if ($j!==0)
														$filter.=' OR ';
													$filter.=' (';
													for ($k=0; $k<count($srch_query); $k++)
														{
															if ($k!=0)
																$filter.=$srch_mode;
															if ($srch_comparefull==1)
																{
																	$filter.=$srch_fields[$j].'LIKE \''.dbescape($srch_query[$k]).'\'';
																}
															else
																{
																	$filter.=$srch_fields[$j].' LIKE \'%'.dbescape($srch_query[$k]).'%\'';
																}
														}
													$filter.=')';
												}
											if (sm_strcmp($srch_module, 'content')==0)
												$sql='SELECT '.sm_table_prefix().'content.* FROM '.sm_table_prefix().'content, '.sm_table_prefix().'categories WHERE '.sm_table_prefix().'content.id_category_c='.sm_table_prefix().'categories.id_category AND '.sm_table_prefix().'categories.can_view<='.SM::User()->Level()." AND refuse_direct_show=0 AND disable_search=0 AND ($filter)";
											elseif (sm_strcmp($srch_module, 'news')==0)
												$sql="SELECT * FROM $srch_table WHERE disable_search=0 AND ($filter)";
											else
												$sql="SELECT * FROM $srch_table WHERE $filter";
											$srresult=execsql($sql);
											while ($srrow=database_fetch_array($srresult))
												{
													if ($from_record<=$i && $i<$from_record+sm_settings('search_items_by_page'))
														{
															$m['search'][$srch_elem]['title']=$srrow[$srch_title];
															$m['search'][$srch_elem]['url']=sm_fs_url('index.php?m='.$srch_module.'&d='.$srch_doing.'&'.$srch_var.'='.$srrow[$srch_idfield]);
															$m['search'][$srch_elem]['text']=strip_tags($srrow[$srch_text]);
															if (sm_strlen($m['search'][$srch_elem]['text'])>250)
																$m['search'][$srch_elem]['text']=substr($m['search'][$srch_elem]['text'], 0, 250).'...';
															if (empty($m['search'][$srch_elem]['title']))
																$m['search'][$srch_elem]['title']=$row->module_title;
															$srch_elem++;
														}
													$i++;
												}
											$m['result_count']=$i;
											sm_pagination_init($m['result_count'], sm_settings('search_items_by_page'), $from_record, 'index.php?m=search&q='.urlencode($search_request));
										}
								}
							sm_event('aftersearch', [$search_request]);
						}
				}

			sm_on_action('shortview', function ()
				{
					sm_template('search');
					sm_title(sm_lang('module_search.search'));
				});

		}

	if (SM::isAdministrator())
		include('modules/inc/adminpart/search.php');
