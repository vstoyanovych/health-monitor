<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.20
	//#revision 2021-08-15
	//==============================================================================

	function sm_count($array)
		{
			if (empty($array))
				return 0;
			elseif (!is_array($array))
				return 0;
			else
				return count($array);
		}

	function sm_get_array_value($array, $key)
		{
			if (isset($array[$key]))
				return $array[$key];
			else
				return NULL;
		}

	/** @deprecated */
	function sm_set_array_value(&$array, $key, $val)
		{
			$array[$key]=$val;
		}

	function sm_getvars($key=NULL)
		{
			global $_getvars;
			if ($key===NULL)
				return $_getvars;
			elseif (empty($_getvars[$key]))
				return '';
			else
				return $_getvars[$key];
		}

	function sm_postvars($key=NULL)
		{
			global $_postvars;
			if ($key===NULL)
				return $_postvars;
			elseif (empty($_postvars[$key]))
				return '';
			else
				return $_postvars[$key];
		}

	function sm_abs($var)
		{
			return abs(intval($var));
		}

	/**
	 * CMS root directory path
	 * @return string
	 */
	function sm_cms_rootdir()
		{
			return dirname(dirname(dirname(__FILE__))).'/';
		}
	
	function sm_file_path($relative_filename)
		{
			return sm_cms_rootdir().$relative_filename;
		}

	function sm_null_safe_str($val)
		{
			if ($val===NULL)
				return '';
			else
				return $val;
		}

	function sm_strcmp($str1, $str2)
		{
			return strcmp(sm_null_safe_str($str1), sm_null_safe_str($str2));
		}

	function sm_strlen($str)
		{
			return strlen(sm_null_safe_str($str));
		}

	function sm_strpos($haystack, $needle, $offset=0)
		{
			return strpos(sm_null_safe_str($haystack), sm_null_safe_str($needle), $offset);
		}

	function sm_auto_class_loader($classname)
		{
			if (strcmp(substr($classname, 0, 3), 'SM\\')==0)
				include_once(dirname(dirname(__FILE__)).'/'.str_replace('\\', '/', $classname).'.php');
		}
	
	function sm_session_prefix()
		{
			global $session_prefix;
			return $session_prefix;
		}

	spl_autoload_register('sm_auto_class_loader');
