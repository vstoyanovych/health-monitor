<?php

	use NUWM\MainWebsite\MainWebsitePage;
	use NUWM\MainWebsite\MainWebsitePageChecker;
	use NUWM\MainWebsite\MainWebsitePagesList;

	$list = new MainWebsitePagesList();
	$list->ShowAllItemsIfNoFilters();
	$list->FilterByNeedToCheck(true);
	$list->Load();

	foreach ($list->EachItem() as $page)
		{
			MainWebsitePageChecker::CheckAndUpdate($page);
			sleep(4);
		}

	exit;

