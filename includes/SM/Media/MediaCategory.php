<?php

	namespace SM\Media;

	use SM\SM;
	use TQuery;

	class MediaCategory extends \SM\Common\SMGenericObject
		{

			function __construct($id_or_cachedinfo)
				{
					parent::__construct($id_or_cachedinfo, sm_table_prefix().'categories_media', 'id_ctg', 'title');
				}

			function isPublic()
				{
					return $this->FieldBoolValue('public');
				}

			function RecalculateItemsCount()
				{
					$count=TQuery::ForTable(sm_table_prefix().'media')->Add('id_ctg', $this->ID())->TotalCount();
					$this->UpdateValues([
						'items_count'=>$count
					]);
				}

			function URLForThumb()
				{
					$image=SM::FilesPath().'img/mediagallery'.$this->ID().'.jpg';
					if (file_exists($image))
						return $image;
					else
						{
							if (!sm_empty_settings('media_no_image'))
								return sm_settings('media_no_image');
							elseif (file_exists(SM::FilesPath().'img/noimage.jpg'))
								return SM::FilesPath().'img/noimage.jpg';
							else
								return 'ext/showimage.php?img=&width='.sm_settings('gallery_thumb_width').'&height='.sm_settings('gallery_thumb_height');
						}
				}

			function GetWidthToApplyToMediumImage()
				{
					$width=$this->FieldIntValue('medium_width');
					if ($width>>0)
						return $width;
					else
						return intval(sm_settings('media_medium_width'));
				}

			function GetHeightToApplyToMediumImage()
				{
					$height=$this->FieldIntValue('medium_height');
					if ($height>>0)
						return $height;
					else
						return intval(sm_settings('media_meduim_height'));
				}

			function Remove()
				{
					sm_saferemove('index.php?m=media&d=list&id='.$this->ID());
					if (file_exists(SM::FilesPath().'img/mediagallery'.$this->ID().'.jpg'))
						unlink(SM::FilesPath().'img/mediagallery'.$this->ID().'.jpg');
					$q=new TQuery(sm_table_prefix().'media');
					$q->AddNumeric('id_ctg', 0);
					$q->Update('id_ctg', $this->ID());
					parent::Remove();
				}

		}
