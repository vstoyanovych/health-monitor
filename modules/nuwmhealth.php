<?php

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

	if (!function_exists('nuwmhealth_build_list'))
		{
			function nuwmhealth_build_list(string $ready_filter, string $admin_filter, string $ready_sort, string $group_by): MainWebsitePagesList
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

					return $list;
				}
		}

	if (sm_action('export'))
		{
			$list = nuwmhealth_build_list($ready_filter, $admin_filter, $ready_sort, $group_by);
			$list->Load();

			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename="nuwmhealth_pages_'.date('Ymd_His').'.csv"');

			$output = fopen('php://output', 'w');
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

			fclose($output);
			exit;
		}

	if (sm_action('list'))
		{
			add_path_home();
			add_path_current();

			sm_title('NUWM Health');
			sm_add_body_class('buttons_above_table');

			$offset = abs(SM::GET('from')->AsInt());
			$limit = 50;

			$list = nuwmhealth_build_list($ready_filter, $admin_filter, $ready_sort, $group_by);
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

			$ui = new UI();
			$ui->AddTPL('nuwmhealth_stats.tpl', '', [
				'total_pages' => $total_pages,
				'ready_pages' => $ready_pages,
				'not_ready_pages' => $not_ready_pages,
				'ready_percent' => $ready_percent,
			]);
			$ui->AddTPL('nuwmhealth_filters.tpl', '', [
				'ready_filter' => $ready_filter,
				'admin_filter' => $admin_filter,
				'ready_sort' => $ready_sort,
				'group_by' => $group_by,
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
										'items' => [],
									];
								}

							$groups[$key]['items'][] = [
								'title' => $item->Title(),
								'url' => $item->URL(),
								'ready' => $item->Ready(),
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
					$grid->AddCol('ready', 'Ready', '10%');

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

							$grid->NewRow();
						}

					if ($grid->RowCount() == 0)
						$grid->SingleLineLabel('No pages have been imported yet.');

					$ui->AddGrid($grid);
				}
			$ui->AddPagebarParams($list->TotalCount(), $limit, $offset);
			$ui->Output(true);
		}


