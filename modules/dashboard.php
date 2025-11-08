<?php

	use NUWM\Resources\ResourcesList;
	use NUWM\Resources\ResourceStatus;
	use SM\SM;

	if (SM::isLoggedIn())
		{
			sm_default_action('view');
			sm_add_body_class('dashboard');

			if (sm_action('view'))
				{
					sm_title('Dashboard');
					sm_add_cssfile('dashboard.css');
					$m['module']='dashboard';

					$resources = new ResourcesList();
					$resources->ShowAllItemsIfNoFilters();
					$resources->Load();

					$m['resources_monitoring'] = [
						'add_url' => 'index.php?m=resources&d=add',
						'items' => [],
					];

					foreach ($resources->EachItem() as $resource)
						{
							$summary = ResourceStatus::Summary($resource, 24);
							$status_info = $summary['status'];
							$history_segments = $summary['history'];

							$added_time = $resource->AddedTime();
							$added_time_formatted = '—';
							if (!empty($added_time) && $added_time !== '0000-00-00 00:00:00')
								{
									$timestamp = strtotime($added_time);
									if ($timestamp !== false)
										$added_time_formatted = date(sm_datetime_mask(), $timestamp);
								}

							$m['resources_monitoring']['items'][] = [
								'id' => $resource->ID(),
								'service' => $resource->Service(),
								'url' => $resource->URL(),
								'department' => $resource->Department(),
								'status' => $status_info['label'],
								'status_class' => 'status-'.$status_info['status'],
								'status_last_checked' => (!empty($status_info['last_checked']) && strtotime($status_info['last_checked']) !== false) ? date(sm_datetime_mask(), strtotime($status_info['last_checked'])) : '',
								'history_segments' => $history_segments,
								'added_time' => $added_time_formatted,
							];
						}

					if (count($m['resources_monitoring']['items']) === 0)
						$m['resources_monitoring']['empty_message'] = 'No resources have been added yet.';
				}
		}
	else
		sm_redirect('index.php?m=account');
