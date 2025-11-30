<?php

	use SM\Common\WarningsMaintainer;
	use SM\SM;

	if (!defined("TPLENGINES_FUNCTIONS_DEFINED"))
		{
			function sm_tpl_load_engine()
				{
					require_once('Smarty/libs/Smarty.class.php');
				}

			function sm_tpl_init_engine()
				{
					global $smarty;
					$smarty = new Smarty;
				}

			function sm_tpl_error($error_name)
				{
					global $smarty;
					$smarty->assign('errorname', $error_name);
					$smarty->display('error.tpl');
				}

			function sm_tpl_init_theme($themename, $compile_subdir=NULL)
				{
					global $smarty;
					if ($compile_subdir===NULL)
						$compile_subdir=$themename;
					$smarty->template_dir = 'themes/'.$themename.'/';
					$smarty->compile_dir = SM::FilesPath().'themes/'.$compile_subdir.'/';
					$smarty->config_dir = 'themes/'.$themename.'/';
					$smarty->cache_dir = SM::TemporaryFilesPath();
					$smarty->template_dir_default = 'themes/default/';
				}

			function sm_tpl_assign($tpl_var, $value)
				{
					global $smarty;
					$smarty->assign($tpl_var, $value);
				}

			function sm_tpl_assign_by_ref($tpl_var, &$value)
				{
					global $smarty;
					$smarty->assign_by_ref($tpl_var, $value);
				}

			function sm_tpl_display($root_template_name)
				{
					global $smarty;
					WarningsMaintainer::PHPDisableWarnings();
					$smarty->display($root_template_name.'.tpl');
					WarningsMaintainer::PHPRestorePreviousWarningMode();
				}

			function sm_tpl_fetch_output($root_template_name)
				{
					global $smarty;
					WarningsMaintainer::PHPDisableWarnings();
					$result=$smarty->fetch($root_template_name.'.tpl');
					WarningsMaintainer::PHPRestorePreviousWarningMode();
					return $result;
				}

			sm_tpl_load_engine();

			define("TPLENGINES_FUNCTIONS_DEFINED", 1);
		}
