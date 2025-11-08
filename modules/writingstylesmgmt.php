<?php

	use NUWM\Models\WritingStyle;
	use NUWM\Models\WritingStylesList;
	use SM\Common\Redirect;
	use SM\SM;
	use SM\UI\Buttons;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\UI;

	if (SM::isLoggedIn() && SM::User()->Level() == 3)
		{
			sm_default_action('list');

			sm_on_action('postdelete', function()
				{
					$item = new WritingStyle(SM::GET('id')->AsInt());
					if (!$item->Exists())
						exit('Access Denied 4463-TNLAS66');

					$item->Remove();

					Redirect::Now(SM::GET('returnto')->AsString());
				});


			sm_on_actionpost(['postadd', 'postedit'], function ()
				{
					if (SM::POST('title')->isEmpty())
						SM::Errors()->AddError('Title cannot be empty');
					elseif (SM::POST('description')->isEmpty())
						SM::Errors()->AddError('Description cannot be empty');

					if (SM::Errors()->Count() == 0)
						{
							if(sm_action('postadd'))
								$item = WritingStyle::Create();
							else
								$item = new WritingStyle(SM::GET('id')->AsInt());

							if($item->Exists())
								{
									$item->SetTitle(SM::POST('title')->AsString());
									$item->SetDescription(SM::POST('description')->AsString());
								}
							Redirect::Now(SM::GET('returnto')->AsString());
						}
					else
						sm_set_action(Array('postadd'=>'add', 'postedit'=>'edit'));
				});

			sm_on_action(['add', 'edit'], function ()
				{
					global $lang;

					add_path_home();
					add_path('Writing Styles', 'index.php?m='.sm_current_module().'&d=list');
					add_path_current();

					$ui = new UI();

					SM::Errors()->DisplayUIErrors($ui);

					if (sm_action('edit'))
						{
							sm_title($lang['common']['edit']);
							$f=new Form('index.php?m='.sm_current_module().'&d=postedit&id='.SM::GET('id')->AsInt().'&returnto='.urlencode(SM::GET('returnto')->AsString()));
						}
					else
						{
							sm_title($lang['common']['add']);
							$f=new Form('index.php?m='.sm_current_module().'&d=postadd&returnto='.urlencode(SM::GET('returnto')->AsString()));
						}
					$f->AddText('title', 'Title', true)
						->SetFocus();
					$f->AddTextarea('description', 'Description', true);
					if (sm_action('edit'))
						{
							$item = new WritingStyle(SM::GET('id')->AsInt());
							if($item->Exists())
								$f->LoadValuesArray($item->GetRawData());
							else
								exit('Error E-3244-3443 - Reward Item not exists');
						}
					$f->LoadValuesArray(SM::Requests()->POSTAsArray());
					$ui->AddForm($f);
					$ui->Output(true);
				});

			sm_on_action('list', function ()
				{
					global $lang;

					sm_add_body_class('buttons_above_table');
					sm_add_body_class('settings_section');
					sm_add_cssfile('settings_section.css');

					add_path_home();
					add_path_current();

					sm_title('Writing Styles');

					$offset = SM::GET('from')->AsAbsInt();
					$limit=30;

					$ui = new UI();
					$ui->AddTPL('settings_header.tpl', '', ['current_action' => 'writingstyles']);
					$ui->html('<div class="w-100">');
					$ui->html('<div class="tablewrapper">');
					$b = new Buttons();

					$b->AddButton('add', $lang['common']['add'], 'index.php?m='.sm_current_module().'&d=add&returnto='.urlencode(sm_this_url()));
					$b->AddClassname('add_asset_button', 'add');
					$ui->AddButtons($b);

					$list=new WritingStylesList();
					$list->ShowAllItemsIfNoFilters();
					$list->Limit($limit);
					$list->Offset($offset);
					$list->Load();

					$t = new Grid();
					$t->AddCol('id', 'ID', '2%');
					$t->AddCol('title', 'Title', '20%');
					$t->AddCol('description', 'Description', '80%');
					$t->AddEdit();
					$t->AddDelete();

					foreach ($list->EachItem() as $item)
						{
							$t->Label('id', $item->ID());
							$t->Label('title', $item->Title());
							$t->Label('description', $item->Description());
							$t->Url('edit', 'index.php?m='.sm_current_module().'&d=edit&id='.$item->ID().'&returnto='.urlencode(sm_this_url()));
							$t->Url('delete', 'index.php?m='.sm_current_module().'&d=postdelete&id='.$item->ID().'&returnto='.urlencode(sm_this_url()));
							$t->NewRow();
						}

					if ($t->RowCount()==0)
						$t->SingleLineLabel('No items yet...');
					$ui->AddGrid($t);
					$ui->AddPagebarParams($list->TotalCount(), $limit, $offset);
					$ui->AddButtons($b);
					$ui->html('</div>');
					$ui->html('</div>');
					$ui->Output(true);
				});
		}
	else
		Redirect::Now('index.php?m=dashboard');