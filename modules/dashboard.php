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

							$details_url = 'index.php?m=resources&d=details&id='.$resource->ID();
							$edit_url = 'index.php?m=resources&d=edit&id='.$resource->ID();
							$delete_url = 'index.php?m=resources&d=postdelete&id='.$resource->ID().'&returnto='.urlencode('index.php?m=resources&d=list');

							$actions_html = '<a href="'.$details_url.'" title="Details">';
							$actions_html .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="resource-action-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>';
							$actions_html .= '</a>';
							$actions_html .= '<a href="https://'.htmlspecialchars($resource->URL()).'" target="_blank" rel="noopener" title="Open URL">';
							$actions_html .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="resource-action-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>';
							$actions_html .= '</a>';

							$m['resources_monitoring']['items'][] = [
								'id' => $resource->ID(),
								'service' => $resource->Service(),
								'url' => 'https://'.$resource->URL(),
								'status' => $status_info['label'],
								'status_class' => 'status-'.$status_info['status'],
								'status_last_checked' => (!empty($status_info['last_checked']) && strtotime($status_info['last_checked']) !== false) ? date(sm_datetime_mask(), strtotime($status_info['last_checked'])) : '',
								'history_segments' => $history_segments,
								'added_time' => $added_time_formatted,
								'actions_html' => $actions_html
							];
						}

					if (count($m['resources_monitoring']['items']) === 0)
						$m['resources_monitoring']['empty_message'] = 'No resources have been added yet.';
				}
		}
	else
		sm_redirect('index.php?m=account');
