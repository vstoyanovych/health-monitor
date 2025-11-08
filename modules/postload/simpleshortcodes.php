<?php

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	function simpleshortcodes_replace_time($str)
		{
			$first = sm_strpos($str, '[[time][');
			$last = sm_strpos($str, ']]', $first);
			$last += 2;
			$key = substr($str, $first + 2, $last - $first - 4);
			$p = explode('][', $key);
			if (empty($p[1]))
				$replacer = date(sm_time_mask(), time() + intval($p[2]));
			else
				$replacer = date($p[1], time() + intval($p[2]));
			$str = substr($str, 0, $first).$replacer.substr($str, $last);
			return $str;
		}

	function simpleshortcodes_replace_date($str)
		{
			$first = sm_strpos($str, '[[date][');
			$last = sm_strpos($str, ']]', $first);
			$last += 2;
			$key = substr($str, $first + 2, $last - $first - 4);
			$p = explode('][', $key);
			if (empty($p[1]))
				$replacer = date(sm_date_mask(), time() + intval($p[2]));
			else
				$replacer = date($p[1], time() + intval($p[2]));
			$str = substr($str, 0, $first).$replacer.substr($str, $last);
			return $str;
		}

	function simpleshortcodes_replace_userinfo($str)
		{
			global $userinfo;
			$first = sm_strpos($str, '[[userinfo][');
			$last = sm_strpos($str, ']]', $first);
			$last += 2;
			$key = substr($str, $first + 2, $last - $first - 4);
			$p = explode('][', $key);
			$replacer = $userinfo[$p[1]];
			if (empty($replacer) && !empty($userinfo['info'][$p[1]]))
				$replacer = $userinfo['info'][$p[1]];
			$str = substr($str, 0, $first).$replacer.substr($str, $last);
			return $str;
		}

	function simpleshortcodes_replace_settings($str)
		{
			$first = sm_strpos($str, '[[settings][');
			$last = sm_strpos($str, ']]', $first);
			$last += 2;
			$key = substr($str, $first + 2, $last - $first - 4);
			$p = explode('][', $key);
			if ($p[1] == 'resource_url')
				$replacer = sm_settings('resource_url');
			elseif ($p[1] == 'resource_title')
				$replacer = sm_settings('resource_title');
			elseif ($p[1] == 'administrators_email')
				$replacer = sm_settings('administrators_email');
			$str = substr($str, 0, $first).$replacer.substr($str, $last);
			return $str;
		}

	function simpleshortcodes_replace_uppermenu($str)
		{
			global $special;
			$first = sm_strpos($str, '[[uppermenu][');
			$last = sm_strpos($str, ']]', $first);
			$last += 2;
			$key = substr($str, $first + 2, $last - $first - 4);
			$p = explode('][', $key);
			$replacer = '';
			$special["uppermenu"] = siman_load_menu(intval($p[1]));
			$str = substr($str, 0, $first).$replacer.substr($str, $last);
			return $str;
		}

	function simpleshortcodes_replace_bottommenu($str)
		{
			global $special;
			$first = sm_strpos($str, '[[bottommenu][');
			$last = sm_strpos($str, ']]', $first);
			$last += 2;
			$key = substr($str, $first + 2, $last - $first - 4);
			$p = explode('][', $key);
			$replacer = '';
			$special["bottommenu"] = siman_load_menu(intval($p[1]));
			$str = substr($str, 0, $first).$replacer.substr($str, $last);
			return $str;
		}

	function simpleshortcodes_replace_changetheme($str)
		{
			$first = sm_strpos($str, '[[changetheme][');
			$last = sm_strpos($str, ']]', $first);
			$last += 2;
			$key = substr($str, $first + 2, $last - $first - 4);
			$p = explode('][', $key);
			$replacer = '';
			if (sm_is_valid_modulename($p[1]) && file_exists('themes/'.$p[1].'/'))
				{
					sm_change_theme($p[1]);
				}
			$str = substr($str, 0, $first).$replacer.substr($str, $last);
			return $str;
		}

	function simpleshortcodes_replace_keywords($str)
		{
			global $special;
			$first = sm_strpos($str, '[[keywords][');
			$last = sm_strpos($str, ']]', $first);
			$last += 2;
			$key = substr($str, $first + 2, $last - $first - 4);
			$p = explode('][', $key);
			$replacer = '';
			$special['meta']['keywords'] = $p[1];
			$str = substr($str, 0, $first).$replacer.substr($str, $last);
			return $str;
		}

	function simpleshortcodes_replace_description($str)
		{
			global $special;
			$first = sm_strpos($str, '[[description][');
			$last = sm_strpos($str, ']]', $first);
			$last += 2;
			$key = substr($str, $first + 2, $last - $first - 4);
			$p = explode('][', $key);
			$replacer = '';
			$special['meta']['description'] = $p[1];
			$str = substr($str, 0, $first).$replacer.substr($str, $last);
			return $str;
		}


	for ($i = 0; $i < sm_count($special['contentmodifier']); $i++)
		{
			while (sm_strpos($special['contentmodifier'][$i], '[[time]['))
				{
					$special['contentmodifier'][$i] = simpleshortcodes_replace_time($special['contentmodifier'][$i]);
				}
			while (sm_strpos($special['titlemodifier'][$i], '[[time]['))
				{
					$special['titlemodifier'][$i] = simpleshortcodes_replace_time($special['titlemodifier'][$i]);
				}
			while (sm_strpos($special['contentmodifier'][$i], '[[date]['))
				{
					$special['contentmodifier'][$i] = simpleshortcodes_replace_date($special['contentmodifier'][$i]);
				}
			while (sm_strpos($special['titlemodifier'][$i], '[[date]['))
				{
					$special['titlemodifier'][$i] = simpleshortcodes_replace_date($special['titlemodifier'][$i]);
				}
			while (sm_strpos($special['contentmodifier'][$i], '[[userinfo]['))
				{
					$special['contentmodifier'][$i] = simpleshortcodes_replace_userinfo($special['contentmodifier'][$i]);
				}
			while (sm_strpos($special['titlemodifier'][$i], '[[userinfo]['))
				{
					$special['titlemodifier'][$i] = simpleshortcodes_replace_userinfo($special['titlemodifier'][$i]);
				}
			while (sm_strpos($special['contentmodifier'][$i], '[[settings]['))
				{
					$special['contentmodifier'][$i] = simpleshortcodes_replace_settings($special['contentmodifier'][$i]);
				}
			while (sm_strpos($special['titlemodifier'][$i], '[[settings]['))
				{
					$special['titlemodifier'][$i] = simpleshortcodes_replace_settings($special['titlemodifier'][$i]);
				}
			while (sm_strpos($special['contentmodifier'][$i], '[[uppermenu]['))
				{
					$special['contentmodifier'][$i] = simpleshortcodes_replace_uppermenu($special['contentmodifier'][$i]);
				}
			while (sm_strpos($special['contentmodifier'][$i], '[[bottommenu]['))
				{
					$special['contentmodifier'][$i] = simpleshortcodes_replace_bottommenu($special['contentmodifier'][$i]);
				}
			while (sm_strpos($special['contentmodifier'][$i], '[[changetheme]['))
				{
					$special['contentmodifier'][$i] = simpleshortcodes_replace_changetheme($special['contentmodifier'][$i]);
				}
			while (sm_strpos($special['contentmodifier'][$i], '[[keywords]['))
				{
					$special['contentmodifier'][$i] = simpleshortcodes_replace_keywords($special['contentmodifier'][$i]);
				}
			while (sm_strpos($special['contentmodifier'][$i], '[[description]['))
				{
					$special['contentmodifier'][$i] = simpleshortcodes_replace_description($special['contentmodifier'][$i]);
				}
		}
