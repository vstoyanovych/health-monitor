<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	/*
	Module Name: Media
	Module URI: http://simancms.apserver.org.ua/modules/media/
	Description: Media files management. Base CMS module
	Version: 1.6.23
	Revision: 2023-01-04
	Author URI: http://simancms.apserver.org.ua/
	*/

	use SM\Media\MediaCategory;
	use SM\Media\MediaImage;
	use SM\SM;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	sm_include_lang('media');
	sm_default_action('galleries');

	sm_on_action('galleries', function ()
		{
			sm_title(sm_lang('module_galleries.galleries'));
			sm_add_cssfile('media.css');
			sm_template('media');
			$offset=SM::GET('from')->AsAbsInt();
			$limit=30;
			$q=new TQuery(sm_table_prefix().'categories_media');
			$q->Add('public', 1);
			$q->OrderBy('lastupdate DESC');
			$q->Limit($limit);
			$q->Offset($offset);
			$q->Select();
			$galleries=[];
			for ($i = 0; $i<$q->Count(); $i++)
				{
					$category=new MediaCategory($q->items[$i]);
					$galleries[$i]['id']=$category->ID();
					$galleries[$i]['title']=$category->Title();
					$galleries[$i]['image']=$category->URLForThumb();
					$galleries[$i]['url']=sm_fs_url('index.php?m=media&d=gallery&ctg='.$category->ID());
					if (SM::Settings('galleries_view_items_per_row')->AsInt()>0)
						if (($i+1) % SM::Settings('galleries_view_items_per_row')->AsInt()==0)
							$galleries[$i]['newrow']=true;
				}
			sm_set_tpl_var('galleries', $galleries);
			sm_pagination_init($q->TotalCount(), $limit, $offset);
		});

	sm_on_action('gallery', function()
		{
			if (!SM::Settings('gallery_default_view')->isStringEqual('all'))
				return;
			$category=new MediaCategory(SM::GET('ctg')->AsInt());
			if ($category->Exists() && $category->isPublic())
				{
					sm_title($category->Title());
					sm_add_cssfile('media.css');
					$ui = new UI();
					$q=new TQuery(sm_table_prefix().'media');
					$q->Add('id_ctg', $category->ID());
					$q->OrderBy('id');
					$q->Select();
					foreach ($q->items as $item)
						{
							$media=new MediaImage($item);
							$ui->div('<img src="'.$media->URLForMedium().'" />', '', 'gallery-view-all-item');
						}
					$ui->Output(true);
				}
		});

	if (SM::User()->Level()>1)
		include('modules/inc/memberspart/media.php');
	if (SM::User()->Level()>2)
		include('modules/inc/adminpart/media.php');

