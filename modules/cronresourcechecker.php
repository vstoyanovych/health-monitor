<?php

	use NUWM\Resources\ResourceChecker;
	use NUWM\Resources\ResourceLogsList;
	use NUWM\Resources\ResourceStatus;
	use NUWM\Resources\ResourcesList;


	$list = new ResourcesList();
	$list->ShowAllItemsIfNoFilters();
	$list->Load();

	$now = time();
	$current_hour_start = strtotime(date('Y-m-d H:00:00', $now));
	$current_hour_end = $current_hour_start + 3600 - 1;

	foreach ($list->EachItem() as $resource)
		{
			$logs = new ResourceLogsList();
			$logs->SetFilterResourceID($resource->ID());
			$logs->SetFilterForPeriod(date('Y-m-d H:i:s', $current_hour_start), date('Y-m-d H:i:s', $current_hour_end));
			$logs->Limit(1);
			$logs->ShowAllItemsIfNoFilters();
			$logs->Load();

			if ($logs->Count() > 0)
				continue;

			ResourceChecker::Check($resource, true);

			sleep(20);
		}
		
	exit;