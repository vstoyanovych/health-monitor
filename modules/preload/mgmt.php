<?php

use SM\SM;

	include_once(dirname(dirname(dirname(__FILE__))) . '/core/api.php');

	require sm_cms_rootdir().'ext/vendor/autoload.php';

	if (SM::isLoggedIn() && SM::User()->Level() != 3)
		exit('Access Denied!');

	if (System::HasSystemLogoImageURL())
		$sm['s']['current_logo'] = System::SystemLogoImageURL();
	else
		$sm['s']['current_logo'] = 'themes/'.sm_current_theme().'/images/logo.png';