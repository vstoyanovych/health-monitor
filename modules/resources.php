<?php

	use NUWM\Resources\Resource;
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
	elseif (sm_action('check'))
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
			$buttons->AddButton('add', 'Add Resource', 'index.php?m=resources&d=add');

			$grid = new Grid();
			$grid->AddCol('service', 'Service', '22%');
			$grid->AddCol('department', 'Department', '13%');
			$grid->AddCol('email', 'Notification Email', '18%');
			$grid->AddCol('status', 'Current Status', '10%');
			$grid->AddCol('history', 'Last 24h', '22%');
			$grid->AddCol('url', 'URL', '10%');
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

					$grid->Label('url', '<a href="'.htmlspecialchars($item->URL()).'" target="_blank" rel="noopener">'.htmlspecialchars($item->URL()).'</a>');

					$check_url = 'index.php?m=resources&d=check&id='.$item->ID();
					$grid->Label('actions', '<a href="'.$check_url.'" class="btn btn-default btn-sm">Check</a>');

					$grid->NewRow();
				}

			if ($grid->RowCount() == 0)
				$grid->SingleLineLabel('No resources have been added yet.');

			$ui->AddGrid($grid);
			$ui->AddButtons($buttons);
			$ui->Output(true);
		}

