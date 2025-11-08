<?php

	use SM\Media\MediaImage;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	function media_replace_image($str)
		{
			$first = sm_strpos($str, '[[media][');
			$last = sm_strpos($str, ']]', $first);
			if (!$last)
				return $str;
			$last += 2;
			$key = substr($str, $first + 2, $last - $first - 4);
			$p = explode('][', $key);
			$replacer='';
			$replacer_start='';
			$replacer_end='';
			if (!empty($p[1]))
				{
					$image=new MediaImage(intval($p[1]));
					if ($image->Exists())
						{
							$align='left';
							$replacer='<img src="'.$image->URLForMedium().'"';
							for ($i=2; $i<count($p); $i++)
								{
									if ($p[$i]==='single')
										{
											$align='';
											$replacer_start='<div style="clear:both;text-align:center;">'.$replacer_start;
											$replacer_end.='</div>';
										}
									else
										{
											$data=explode('-', $p[$i]);
											if (count($data)!=2)
												continue;
											if ($data[0]=='align')
												$align=$data[1];
										}
								}
							if (!empty($align))
								$replacer.=' align="'.$align.'"';
							$replacer.=' />';
						}
				}
			$replacer=$replacer_start.$replacer.$replacer_end;
			$str = substr($str, 0, $first).$replacer.substr($str, $last);
			return $str;
		}

	if (isset($special['contentmodifier']) && is_array($special['contentmodifier']))
		{
			foreach ($special['contentmodifier'] as &$item)
				{
					while (sm_strpos($item, '[[media][')!==false)
						$item = media_replace_image($item);
				}
		}

