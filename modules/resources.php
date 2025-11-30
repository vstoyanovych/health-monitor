<?php

	use NUWM\Resources\Resource;
	use NUWM\Resources\ResourceLogsList;
	use NUWM\Resources\ResourcesList;
	use NUWM\Resources\ResourceChecker;
	use NUWM\Resources\ResourceStatus;
	use SM\Common\Redirect;
	use SM\SM;
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\UI;

	if (!SM::isLoggedIn())
		Redirect::Now('index.php?m=account');

	sm_default_action('list');
	sm_add_body_class('resources-module');
	sm_add_cssfile('dashboard.css');

	if (sm_action('postadd'))
		{
			if (SM::POST('service')->isEmpty())
				SM::Errors()->AddError('Service name is required.');

			if (SM::POST('url')->isEmpty())
				SM::Errors()->AddError('Service URL is required.');
			elseif (!filter_var(SM::POST('url')->AsString(), FILTER_VALIDATE_URL))
				SM::Errors()->AddError('Service URL must be a valid URL.');

			$notify_email = trim(SM::POST('notify_email')->AsString());
			if ($notify_email !== '' && !filter_var($notify_email, FILTER_VALIDATE_EMAIL))
				SM::Errors()->AddError('Notification email must be a valid email address.');

			if (SM::Errors()->Count() == 0)
				{
					$service = trim(SM::POST('service')->AsString());
					$url = trim(SM::POST('url')->AsString());
					$department = trim(SM::POST('department')->AsString());
					$notify_email = trim(SM::POST('notify_email')->AsString());
					if ($notify_email === '')
						$notify_email = null;
					$availability = SM::POST('availability')->AsInt();

					Resource::Create(
						$service,
						$url,
						$department,
						SM::User()->ID(),
						null,
						$availability,
						$notify_email
					);

					Redirect::Now('index.php?m=resources&d=list');
				}
			else
				sm_set_action('add');
		}

	if (sm_action('check'))
		{
			$id = SM::GET('id')->AsInt();
			if ($id <= 0)
				Redirect::Now('index.php?m=resources&d=list&error=Invalid+resource+ID');

			$resource = new Resource($id);
			if (!$resource->Exists())
				Redirect::Now('index.php?m=resources&d=list&error=Resource+not+found');

			$result = ResourceChecker::Check($resource, true);

			$message_params = [
				'status' => $result['status'],
				'code' => $result['http_code'],
			];
			if (!empty($result['error']))
				$message_params['error'] = $result['error'];

			
			Redirect::Now('index.php?m=resources&d=list');
		}

	if (sm_action('add'))
		{
			add_path_home();
			add_path('Resources', 'index.php?m=resources&d=list');
			add_path_current();

			sm_title('Add Resource');

			$ui = new UI();
			SM::Errors()->DisplayUIErrors($ui);

			$form = new Form('index.php?m=resources&d=postadd');
			$form->AddText('service', 'Service Name', true)->SetFocus();
			$form->AddText('url', 'Service URL', true);
			$form->AddText('department', 'Department');
			$form->AddText('notify_email', 'Notification Email');
			$form->LoadValuesArray(SM::Requests()->POSTAsArray());

			$ui->AddForm($form);
			$ui->Output(true);
			return;
		}

	if (sm_action('details'))
		{
			if (SM::GET('id')->isEmpty())
				Redirect::Now('index.php?m=resources&d=list&error=Invalid+resource+ID');

			$resource = new Resource(SM::GET('id')->AsInt());
			if (!$resource->Exists())
				Redirect::Now('index.php?m=resources&d=list&error=Resource+not+found');

			add_path_home();
			add_path('Resources', 'index.php?m=resources&d=list');
			add_path_current();

			sm_title('Resource Details: '.$resource->Service());

			// Get period from GET parameters or default to last 7 days
			$period_start = SM::GET('period_start')->AsString();
			$period_end = SM::GET('period_end')->AsString();

			if (empty($period_start))
				$period_start = date('Y-m-d', strtotime('-7 days'));
			if (empty($period_end))
				$period_end = date('Y-m-d');

			$start_timestamp = strtotime($period_start.' 00:00:00');
			$end_timestamp = strtotime($period_end.' 23:59:59');

			if ($start_timestamp === false)
				$start_timestamp = strtotime('-7 days');
			if ($end_timestamp === false)
				$end_timestamp = time();

			// Ensure start is before end
			if ($start_timestamp > $end_timestamp)
				{
					$temp = $start_timestamp;
					$start_timestamp = $end_timestamp;
					$end_timestamp = $temp;
				}

			// Calculate period length
			$days_in_period = (int) ceil(($end_timestamp - $start_timestamp) / 86400);
			$use_daily_grouping = $days_in_period > 7; // Use daily grouping for periods longer than 7 days

			// Get logs for the period
			$logs_for_period = new ResourceLogsList();
			$logs_for_period->SetFilterResourceID($resource->ID());
			$logs_for_period->SetFilterForPeriod(date('Y-m-d H:i:s', $start_timestamp), date('Y-m-d H:i:s', $end_timestamp));
			$logs_for_period->OrderByTimeChecked(true);
			$logs_for_period->ShowAllItemsIfNoFilters();
			$logs_for_period->Load();

			// Build history array for the period
			$history = [];

			if ($use_daily_grouping)
				{
					// Group by days for longer periods
					$days_buckets = [];
					$current_date = $start_timestamp;

					// Initialize day buckets
					while ($current_date <= $end_timestamp)
						{
							$day_key = date('Y-m-d', $current_date);
							$days_buckets[$day_key] = [
								'online' => 0,
								'offline' => 0,
								'unknown' => 0,
								'total' => 0
							];
							$current_date = strtotime('+1 day', $current_date);
						}

					// Fill day buckets with log data
					foreach ($logs_for_period->EachItem() as $log)
						{
							$log_timestamp = strtotime($log->TimeChecked());
							if ($log_timestamp === false)
								continue;

							if ($log_timestamp < $start_timestamp || $log_timestamp > $end_timestamp)
								continue;

							$day_key = date('Y-m-d', $log_timestamp);
							if (!isset($days_buckets[$day_key]))
								continue;

							$status = ResourceStatus::Normalize($log->Status());
							$days_buckets[$day_key]['total']++;

							if ($status === ResourceStatus::STATUS_ONLINE)
								$days_buckets[$day_key]['online']++;
							elseif ($status === ResourceStatus::STATUS_OFFLINE)
								$days_buckets[$day_key]['offline']++;
							else
								$days_buckets[$day_key]['unknown']++;
						}

					// Build history array - determine status for each day based on majority
					$current_date = $start_timestamp;
					while ($current_date <= $end_timestamp)
						{
							$day_key = date('Y-m-d', $current_date);
							if (isset($days_buckets[$day_key]) && $days_buckets[$day_key]['total'] > 0)
								{
									// Use majority status for the day
									if ($days_buckets[$day_key]['online'] >= $days_buckets[$day_key]['offline'] && $days_buckets[$day_key]['online'] >= $days_buckets[$day_key]['unknown'])
										$history[] = ResourceStatus::STATUS_ONLINE;
									elseif ($days_buckets[$day_key]['offline'] >= $days_buckets[$day_key]['unknown'])
										$history[] = ResourceStatus::STATUS_OFFLINE;
									else
										$history[] = ResourceStatus::STATUS_UNKNOWN;
								}
							else
								{
									$history[] = ResourceStatus::STATUS_UNKNOWN;
								}
							$current_date = strtotime('+1 day', $current_date);
						}
				}
			else
				{
					// Group by hours for shorter periods (7 days or less)
					$hours_in_period = (int) ceil(($end_timestamp - $start_timestamp) / 3600);
					$hours_in_period = max(1, min($hours_in_period, 168)); // Limit to 7 days max
					$buckets = [];

					// Initialize buckets
					for ($i = 0; $i < $hours_in_period; $i++)
						{
							$buckets[$i] = null;
						}

					// Fill buckets with log data
					foreach ($logs_for_period->EachItem() as $log)
						{
							$log_timestamp = strtotime($log->TimeChecked());
							if ($log_timestamp === false)
								continue;

							if ($log_timestamp < $start_timestamp || $log_timestamp > $end_timestamp)
								continue;

							$index = (int) floor(($log_timestamp - $start_timestamp) / 3600);
							if ($index < 0 || $index >= $hours_in_period)
								continue;

							$buckets[$index] = ResourceStatus::Normalize($log->Status());
						}

					// Build history array
					for ($i = 0; $i < $hours_in_period; $i++)
						{
							if ($buckets[$i] !== null)
								$history[$i] = $buckets[$i];
							else
								$history[$i] = ResourceStatus::STATUS_UNKNOWN;
						}
				}

			$summary = ResourceStatus::Summary($resource, 24); // Current status uses last 24h
			$status = $summary['status'];

			// Get recent logs for the selected period
			$logs = new ResourceLogsList();
			$logs->SetFilterResourceID($resource->ID());
			$logs->SetFilterForPeriod(date('Y-m-d H:i:s', $start_timestamp), date('Y-m-d H:i:s', $end_timestamp));
			$logs->OrderByTimeChecked(false);
			$logs->Limit(100);
			$logs->ShowAllItemsIfNoFilters();
			$logs->Load();

			// Prepare response time data for chart
			// Group by hours if period is 1 day or less, otherwise group by days
			$response_time_data = [];
			$response_time_labels = [];
			$days_in_period = (int) ceil(($end_timestamp - $start_timestamp) / 86400);
			$group_by_hours = $days_in_period <= 1;

			if ($group_by_hours)
				{
					// Group by hours for single day periods
					$hours_data = [];

					// Initialize hour buckets
					$current_hour = $start_timestamp;
					while ($current_hour <= $end_timestamp)
						{
							$hour_key = date('Y-m-d H:00:00', $current_hour);
							$hours_data[$hour_key] = [];
							$current_hour = strtotime('+1 hour', $current_hour);
						}

					// Collect response times by hour
					foreach ($logs_for_period->EachItem() as $log)
						{
							$log_time = strtotime($log->TimeChecked());
							if ($log_time === false)
								continue;

							$hour_key = date('Y-m-d H:00:00', $log_time);
							$total_time = $log->TotalTime();

							if ($total_time !== null && isset($hours_data[$hour_key]))
								$hours_data[$hour_key][] = $total_time * 1000; // Convert to milliseconds
						}

					// Generate labels and data for each hour
					$current_hour = $start_timestamp;
					while ($current_hour <= $end_timestamp)
						{
							$hour_key = date('Y-m-d H:00:00', $current_hour);
							$response_time_labels[] = date('H:i', $current_hour);

							if (isset($hours_data[$hour_key]) && count($hours_data[$hour_key]) > 0)
								$response_time_data[] = round(array_sum($hours_data[$hour_key]) / count($hours_data[$hour_key]), 2);
							else
								$response_time_data[] = null;

							$current_hour = strtotime('+1 hour', $current_hour);
						}
				}
			else
				{
					// Group by days for longer periods
					$days_data = [];

					// First, collect all response times grouped by day
					foreach ($logs_for_period->EachItem() as $log)
						{
							$log_time = strtotime($log->TimeChecked());
							if ($log_time === false)
								continue;

							$day_key = date('Y-m-d', $log_time);
							$total_time = $log->TotalTime();

							if ($total_time !== null)
								{
									if (!isset($days_data[$day_key]))
										$days_data[$day_key] = [];
									$days_data[$day_key][] = $total_time * 1000; // Convert to milliseconds
								}
						}

					// Generate labels and data for each day in the period
					$current_date = $start_timestamp;
					while ($current_date <= $end_timestamp)
						{
							$day_key = date('Y-m-d', $current_date);
							$response_time_labels[] = date('M d', $current_date);

							if (isset($days_data[$day_key]) && count($days_data[$day_key]) > 0)
								$response_time_data[] = round(array_sum($days_data[$day_key]) / count($days_data[$day_key]), 2);
							else
								$response_time_data[] = null;

							$current_date = strtotime('+1 day', $current_date);
						}
				}

			// Calculate availability stats
			$total_checks = count($history);
			$online_count = 0;
			$offline_count = 0;
			foreach ($history as $segment_status)
				{
					if ($segment_status === ResourceStatus::STATUS_ONLINE)
						$online_count++;
					elseif ($segment_status === ResourceStatus::STATUS_OFFLINE)
						$offline_count++;
				}
			$availability_percent = $total_checks > 0 ? round(($online_count / $total_checks) * 100, 2) : 0;

			$ui = new UI();

			// Prepare data for templates
			$added_time = $resource->AddedTime();
			$added_time_formatted = '—';
			if (!empty($added_time) && $added_time !== '0000-00-00 00:00:00')
				{
					$timestamp = strtotime($added_time);
					if ($timestamp !== false)
						$added_time_formatted = date(sm_datetime_mask(), $timestamp);
				}
			$last_checked = !empty($status['last_checked']) ? date(sm_datetime_mask(), strtotime($status['last_checked'])) : 'Never';
			$period_label = date('M d, Y', $start_timestamp).' - '.date('M d, Y', $end_timestamp);

			// Resource info template (includes availability graph)
			$ui->AddTPL('resource_details_info.tpl', '', [
				'service' => $resource->Service(),
				'url' => $resource->URL(),
				'email' => $resource->NotificationEmail(),
				'added_time' => $added_time_formatted,
				'last_checked' => $last_checked,
				'status' => $status,
				'availability_percent' => $availability_percent,
				'online_count' => $online_count,
				'total_checks' => $total_checks,
				'history' => $history,
				'period_label' => $period_label,
				'start_date' => date('M d', $start_timestamp),
				'end_date' => date('M d', $end_timestamp),
			]);

			// Period filter template
			$ui->AddTPL('resource_details_filter.tpl', '', [
				'resource_id' => $resource->ID(),
				'period_start' => $period_start,
				'period_end' => $period_end,
			]);

			// Response time chart template - prepare JSON data
			$chart_data = [
				'labels' => $response_time_labels,
				'data' => $response_time_data,
			];
			$chart_data_json = json_encode($chart_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			$time_label = $group_by_hours ? 'Hour' : 'Day';

			$ui->AddTPL('resource_details_chart.tpl', '', [
				'resource_id' => $resource->ID(),
				'period_label' => $period_label,
				'chart_data_json' => $chart_data_json,
			]);

			// Chart script template
			$ui->AddTPL('resource_details_chart_script.tpl', '', [
				'resource_id' => $resource->ID(),
				'time_label' => $time_label,
			]);

			// Recent checks table template
			$logs_data = [];
			foreach ($logs->EachItem() as $log)
				{
					$log_time = $log->TimeChecked();
					$log_time_formatted = !empty($log_time) ? date(sm_datetime_mask(), strtotime($log_time)) : '—';
					$log_status = ResourceStatus::Normalize($log->Status());
					$log_status_label = ResourceStatus::Label($log_status);
					$total_time = $log->TotalTime();
					$response_time = $total_time !== null ? number_format($total_time * 1000, 0).' ms' : '—';
					$ip = $log->IP();
					$error = $log->Error();

					$logs_data[] = [
						'time' => $log_time_formatted,
						'status' => $log_status,
						'status_label' => $log_status_label,
						'response_time' => $response_time,
						'ip' => !empty($ip) ? $ip : '—',
						'error' => !empty($error) ? $error : '',
					];
				}

			$ui->AddTPL('resource_details_table.tpl', '', [
				'logs' => $logs_data,
			]);
			$ui->Output(true);
			return;
		}

	if (sm_action('postdelete'))
		{
			if (SM::GET('id')->isEmpty())
				exit('Access Denied!');

			$resource = new Resource(SM::GET('id')->AsInt());
			if (!$resource->Exists())
				exit('Access Denied!');

			$resource->Remove();

			$returnto = SM::GET('returnto')->AsString();
			if (!empty($returnto))
				Redirect::Now($returnto);
			else
				Redirect::Now('index.php?m=resources&d=list');
		}

	if (sm_action('list'))
		{
			add_path_home();
			add_path_current();

			sm_title('Resources');
			sm_add_body_class('buttons_above_table');

			$list = new ResourcesList();
			$list->ShowAllItemsIfNoFilters();
			$list->Load();

			$ui = new UI();

			$buttons = new Buttons();
			$buttons->AddButton('add', '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 3.33325V12.6666" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M3.33398 8H12.6673" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Add Resource', 'index.php?m=resources&d=add');
			$buttons->AddClassname('dashboard-add-resource-btn', 'add');
			$ui->AddButtons($buttons);

			$grid = new Grid();
			$grid->AddCol('service', 'Service', '22%');
			$grid->AddCol('department', 'Department', '13%');
			$grid->AddCol('email', 'Notification Email', '18%');
			$grid->AddCol('status', 'Current Status', '10%');
			$grid->AddCol('history', 'Last 24h', '22%');
			$grid->AddCol('actions', '', '6%');

			foreach ($list->EachItem() as $item)
				{
					$grid->Label('service', $item->Service());
					$grid->Label('department', $item->Department() ?: '—');

					$email = $item->NotificationEmail();
					if (!empty($email))
						$grid->Label('email', '<a href="mailto:'.htmlspecialchars($email).'">'.htmlspecialchars($email).'</a>');
					else
						$grid->Label('email', '—');

					$summary = ResourceStatus::Summary($item);

					$status = $summary['status'];
					$status_html = '<span class="resource-status-pill status-'.$status['status'].'">'.$status['label'].'</span>';
					$grid->Label('status', $status_html);

					if (!empty($status['last_checked']) && strtotime($status['last_checked']) !== false)
						$grid->Hint('status', 'Last checked: '.date(sm_datetime_mask(), strtotime($status['last_checked'])));

					$history_segments = $summary['history'];
					$history_html = '<div class="resource-availability-bar">';
					foreach ($history_segments as $segment_status)
						{
							$history_html .= '<span class="resource-availability-segment status-'.$segment_status.'"></span>';
						}
					$history_html .= '</div>';

					$grid->Label('history', $history_html);

					$details_url = 'index.php?m=resources&d=details&id='.$item->ID();
					$edit_url = 'index.php?m=resources&d=edit&id='.$item->ID();
					$delete_url = 'index.php?m=resources&d=postdelete&id='.$item->ID().'&returnto='.urlencode('index.php?m=resources&d=list');
					$actions_html = '<div class="resource-actions">';
					$actions_html .= '<a href="'.$details_url.'" title="Details">';
					$actions_html .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="resource-action-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>';
					$actions_html .= '</a>';
					$actions_html .= '<a href="https://'.htmlspecialchars($item->URL()).'" target="_blank" rel="noopener" title="Open URL">';
					$actions_html .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="resource-action-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>';
					$actions_html .= '</a>';
					$actions_html .= '<a href="'.$edit_url.'" title="Edit">';
					$actions_html .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="resource-action-icon"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>';
					$actions_html .= '</a>';
					$actions_html .= '<a href="'.$delete_url.'" title="Delete" onclick="return confirm(\'Are you sure you want to delete this resource?\')">';
					$actions_html .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="resource-action-icon resource-action-icon-delete"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>';
					$actions_html .= '</a>';
					$actions_html .= '</div>';
					$grid->Label('actions', $actions_html);

					$grid->NewRow();
				}

			if ($grid->RowCount() == 0)
				$grid->SingleLineLabel('No resources have been added yet.');

			$ui->AddGrid($grid);
			$ui->Output(true);
		}

