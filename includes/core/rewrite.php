<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.19
	//#revision 2020-09-20
	//==============================================================================

	use SM\SM;

	function siman_basic_rewrite()
		{
			global $_getvars;

			if (in_array(sm_getvars('rewrittenquery'), ['robots.txt', 'ads.txt']))
				{
					@header('Content-type: text/plain; charset=utf-8');
					$result=execsql("SELECT value_settings FROM ".sm_table_prefix()."settings WHERE name_settings='".dbescape(str_replace('.', '_', sm_getvars('rewrittenquery')))."' AND `mode`='seo'");
					if ($result)
						{
							$data=database_fetch_row($result);
							if (!empty($data[0]))
								print($data[0]);
						}
					exit();
				}

			if (substr(SM::GET('rewrittenquery')->AsString(), -1)=='/')
				SM::GET('rewrittenquery')->SetValue(substr(SM::GET('rewrittenquery')->AsString(), 0, -1));
			$tmp=dbescape(SM::GET('rewrittenquery')->AsString());
			$result=execsql("SELECT url_fs FROM ".sm_table_prefix()."filesystem WHERE `filename_fs`='".$tmp."' OR `filename_fs`='".$tmp."/' LIMIT 1");
			if (!$result)
				exit('SiMan CMS is not installed or rewrite table is corrupted!');
			$data=database_fetch_row($result);
			if (!empty($data[0]))
				$url=$data[0];

			if (empty($url))
				$url='index.php?m=404';

			$query=substr($url, 10);

			$options=explode('&', $query);

			foreach ($options as $option)
				{
					$tmp=explode('=', $option);
					if (!isset($tmp[1]))
						$tmp[1]='';
					SM::GET($tmp[0])->SetValue($tmp[1]);
				}

		}
	if (!empty(sm_getvars('rewrittenquery')))
		siman_basic_rewrite();
