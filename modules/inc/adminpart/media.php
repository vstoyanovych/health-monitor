<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.23
	//#revision 2023-08-27
	//==============================================================================

	use SM\Common\Redirect;
	use SM\Media\MediaCategory;
	use SM\Media\MediaImage;
	use SM\SM;
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\Navigation;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (!defined("MEDIAADMIN_FUNCTIONS_DEFINED"))
		{
			function siman_update_media_category_count($id_ctg)
				{
					$category=new MediaCategory($id_ctg);
					if ($category->Exists())
						$category->RecalculateItemsCount();
				}
			function siman_notemptyuintwithdefault($int, $default)
				{
					if (intval($int)<=0)
						return intval($default);
					return $int;
				}

			define("MEDIAADMIN_FUNCTIONS_DEFINED", 1);
		}

	/** @var $_uplfilevars */
	/** @var $lang */
	/** @var $_settings */
	if (SM::isAdministrator())
		{
			sm_include_lang('media');

			sm_on_action('postdelete', function ()
				{
					$media=new MediaImage(SM::GET('id')->AsInt());
					if ($media->Exists())
						{
							$media->Remove();
							Redirect::ReturnToNow();
						}
				});

			if (sm_action('postadd'))
				{
					$category=new MediaCategory(SM::GET('ctg')->AsInt());
					if (!$category->Exists())
						return;
					$error=[];
					$qty=0;
					for ($i=0; $i<sm_count($_uplfilevars['userfile']['name']); $i++)
						{
							if (!empty($_uplfilevars['userfile']['name'][$i]))
								$qty++;
						}
					if ($qty==0)
						{
							$error[]=$lang['module_galleries']['add_at_least_one_image'];
						}
					else
						{
							for ($i=0; $i<sm_count($_uplfilevars['userfile']['name']); $i++)
								{
									if (empty($_uplfilevars['userfile']['name'][$i]))
										continue;
									$extension=strtolower(pathinfo($_uplfilevars['userfile']['name'][$i], PATHINFO_EXTENSION));
									if (!sm_is_allowed_to_upload($_uplfilevars['userfile']['name'][$i]) || !in_array($extension, nllistToArray(sm_settings('media_allowed_extensions'), true)))
										{
											$error[]=$lang['module_admin']['message_wrong_file_name'].' '.$_uplfilevars['userfile']['name'][$i];
										}
									elseif ($tmpfile=sm_upload_file('userfile', '', $i))
										{
											$q=new TQuery(sm_table_prefix().'media');
											$q->Add('id_ctg', $category->ID());
											$q->Add('type', dbescape($_uplfilevars['userfile']['type'][$i]));
											$q->Add('title', dbescape(pathinfo($_uplfilevars['userfile']['name'][$i], PATHINFO_FILENAME)));
											$q->Add('originalname', dbescape($_uplfilevars['userfile']['name'][$i]));
											$q->Add('alt_text', dbescape(sm_postvars('alt_text')));
											$q->Add('description', dbescape(sm_postvars('description')));
											$id=$q->Insert();
											$filename=SM::FilesPath().'img/mediaimage'.$id.'.'.$extension;
											$filename_medium=SM::FilesPath().'img/mediaimage'.$id.'-medium.'.$extension;
											$filename_small=SM::FilesPath().'img/mediaimage'.$id.'-small.'.$extension;
											$q=new TQuery(sm_table_prefix().'media');
											$q->Add('filepath', dbescape($filename));
											$q->Update('id', intval($id));
											rename($tmpfile, $filename);
											sm_resizeimage($filename, $filename_small, sm_settings('media_thumb_width'), sm_settings('media_thumb_height'), 0, 100, 1);
											sm_resizeimage($filename, $filename_medium, $category->GetWidthToApplyToMediumImage(), $category->GetHeightToApplyToMediumImage());
											if (intval(sm_get_settings('media_erase_original_image', 'media'))==1)
												unlink($filename);
											$category->RecalculateItemsCount();
										}
									else
										{
											$error[]=$lang['error_file_upload_message'].' '.$_uplfilevars['userfile']['name'][$i];
										}
								}
						}
					if (sm_count($error)>0)
						sm_set_action('add');
					else
						{
							$q=new TQuery(sm_table_prefix().'categories_media');
							$q->Add('lastupdate', time());
							$q->Update('id_ctg', $category->ID());
							if (intval(sm_get_settings('media_edit_after_upload', 'media'))==1)
								sm_redirect('index.php?m=media&d=edit&id='.intval($id).'&returnto='.urlencode(sm_getvars('returnto')));
							else
								Redirect::ReturnToNow();
						}
				}

			if (sm_action('postedit'))
				{
					$info=TQuery::ForTable(sm_table_prefix().'media')->Add('id', intval(sm_getvars('id')))->Get();
					if (!empty($info['id']))
						{
							$q = new TQuery(sm_table_prefix().'media');
							$q->Add('id_ctg', intval(sm_postvars('id_ctg')));
							$q->Add('title', dbescape(sm_postvars('title')));
							$q->Add('alt_text', dbescape(sm_postvars('alt_text')));
							$q->Add('description', dbescape(sm_postvars('description')));
							if (sm_action('postadd'))
								$q->Insert();
							else
								$q->Update('id', intval(sm_getvars('id')));
							if (intval($info['id_ctg'])!=intval(sm_postvars('id_ctg')))
								siman_update_media_category_count(intval($info['id_ctg']));
							siman_update_media_category_count(intval(sm_postvars('id_ctg')));
							Redirect::ReturnToNow();
						}
				}

			if (sm_action('edit'))
				{
					add_path_modules();
					add_path(sm_lang('module_galleries.media_files'), 'index.php?m=media&d=admin');
					add_path($lang['module_galleries']['galleries'], 'index.php?m=media&d=libraries');
					add_path_current();
					$ui = new UI();
					if (!empty($error))
						$ui->NotificationError($error);
					sm_title($lang['common']['edit']);
					$q=new TQuery(sm_table_prefix().'categories_media');
					$q->OrderBy('title');
					$q->Select();
					$f = new Form('index.php?m=media&d=postedit&id='.intval(sm_getvars('id')).'&returnto='.urlencode(sm_getvars('returnto')));
					$f->AddStatictext('filepath', $lang['file_name']);
					$f->AddSelect('id_ctg', $lang['common']['category'], $q->ColumnValues('id_ctg'), $q->ColumnValues('title'));
					$f->SelectAddBeginVL('id_ctg', 0, $lang['common']['uncategorized']);
					$f->AddText('title', $lang['common']['title']);
					$f->AddText('alt_text', $lang['common']['alt_text']);
					$f->AddTextarea('description', $lang['common']['description']);
					if (sm_action('edit'))
						{
							$q = new TQuery(sm_table_prefix().'media');
							$q->Add('id', intval(sm_getvars('id')));
							$f->LoadValuesArray($q->Get());
							unset($q);
						}
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					$ui->Output(true);
					sm_setfocus('id_ctg');
				}

			sm_on_action('detailinfo', function ()
				{
					global $lang;
					$media=new MediaImage(intval(sm_getvars('id')));
					if ($media->Exists())
						{
							add_path_modules();
							sm_add_cssfile('css/adminpart/media-detailinfo.css');
							add_path(sm_lang('module_galleries.media_files'), 'index.php?m=media&d=admin');
							add_path($lang['module_galleries']['galleries'], 'index.php?m=media&d=libraries');
							$ctg=TQuery::ForTable(sm_table_prefix().'categories_media')->Add('id_ctg', $media->CategoryID())->Get();
							if (!empty($ctg['id_ctg']))
								add_path($ctg['title'], 'index.php?m=media&d=list&ctg='.$ctg['id_ctg']);
							else
								add_path($lang['common']['uncategorized'], 'index.php?m=media&d=list&ctg=0');
							add_path_current();
							sm_title($lang['common']['image'].' - '.$media->Title());
							$ui = new UI();
							$b=new Buttons();
							$b->Button($lang['common']['small'], sm_this_url('size', 'small'));
							if (sm_getvars('size')=='small')
								$b->Bold();
							$b->Button($lang['common']['medium'], sm_this_url('size', 'medium'));
							if (sm_getvars('size')=='medium' || empty(sm_getvars('size')))
								$b->Bold();
							$b->Button($lang['common']['big'], sm_this_url('size', 'big'));
							if (sm_getvars('size')=='big')
								$b->Bold();
							$ui->Add($b);
							$ui->div_open('image-detail-'.$media->ID(), 'image-detail');
							if (sm_getvars('size')=='big')
								$img=$media->URLForRealSize();
							elseif (sm_getvars('size')=='small')
								$img=$media->URLForThumb();
							else
								$img=$media->URLForMedium();
							$ui->img($img);
							$ui->div_close();
							$f=new Form(false);
							$f->AddText('url', $lang['url'])->WithValue(sm_homepage().$img);
							$ui->Add($f);
							$ui->Output(true);
						}
				});

			if (sm_action('add'))
				{
					add_path_modules();
					add_path(sm_lang('module_galleries.media_files'), 'index.php?m=media&d=admin');
					add_path($lang['module_galleries']['galleries'], 'index.php?m=media&d=libraries');
					$ctg=TQuery::ForTable(sm_table_prefix().'categories_media')->Add('id_ctg', intval(sm_getvars('ctg')))->Get();
					if (!empty($ctg['id_ctg']))
						add_path($ctg['title'], 'index.php?m=media&d=list&ctg='.$ctg['id_ctg']);
					else
						add_path($lang['common']['uncategorized'], 'index.php?m=media&d=list&ctg=0');
					add_path_current();
					$ui = new UI();
					if (isset($error) && is_array($error))
						for ($i = 0; $i < sm_count($error); $i++)
							$ui->NotificationError($error[$i]);
					sm_title($lang['upload']);
					$f = new Form('index.php?m=media&d=postadd&ctg='.intval($ctg['id_ctg']).'&returnto='.urlencode(sm_getvars('returnto')));
					for ($i = 0; $i < 10; $i++)
						{
							$f->AddFile('userfile['.$i.']', $lang['common']['file']);
						}
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					$ui->Output(true);
					sm_setfocus('userfile');
				}

			if (sm_action('list'))
				{
					add_path_modules();
					add_path(sm_lang('module_galleries.media_files'), 'index.php?m=media&d=admin');
					add_path($lang['module_galleries']['galleries'], 'index.php?m=media&d=libraries');
					add_path_current();
					$ctg=TQuery::ForTable(sm_table_prefix().'categories_media')->Add('id_ctg', intval(sm_getvars('ctg')))->Get();
					if (!empty($ctg['id_ctg']))
						sm_title($ctg['title']);
					else
						sm_title($lang['common']['uncategorized']);
					$offset = sm_abs(sm_getvars('from'));
					$limit = 30;
					$ui = new UI();
					$b = new Buttons();
					$b->AddButton('add', $lang['common']['add'], 'index.php?m=media&d=add&ctg='.intval(sm_getvars('ctg')).'&returnto='.urlencode(sm_this_url()));
					$ui->AddButtons($b);
					$t = new Grid();
					$t->AddCol('id', $lang['common']['id']);
					$t->AddCol('image', $lang['common']['image']);
					$t->AddCol('type', $lang['common']['type']);
					$t->AddCol('title', $lang['common']['description']);
					$t->AddCol('action', $lang['action']);
					$t->AddEdit();
					$t->AddDelete();
					$q = new TQuery(sm_table_prefix().'media');
					$q->Add('id_ctg', intval(sm_getvars('ctg')));
					$q->Limit($limit);
					$q->Offset($offset);
					$q->Select();
					for ($i = 0; $i < $q->Count(); $i++)
						{
							$media=new MediaImage($q->items[$i]);
							$t->Label('id', $media->ID());
							$t->Image('image', $media->URLForThumb());
							$t->URL('image', 'index.php?m=media&d=detailinfo&id='.$media->ID());
							$t->Label('type', $media->MIMEType());
							$t->Label('title', $media->Title());
							$t->Label('description', $media->Description());
							$t->Label('action', $lang['action']);
							$t->DropDownItem('action', $lang['module_galleries']['gallery_thumb'], 'index.php?m=media&d=gallerythumb&id='.$media->ID().'&returnto='.urlencode(sm_this_url()), $lang['common']['are_you_sure']);
							$t->Url('edit', 'index.php?m=media&d=edit&id='.$media->ID().'&returnto='.urlencode(sm_this_url()));
							$t->Url('delete', 'index.php?m=media&d=postdelete&id='.$media->ID().'&returnto='.urlencode(sm_this_url()));
							$t->NewRow();
						}
					if ($t->RowCount()==0)
						$t->SingleLineLabel($lang['messages']['nothing_found']);
					$ui->AddGrid($t);
					$ui->AddPagebarParams($q->TotalCount(), $limit, $offset);
					$ui->AddButtons($b);
					$ui->Output(true);
				}

			sm_on_action('postdeletectg', function ()
				{
					$category=new MediaCategory(SM::GET('id')->AsInt());
					if ($category->Exists())
						{
							$category->Remove();
							Redirect::ReturnToNow();
						}
				});

			if (sm_action('gallerythumb'))
				{
					$image=TQuery::ForTable(sm_table_prefix().'media')
						->AddWhere('id', intval(sm_getvars('id')))
						->Get();
					$ctg=TQuery::ForTable(sm_table_prefix().'categories_media')
						->AddWhere('id_ctg', intval($image['id_ctg']))
						->Get();
					if (!empty($ctg['id_ctg']) && file_exists($image['filepath']))
						{
							$filename=SM::FilesPath().'img/mediagallery'.$ctg['id_ctg'].'.jpg';
							if (file_exists($filename))
								unlink($filename);
							sm_resizeimage($image['filepath'], $filename, sm_settings('gallery_thumb_width'), sm_settings('gallery_thumb_height'), 0, 100, 1);
						}
					Redirect::ReturnToNow();
				}


			sm_on_action(['postaddctg', 'posteditctg'], function ()
				{
					if (empty(sm_postvars('title')))
						{
							SM::Errors()->AddError(sm_lang('messages.fill_required_fields'));
							if (sm_action('postaddctg'))
								sm_set_action('addctg');
							else
								sm_set_action('editctg');
						}
					else
						{
							$q=new TQuery(sm_table_prefix().'categories_media');
							$q->Add('title', dbescape(SM::POST('title')->EscapedString()));
							$q->Add('public', SM::POST('public')->AsInt());
							$q->Add('keywords', dbescape(SM::POST('keywords')->EscapedString()));
							$q->Add('description', dbescape(SM::POST('description')->EscapedString()));
							$q->Add('medium_width', SM::POST('medium_width')->AsInt());
							$q->Add('medium_height', SM::POST('medium_height')->AsInt());
							$q->Add('lastupdate', time());
							if (sm_action('postaddctg'))
								$id=$q->Insert();
							else
								{
									$id=SM::GET('id')->AsInt();
									$q->Update('id_ctg', $id);
								}
							if (sm_action('postaddctg'))
								sm_fs_update(sm_lang('module_galleries.gallery').' - '.sm_postvars('title'), 'index.php?m=media&d=gallery&id='.$id, 'media/galleries/'.$id.'-'.sm_getnicename(sm_postvars('title')).'.html');
							if ($file=sm_upload_file('userfile'))
								{
									sm_resizeimage($file, SM::FilesPath().'img/mediagallery'.$id.'.jpg', sm_settings('gallery_thumb_width'), sm_settings('gallery_thumb_height'), 0, 100, 1);
									unlink($file);
								}
							Redirect::ReturnToNow();
						}
				});

			sm_on_action(['addctg', 'editctg'], function ()
				{
					add_path_modules();
					add_path(sm_lang('module_galleries.media_files'), 'index.php?m=media&d=admin');
					add_path_current();
					$ui = new UI();
					SM::Errors()->DisplayUIErrors($ui);
					if (sm_action('editctg'))
						{
							sm_title(sm_lang('module_galleries.gallery').' - '.sm_lang('common.edit'));
							$f=new Form('index.php?m=media&d=posteditctg&id='.SM::GET('id')->AsInt().'&returnto='.SM::GET('returnto')->UrlencodedString());
						}
					else
						{
							sm_title(sm_lang('module_galleries.gallery').' - '.sm_lang('common.add'));
							$f=new Form('index.php?m=media&d=postaddctg&returnto='.SM::GET('returnto')->UrlencodedString());
						}
					$f->AddText('title', sm_lang('title'), true)
						->SetFocus();
					$f->AddFile('userfile', sm_lang('common.thumbnail'));
					$f->AddCheckbox('public', sm_lang('common.public'));
					$f->AddText('keywords', sm_lang('common.seo_keywords'));
					$f->AddTextarea('description', sm_lang('common.seo_description'));
					$f->Separator(sm_lang('module_galleries.custom_gallery_image_size_zero_default'));
					$f->AddText('medium_width', sm_lang('module_galleries.media_medium_width'));
					$f->AddText('medium_height', sm_lang('module_galleries.media_meduim_height'));
					if (sm_action('editctg'))
						{
							$q=new TQuery(sm_table_prefix().'categories_media');
							$q->Add('id_ctg', intval(sm_getvars('id')));
							$f->LoadValuesArray($q->Get());
							unset($q);
						}
					else
						{
							$f->SetValue('public', 1);
						}
					$f->LoadValuesArray(SM::Requests()->POSTAsArray());
					$ui->AddForm($f);
					$ui->Output(true);
				});

			if (sm_action('libraries'))
				{
					add_path_modules();
					add_path(sm_lang('module_galleries.media_files'), 'index.php?m=media&d=admin');
					sm_title($lang['module_galleries']['galleries']);
					add_path_current();
					$offset=sm_abs(sm_getvars('from'));
					$limit=30;
					$ui = new UI();
					$b=new Buttons();
					$b->AddButton('add', $lang['common']['add'], 'index.php?m=media&d=addctg&returnto='.urlencode(sm_this_url()));
					$ui->AddButtons($b);
					$t=new Grid();
					$t->AddCol('id_ctg', $lang['common']['id']);
					$t->AddCol('image', $lang['common']['image']);
					$t->AddCol('title', $lang['common']['title']);
					$t->AddCol('public', $lang['common']['public']);
					$t->AddCol('items_count', $lang['count']);
					$t->AddCol('action', $lang['action'], '5%');
					$t->AddEdit();
					$t->AddDelete();
					$q=new TQuery(sm_table_prefix().'categories_media');
					$q->OrderBy('lastupdate DESC');
					$q->Limit($limit);
					$q->Offset($offset);
					$q->Select();
					for ($i = 0; $i<$q->Count(); $i++)
						{
							$t->Label('id_ctg', $q->items[$i]['id_ctg']);
							if (file_exists(SM::FilesPath().'img/mediagallery'.$q->items[$i]['id_ctg'].'.jpg'))
								{
									$t->Image('image', SM::FilesPath().'img/mediagallery'.$q->items[$i]['id_ctg'].'.jpg');
									$t->Image('image', sm_thumburl('mediagallery'.$q->items[$i]['id_ctg'], 50, 50));
									$t->Url('image', 'index.php?m=media&d=list&ctg='.$q->items[$i]['id_ctg']);
								}
							$t->Label('title', $q->items[$i]['title']);
							$t->Url('title', 'index.php?m=media&d=list&ctg='.$q->items[$i]['id_ctg']);
							$t->Label('public', $q->items[$i]['public']==1?$lang['yes']:$lang['no']);
							$t->Label('items_count', $q->items[$i]['items_count']);
							$t->Label('action', $lang['action']);
							$t->DropDownItem('action', $lang['common']['view'], 'index.php?m=media&d=list&ctg='.$q->items[$i]['id_ctg']);
							$t->DropDownItem('action', $lang['module_menu']['add_to_menu'], sm_tomenuurl($q->items[$i]['title'], sm_fs_url('index.php?m=media&d=gallery&ctg='.$q->items[$i]['id_ctg']), sm_this_url()));
							$t->Url('edit', 'index.php?m=media&d=editctg&id='.$q->items[$i]['id_ctg'].'&returnto='.urlencode(sm_this_url()));
							$t->Url('delete', 'index.php?m=media&d=postdeletectg&id='.$q->items[$i]['id_ctg'].'&returnto='.urlencode(sm_this_url()));
							$t->NewRow();
						}
					$ui->AddGrid($t);
					$ui->AddPagebarParams($q->TotalCount(), $limit, $offset);
					$ui->AddButtons($b);
					$ui->Output(true);
				}

			if (sm_actionpost('postsettings'))
				{
					sm_update_settings('gallery_thumb_width', siman_notemptyuintwithdefault(sm_postvars('gallery_thumb_width'), 150));
					sm_update_settings('gallery_thumb_height', siman_notemptyuintwithdefault(sm_postvars('gallery_thumb_height'), 150));
					sm_update_settings('gallery_default_view', sm_postvars('gallery_default_view'));
					sm_update_settings('gallery_view_items_per_row', sm_abs(sm_postvars('gallery_view_items_per_row')));
					sm_update_settings('galleries_view_items_per_row', sm_abs(sm_postvars('galleries_view_items_per_row')));
					sm_update_settings('galleries_sort', sm_postvars('galleries_sort'));
					sm_update_settings('media_thumb_width', siman_notemptyuintwithdefault(sm_postvars('media_thumb_width'), 150));
					sm_update_settings('media_thumb_height', siman_notemptyuintwithdefault(sm_postvars('media_thumb_height'), 150));
					sm_update_settings('media_medium_width', siman_notemptyuintwithdefault(sm_postvars('media_medium_width'), 600));
					sm_update_settings('media_meduim_height', siman_notemptyuintwithdefault(sm_postvars('media_meduim_height'), 600));
					sm_update_settings('media_allowed_extensions', sm_postvars('media_allowed_extensions'));
					sm_update_settings('media_edit_after_upload', intval(sm_postvars('media_edit_after_upload')), 'media');
					sm_set_settings('media_erase_original_image', intval(sm_postvars('media_erase_original_image')), 'media');
					sm_set_settings('media_no_image', sm_postvars('media_no_image'));
					sm_notify($lang['settings_saved_successful']);
					sm_redirect('index.php?m=media&d=settings');
				}

			if (sm_action('settings'))
				{
					add_path_modules();
					add_path(sm_lang('module_galleries.media_files'), 'index.php?m=media&d=admin');
					add_path_current();
					sm_title($lang['settings']);
					$ui = new UI();
					$f=new Form('index.php?m=media&d=postsettings');
					$f->AddText('gallery_thumb_width', $lang['module_galleries']['gallery_thumb_width']);
					$f->AddText('gallery_thumb_height', $lang['module_galleries']['gallery_thumb_height']);
					$f->AddSelect('gallery_default_view', $lang['module_galleries']['gallery_default_view'], Array('all'), Array($lang['module_galleries']['all_images_in_one_page']));
					$f->AddText('gallery_view_items_per_row', $lang['module_galleries']['gallery_view_items_per_row']);
					$f->SetFieldBottomText('gallery_view_items_per_row', '0 - '.$lang['common']['auto']);
					$f->AddText('galleries_view_items_per_row', $lang['module_galleries']['galleries_view_items_per_row']);
					$f->SetFieldBottomText('galleries_view_items_per_row', '0 - '.$lang['common']['auto']);
					$f->AddSelect('galleries_sort', $lang['module_galleries']['galleries_sort'], Array('lastupdate_desc'), Array($lang['common']['last_update']));
					$f->AddText('media_thumb_width', $lang['module_galleries']['media_thumb_width']);
					$f->AddText('media_thumb_height', $lang['module_galleries']['media_thumb_height']);
					$f->AddText('media_medium_width', $lang['module_galleries']['media_medium_width']);
					$f->AddText('media_meduim_height', $lang['module_galleries']['media_meduim_height']);
					$f->AddTextarea('media_allowed_extensions', $lang['module_galleries']['media_allowed_extensions']);
					$f->AddCheckbox('media_edit_after_upload', $lang['module_galleries']['media_edit_after_upload']);
					$f->AddCheckbox('media_erase_original_image', $lang['module_galleries']['media_erase_original_image']);
					$f->AddText('media_no_image', $lang['module_galleries']['custom_no_image'])
					  ->WithFieldBottomText($lang['common']['leave_empty_for_default']);
					$f->LoadValuesArray($_settings);
					$f->SetValue('media_erase_original_image', sm_get_settings('media_erase_original_image', 'media'));
					$f->SetValue('media_edit_after_upload', sm_get_settings('media_edit_after_upload', 'media'));
					$f->LoadValuesArray(sm_postvars());
					$ui->AddForm($f);
					$ui->Output(true);
				}
			if (sm_action('admin'))
				{
					add_path_modules();
					sm_title(sm_lang('module_galleries.media_files'));
					add_path_current();
					$ui = new UI();
					$nav=new Navigation();
					$nav->AddItem($lang['module_galleries']['galleries'], 'index.php?m=media&d=libraries')->SetFA('photo');
					$nav->AddItem($lang['module_menu']['add_to_menu'].' - '.$lang['module_galleries']['galleries'], sm_tomenuurl($lang['module_galleries']['galleries'], sm_fs_url('index.php?m=media'), sm_this_url()))->SetFA('list');
					$nav->AddItem($lang['settings'], 'index.php?m=media&d=settings')->SetFA('settings');
					$ui->Add($nav);
					$ui->Output(true);
				}
		}

