<?php

	use NUWM\Users\User;
	use NUWM\Users\UserList;
	use SM\Common\Redirect;
	use SM\SM;
	use SM\UI\Grid;
	use SM\UI\UI;

	if (SM::User()->Level() == 3)
		{
			sm_default_action('list');

			sm_on_action('postdelete', function ()
				{
					if (SM::GET('id')->isEmpty())
						exit('Access Denied!');

					$user = new User(SM::GET('id')->AsInt());
					if (!$user->Exists() || $user->isSuperAdmin())
						exit('Access Denied!');

					$user->Remove();

					Redirect::Now(SM::GET('returnto')->AsString());
				});

			sm_on_action('list', function ()
				{
					sm_title('Users');
					add_path_home();
					add_path_current();
					sm_add_body_class('settings_section');
					sm_add_cssfile('settings_section.css');

					$offset = abs(SM::GET('from')->AsInt());
					$limit = 30;

					$list = new UserList();
					$list->ShowAllItemsIfNoFilters();
					$list->OrderByLastLoginTime(false);
					$list->Offset($offset);
					$list->Limit($limit);
					$list->Load();

					$ui = new UI();
					$ui->AddTPL('settings_header.tpl', '', ['current_action' => 'users']);
					$ui->html('<div class="w-100">');
					$t = new Grid();
					$t->AddCol('login', 'Login');
					$t->AddCol('email', 'Email');
					$t->AddCol('lasttimelogin', 'Last Login');
					$t->AddDelete();

					foreach ($list->EachItem() as $user)
						{
							$label = '';
							if ($user->isSuperAdmin())
								$label = '<span class="label label-warning sa-label">Admin</span>';
							$t->Label('login', $user->Title().' '.$label);
							$t->Label('email', $user->Email());
							$t->Label('lasttimelogin', Formatter::DateTime($user->LastLoginTimeStamp()));
							if (!$user->isSuperAdmin())
								$t->URL('delete', 'index.php?m='.sm_current_module().'&d=postdelete&id='.$user->ID().'&returnto='.urlencode(sm_this_url()));
							$t->NewRow();
						}
					$ui->AddGrid($t);
					$ui->AddPagebarParams($list->TotalCount(), $limit, $offset);
					$ui->html('</div>');
					$ui->Output(true);
				});
		}
	else
		Redirect::Now('index.php?m=dashboard');