<?php

	use NUWM\MainWebsite\MainWebsitePage;
	use NUWM\MainWebsite\MainWebsitePageChecker;
	use NUWM\MainWebsite\MainWebsitePagesList;
	use SM\Common\Redirect;
	use SM\SM;
	use SM\UI\Grid;
	use SM\UI\UI;

	if (!SM::isLoggedIn())
		Redirect::Now('index.php?m=account');

	sm_default_action('list');
	sm_add_body_class('nuwmhealth-module');

	$ready_filter = SM::GET('ready')->AsString();
	if (!in_array($ready_filter, ['ready', 'missing'], true))
		$ready_filter = 'all';

	$admin_filter = SM::GET('has_admin')->AsString();
	if (!in_array($admin_filter, ['assigned', 'unassigned'], true))
		$admin_filter = 'all';

	$ready_sort = SM::GET('ready_sort')->AsString();
	if (!in_array($ready_sort, ['asc', 'desc'], true))
		$ready_sort = 'id';

	$group_by = SM::GET('group_by')->AsString();
	if (!in_array($group_by, ['admin'], true))
		$group_by = 'none';

	$report_sort = SM::GET('report_sort')->AsString();
	if (!in_array($report_sort, ['asc', 'desc'], true))
		$report_sort = 'desc';

	$admin_email_filter = trim(SM::GET('admin_email')->AsString());
	if ($admin_email_filter === '')
		$admin_email_filter = null;

	if (!function_exists('nuwmhealth_build_list'))
		{
			function nuwmhealth_build_list(string $ready_filter, string $admin_filter, string $ready_sort, string $group_by, ?string $admin_email_filter): MainWebsitePagesList
				{
					$list = new MainWebsitePagesList();
					$list->ShowAllItemsIfNoFilters();

					if ($ready_filter === 'ready')
						$list->FilterByReadyState(true);
					elseif ($ready_filter === 'missing')
						$list->FilterByReadyState(false);

					if ($admin_filter === 'assigned')
						$list->FilterByAdminPresence(true);
					elseif ($admin_filter === 'unassigned')
						$list->FilterByAdminPresence(false);

					if ($group_by === 'admin')
						$list->OrderByAdmin(true);
					elseif ($ready_sort === 'asc' || $ready_sort === 'desc')
						$list->OrderByReady($ready_sort === 'asc');

					if ($admin_email_filter !== null)
						$list->FilterByAdminEmail($admin_email_filter);

					return $list;
				}
		}

	if (!function_exists('nuwmhealth_prepare_admin_report'))
		{
			function nuwmhealth_prepare_admin_report(MainWebsitePagesList $list, string $sort_direction = 'desc'): array
				{
					$sort_direction = strtolower($sort_direction) === 'asc' ? 'asc' : 'desc';
					$summary = [];
					$overall_total = 0;
					$overall_ready = 0;

					foreach ($list->EachItem() as $item)
						{
							$overall_total++;
							if ($item->Ready())
								$overall_ready++;

							$admin_value = trim((string)$item->Admin());
							$key = $admin_value === '' ? '__unassigned__' : strtolower($admin_value);

							if (!isset($summary[$key]))
								{
									$summary[$key] = [
										'admin_label' => $admin_value === '' ? 'No admin assigned' : $admin_value,
										'admin_email' => $admin_value,
										'total' => 0,
										'ready' => 0,
										'missing' => 0,
									];
								}

							$summary[$key]['total']++;
							if ($item->Ready())
								$summary[$key]['ready']++;
							else
								$summary[$key]['missing']++;
						}

					foreach ($summary as &$entry)
						{
							$entry['ready_percent'] = $entry['total'] > 0 ? round(($entry['ready'] / $entry['total']) * 100, 1) : 0;
						}
					unset($entry);

					uasort($summary, function ($a, $b) use ($sort_direction)
						{
							$cmp = $sort_direction === 'desc'
								? ($b['ready_percent'] <=> $a['ready_percent'])
								: ($a['ready_percent'] <=> $b['ready_percent']);
							if ($cmp !== 0)
								return $cmp;

							$cmp = $sort_direction === 'desc'
								? ($b['total'] <=> $a['total'])
								: ($a['total'] <=> $b['total']);
							if ($cmp !== 0)
								return $cmp;

							return strcasecmp($a['admin_label'], $b['admin_label']);
						});

					$entries = [];
					foreach ($summary as $entry)
						{
							$entries[] = $entry;
						}

					$overall_missing = $overall_total - $overall_ready;

					return [
						'entries' => $entries,
						'overall' => [
							'total' => $overall_total,
							'ready' => $overall_ready,
							'missing' => $overall_missing,
							'ready_percent' => $overall_total > 0 ? round(($overall_ready / $overall_total) * 100, 1) : 0,
						],
					];
				}
		}

	if (sm_action('report_export'))
		{
			$report_list = nuwmhealth_build_list($ready_filter, $admin_filter, $ready_sort, 'admin', $admin_email_filter);
			$report_list->Load();
			$admin_report = nuwmhealth_prepare_admin_report($report_list, $report_sort);

			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename="nuwmhealth_admin_report_'.date('Ymd_His').'.csv"');

			$output = fopen('php://output', 'w');
			fputcsv($output, ['Admin', 'Total', 'Ready', 'Missing', 'Ready %']);

			foreach ($admin_report['entries'] as $row)
				{
					fputcsv($output, [
						$row['admin_label'],
						$row['total'],
						$row['ready'],
						$row['missing'],
						$row['ready_percent'],
					]);
				}

			fputcsv($output, []);
			fputcsv($output, [
				'Overall',
				$admin_report['overall']['total'],
				$admin_report['overall']['ready'],
				$admin_report['overall']['missing'],
				$admin_report['overall']['ready_percent'],
			]);

			fclose($output);
			exit;
		}
	elseif (sm_action('export'))
		{
			$list = nuwmhealth_build_list($ready_filter, $admin_filter, $ready_sort, $group_by, $admin_email_filter);
			$list->Load();

			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename="nuwmhealth_pages_'.date('Ymd_His').'.csv"');

			$output = fopen('php://output', 'w');
			if ($group_by === 'admin')
				{
					$groups = [];
					foreach ($list->EachItem() as $item)
						{
							$admin_value = trim((string)$item->Admin());
							$key = $admin_value === '' ? '__unassigned__' : $admin_value;

							if (!isset($groups[$key]))
								{
									$groups[$key] = [
										'admin_label' => $admin_value === '' ? 'No admin assigned' : $admin_value,
										'items' => [],
									];
								}

							$groups[$key]['items'][] = [
								'title' => $item->Title(),
								'url' => $item->URL(),
								'ready' => $item->Ready() ? 'Ready' : 'Missing',
							];
						}

					foreach ($groups as $group)
						{
							fputcsv($output, [$group['admin_label'], '', '']);
							foreach ($group['items'] as $page)
								{
									fputcsv($output, [
										'',
										$page['title'],
										$page['url'],
										$page['ready'],
									]);
								}
						}
				}
			else
				{
					fputcsv($output, ['ID', 'Title', 'URL', 'Ready', 'Admin']);

					foreach ($list->EachItem() as $item)
						{
							fputcsv($output, [
								$item->ID(),
								$item->Title(),
								$item->URL(),
								$item->Ready() ? 'Ready' : 'Missing',
								$item->Admin(),
							]);
						}
				}

			fclose($output);
			exit;
		}

	if (sm_action('report'))
		{
			add_path_home();
			add_path('NUWM Health', 'index.php?m=nuwmhealth');
			add_path_current();

			sm_title('Admin Report');
			sm_add_body_class('buttons_above_table');

			$report_list = nuwmhealth_build_list($ready_filter, $admin_filter, $ready_sort, 'admin', $admin_email_filter);
			$report_list->ShowAllItemsIfNoFilters();
			$report_list->Load();

			$admin_report = nuwmhealth_prepare_admin_report($report_list, $report_sort);
			$list_base_params = [
				'm' => 'nuwmhealth',
				'd' => 'list',
				'has_admin' => $admin_filter,
				'ready_sort' => $ready_sort,
				'group_by' => $group_by,
				'report_sort' => $report_sort,
			];
			foreach ($admin_report['entries'] as &$entry)
				{
					$admin_email = $entry['admin_email'];
					$base_params = $list_base_params;

					if ($admin_email !== '')
						$base_params['admin_email'] = $admin_email;
					else
						$base_params['has_admin'] = 'unassigned';

					$base_params['ready'] = 'all';
					$entry['url_total'] = 'index.php?'.http_build_query($base_params);

					$base_params['ready'] = 'ready';
					$entry['url_ready'] = 'index.php?'.http_build_query($base_params);

					$base_params['ready'] = 'missing';
					$entry['url_missing'] = 'index.php?'.http_build_query($base_params);
				}
			unset($entry);

			$ui = new UI();
			$last_status = trim(SM::GET('checkstatus')->AsString());
			$last_error = trim(SM::GET('checkerror')->AsString());
			$deleted_title = trim(SM::GET('deletedtitle')->AsString());
			if ($last_status !== '')
				{
					if ($last_error !== '')
						$ui->NotificationError('Last check: '.$last_status.' ('.$last_error.')');
					else
						$ui->NotificationSuccess('Last check: '.$last_status);
				}
			if ($deleted_title !== '')
				$ui->NotificationSuccess('Deleted page "'.htmlspecialchars($deleted_title).'"');
			$export_url = 'index.php?'.http_build_query([
				'm' => 'nuwmhealth',
				'd' => 'report_export',
				'ready' => $ready_filter,
				'has_admin' => $admin_filter,
				'ready_sort' => $ready_sort,
				'group_by' => $group_by,
				'report_sort' => $report_sort,
				'admin_email' => $admin_email_filter,
			]);
			$ui->AddTPL('nuwmhealth_report_controls.tpl', '', [
				'ready_filter' => $ready_filter,
				'admin_filter' => $admin_filter,
				'ready_sort' => $ready_sort,
				'group_by' => $group_by,
				'report_sort' => $report_sort,
				'export_url' => $export_url,
				'admin_email' => $admin_email_filter,
			]);
			$ui->AddTPL('nuwmhealth_adminreport.tpl', '', [
				'report' => $admin_report['entries'],
				'overall' => $admin_report['overall'],
			]);
			$ui->Output(true);
			return;
		}
	elseif (sm_action('check'))
		{
			$page_id = SM::GET('id')->AsInt();
			$return_to = SM::GET('returnto')->AsString();
			if ($page_id <= 0)
				Redirect::Now($return_to ?: 'index.php?m=nuwmhealth&d=list');

			$page = new MainWebsitePage($page_id);
			if (!$page->Exists())
				Redirect::Now($return_to ?: 'index.php?m=nuwmhealth&d=list');

			$result = MainWebsitePageChecker::CheckAndUpdate($page);

			$params = [
				'm' => 'nuwmhealth',
				'd' => 'list',
				'ready' => $ready_filter,
				'has_admin' => $admin_filter,
				'ready_sort' => $ready_sort,
				'group_by' => $group_by,
				'report_sort' => $report_sort,
				'admin_email' => $admin_email_filter,
			];
			$url = $return_to ?: 'index.php?'.http_build_query($params);

			$params = [
				'checkstatus' => $result['status'],
			];
			if (!empty($result['error']))
				$params['checkerror'] = $result['error'];

			$url = sm_url($url, $params);

			Redirect::Now($url);
		}
	elseif (sm_action('delete'))
		{
			$page_id = SM::GET('id')->AsInt();
			$return_to = SM::GET('returnto')->AsString();
			if ($page_id <= 0)
				Redirect::Now($return_to ?: 'index.php?m=nuwmhealth&d=list');

			$page = new MainWebsitePage($page_id);
			if (!$page->Exists())
				Redirect::Now($return_to ?: 'index.php?m=nuwmhealth&d=list');

			$title = $page->Title();
			$page->Remove();

			$params = [
				'm' => 'nuwmhealth',
				'd' => 'list',
				'ready' => $ready_filter,
				'has_admin' => $admin_filter,
				'ready_sort' => $ready_sort,
				'group_by' => $group_by,
				'report_sort' => $report_sort,
				'admin_email' => $admin_email_filter,
			];
			$url = $return_to ?: 'index.php?'.http_build_query($params);
			$url = sm_url($url, ['deletedtitle' => $title]);

			Redirect::Now($url);
		}
	elseif (sm_action('list'))
		{
			add_path_home();
			add_path_current();

			sm_title('NUWM Health');
			sm_add_body_class('buttons_above_table');

			$offset = abs(SM::GET('from')->AsInt());
			$limit = 50;

			$list = nuwmhealth_build_list($ready_filter, $admin_filter, $ready_sort, $group_by, $admin_email_filter);
			$list->Offset($offset);
			$list->Limit($limit);
			$list->Load();

			$total_list = new MainWebsitePagesList();
			$total_list->ShowAllItemsIfNoFilters();
			$total_pages = $total_list->TotalCount();

			$ready_list = new MainWebsitePagesList();
			$ready_list->ShowAllItemsIfNoFilters();
			$ready_list->FilterByReadyState(true);
			$ready_pages = $ready_list->TotalCount();

			$not_ready_list = new MainWebsitePagesList();
			$not_ready_list->ShowAllItemsIfNoFilters();
			$not_ready_list->FilterByReadyState(false);
			$not_ready_pages = $not_ready_list->TotalCount();
			$ready_percent = $total_pages > 0 ? round(($ready_pages / $total_pages) * 100, 1) : 0;

			$report_list = nuwmhealth_build_list($ready_filter, $admin_filter, $ready_sort, 'admin', $admin_email_filter);
			$report_list->Load();

			$ui = new UI();
			$ui->AddTPL('nuwmhealth_stats.tpl', '', [
				'total_pages' => $total_pages,
				'ready_pages' => $ready_pages,
				'not_ready_pages' => $not_ready_pages,
				'ready_percent' => $ready_percent,
			]);

			$report_link = 'index.php?'.http_build_query([
					'm' => 'nuwmhealth',
					'd' => 'report',
					'ready' => $ready_filter,
					'has_admin' => $admin_filter,
					'ready_sort' => $ready_sort,
					'group_by' => $group_by,
					'report_sort' => $report_sort,
					'admin_email' => $admin_email_filter,
				]);

			$ui->AddTPL('nuwmhealth_filters.tpl', '', [
				'ready_filter' => $ready_filter,
				'admin_filter' => $admin_filter,
				'ready_sort' => $ready_sort,
				'group_by' => $group_by,
				'report_sort' => $report_sort,
				'action' => 'list',
				'export_action' => 'export',
				'report_link' => $report_link,
				'admin_email' => $admin_email_filter,
			]);

			if ($group_by === 'admin')
				{
					$groups = [];
					foreach ($list->EachItem() as $item)
						{
							$admin_value = trim((string)$item->Admin());
							$key = $admin_value === '' ? '__unassigned__' : $admin_value;

							if (!isset($groups[$key]))
								{
									$groups[$key] = [
										'admin_label' => $admin_value === '' ? 'No admin assigned' : $admin_value,
										'admin_email' => $admin_value,
										'admin_url' => 'mailto:'.$admin_value,
										'items' => [],
									];
								}

							$groups[$key]['items'][] = [
								'title' => $item->Title(),
								'url' => $item->URL(),
								'ready' => $item->Ready(),
								'id' => $item->ID(),
							];
						}

					$ui->AddTPL('nuwmhealth_groups.tpl', '', [
						'groups' => array_values($groups),
					]);
				}
			else
				{
					$grid = new Grid();
					$grid->AddCol('title', 'Title', '35%');
					$grid->AddCol('url', 'URL', '35%');
					$grid->AddCol('admin', 'Admin', '20%');
					$grid->AddCol('ready', 'Ready', '8%');
					$grid->AddCol('actions', '', '12%');

					foreach ($list->EachItem() as $item)
						{
							$grid->Label('title', htmlspecialchars($item->Title()));

							$url = $item->URL();
							if (!empty($url))
								$grid->Label('url', '<a href="'.htmlspecialchars($url).'" target="_blank" rel="noopener">'.htmlspecialchars($url).'</a>');
							else
								$grid->Label('url', '—');

							$admin = $item->Admin();
							if (!empty($admin))
								$grid->Label('admin', '<a href="mailto:'.htmlspecialchars($admin).'">'.htmlspecialchars($admin).'</a>');
							else
								$grid->Label('admin', '—');

							$is_ready = $item->Ready();
							$status_class = $is_ready ? 'status-ready' : 'status-not-ready';
							$status_label = $is_ready ? 'Ready' : 'Missing';
							$grid->Label('ready', '<span class="nuwmhealth-status-pill '.$status_class.'">'.$status_label.'</span>');

							$current_url = sm_this_url();
							$check_url = 'index.php?'.http_build_query([
								'm' => 'nuwmhealth',
								'd' => 'check',
								'id' => $item->ID(),
								'returnto' => $current_url,
							]);
							$delete_url = 'index.php?'.http_build_query([
								'm' => 'nuwmhealth',
								'd' => 'delete',
								'id' => $item->ID(),
								'returnto' => $current_url,
							]);
							$actions_html = '<a class="btn btn-default btn-sm" href="'.$check_url.'">Check</a> ';
							$actions_html .= '<a class="btn btn-danger btn-sm" href="'.$delete_url.'" onclick="return confirm(\'Delete this page?\');">Delete</a>';
							$grid->Label('actions', $actions_html);

							$grid->NewRow();
						}

					if ($grid->RowCount() == 0)
						$grid->SingleLineLabel('No pages have been imported yet.');

					$ui->AddGrid($grid);
				}
			$ui->AddPagebarParams($list->TotalCount(), $limit, $offset);
			$ui->Output(true);
		}


