<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#revision 2021-03-21
	//==============================================================================

	use SM\Media\MediaCategory;
	use SM\Media\MediaImage;
	use SM\SM;
	use SM\UI\ModalHelper;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (SM::User()->Level()>1)
		{
			if (sm_action('editorinsert'))
				{
					sm_template('media');
					$offset = sm_abs(sm_getvars('from'));
					$limit = 30;
					$q = new TQuery(sm_table_prefix().'categories_media');
					$q->OrderBy('lastupdate DESC');
					$q->Limit($limit);
					$q->Offset($offset);
					$q->Select();
					for ($i = 0; $i<sm_count($q->items); $i++)
						{
							$category=new MediaCategory($q->items[$i]);
							$m['galleries'][$i]['id'] = $category->ID();
							$m['galleries'][$i]['title'] = $category->Title();
							$m['galleries'][$i]['image'] = $category->URLForThumb();
							$m['galleries'][$i]['url'] = 'javascript:;';
							$m['galleries'][$i]['onclick'] = sm_ajax_load('index.php?m=media&d=editorinsertlist&ctg='.$category->ID().'&theonepage=1', ModalHelper::ModalDOMSelector());
							if (intval(sm_settings('galleries_editorinsert_items_per_row'))>0)
								if (($i+1)%intval(sm_settings('galleries_editorinsert_items_per_row')) == 0)
									$m['galleries'][$i]['newrow'] = true;
						}
				}
			if (sm_action('editorinsertlist'))
				{
					$category=new MediaCategory(intval(sm_getvars('ctg')));
					if ($category->Exists())
						{
							sm_title($category->Title());
							sm_add_cssfile('media.css');
							$ui = new UI();
							$ui->a('javascript:;', $lang['common']['back'], '', '', '', sm_ajax_load(sm_fs_url('index.php?m=media&d=editorinsert&theonepage=1'), ModalHelper::ModalDOMSelector()));
							$ui->div('', '', '', 'clear:both;');
							$q=new TQuery(sm_table_prefix().'media');
							$q->Add('id_ctg', $category->ID());
							$q->OrderBy('id DESC');
							$q->Select();
							for ($i = 0; $i<$q->Count(); $i++)
								{
									$media=new MediaImage($q->items[$i]);
									$ui->div_open('', 'gallery-insert-list-item');
									$ui->div('<a href="javascript:;" onclick="'.siman_exteditor_insert_html('[[media]['.$media->ID().']]').'"><img src="'.$media->URLForThumb().'" /></a>', '', 'gallery-insert-list-item-container');
									$ui->div_close();
								}
							$ui->Output(true);
						}
				}
		}
	