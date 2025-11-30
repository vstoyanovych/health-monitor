<?php

	use NUWM\General\Navigation;
	use SM\SM;

	$navigation = new Navigation();
	$sm['mainmenu'] = $navigation->GetSidebarNavigation();
	$sm['accountmenuactions'] = $navigation->GetAccountNavigation();

	sm_add_body_class($_SESSION['nav_toggle_class']);