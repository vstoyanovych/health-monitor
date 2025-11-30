<?php

	namespace SM\Media;

	class MediaImage extends \SM\Common\SMGenericObject
		{

			function __construct($id_or_cachedinfo)
				{
					parent::__construct($id_or_cachedinfo, sm_table_prefix().'media', 'id', 'title');
				}

			function URLForRealSize()
				{
					return $this->FilePathForRealSize();
				}

			function URLForMedium()
				{
					return $this->FilePathForMedium();
				}

			function URLForThumb()
				{
					return $this->FilePathForThumb();
				}

			function Description()
				{
					return $this->FieldStringValue('description');
				}

			function MIMEType()
				{
					return $this->FieldStringValue('type');
				}

			function CategoryID()
				{
					return $this->FieldIntValue('id_ctg');
				}

			private function FilePathForMedium()
				{
					$filepath=$this->FilePathForRealSize();
					$info=pathinfo($filepath);
					$filename=$info['dirname'].'/'.$info['filename'].'-medium.'.$info['extension'];
					if (file_exists($filename))
						return $filename;
					else
						return $filepath;
				}

			private function FilePathForThumb()
				{
					$filepath=$this->FilePathForRealSize();
					$info=pathinfo($filepath);
					$filename=$info['dirname'].'/'.$info['filename'].'-small.'.$info['extension'];
					if (file_exists($filename))
						return $filename;
					else
						return $filepath;
				}

			private function FilePathForRealSize()
				{
					return $this->FieldStringValue('filepath');
				}

			function OnRemoveAfterEnd()
				{
					$category=new MediaCategory($this->CategoryID());
					$category->RecalculateItemsCount();
					sm_saferemove('index.php?m=media&d=view&id='.$this->ID());
					if (file_exists($this->FilePathForThumb()))
						unlink($this->FilePathForThumb());
					if (file_exists($this->FilePathForMedium()))
						unlink($this->FilePathForMedium());
					if (file_exists($this->FilePathForRealSize()))
						unlink($this->FilePathForRealSize());
				}

		}
