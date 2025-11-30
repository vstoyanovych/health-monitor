<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	/*
	Module Name: SiMan CMS Demo
	Module URI: http://simancms.apserver.org.ua/modules/demo/
	Description: Examples of usage
	Version: 1.6.23
	Author URI: http://simancms.apserver.org.ua/
	*/

	use SM\SM;
	use SM\UI\Buttons;
	use SM\UI\Exchange\ExchangeListener;
	use SM\UI\Exchange\ExchangeSender;
	use SM\UI\FA;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\ModalHelper;
	use SM\UI\Navigation;
	use SM\UI\Tabs;
	use SM\UI\UI;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (!defined("demo_FUNCTIONS_DEFINED"))
		{
			define("demo_FUNCTIONS_DEFINED", 1);
		}

	if (sm_is_installed(sm_current_module()) && (SM::isLoggedIn() || intval(sm_settings('demo_public')) > 0))
		{
			sm_default_action('demos');
			if (sm_action('htmlshortcuts', 'forms', 'grid', 'regular', 'buttons', 'modal', 'exchangelistener', 'exchangesender', 'fa', 'uitabs', 'navigation', 'autocomplete'))
				sm_delayed_action('demo', 'footercode');
			if (sm_action('regular'))
				sm_delayed_action('demo', 'footercodetpl');

			//start-htmlshortcuts
			sm_on_action('htmlshortcuts', function ()
				{
					sm_title('UI HTML-shortcuts');
					add_path_home();
					add_path('Demos', 'index.php?m=demo');
					add_path_current();
					$ui = new UI();
					$ui->p('Paragraph simple');
					$ui->p_open();
					$ui->html('Paragraph open');
					$ui->br();
					$ui->html('BR tag');
					$ui->hr();
					$ui->html('HR tag');
					$ui->br();
					$ui->html('Paragraph close');
					$ui->p_close();
					$ui->div('Div with classname demo-red', '', 'demo-red');
					$ui->div('Div with style', '', '', 'background:#ccccff;');
					$ui->h(1, 'H1');
					$ui->h(2, 'H2');
					$ui->h(3, 'H3');
					$ui->h(4, 'H4');
					$ui->h(5, 'H5');
					$ui->h(6, 'H6');
					$ui->a(sm_homepage(), 'Clickable URL');
					$ui->style('.demo-red{background:#ffcccc;}');
					$ui->Output(true);
				});
			//end-htmlshortcuts

			//start-uitabs
			sm_on_action('uitabs', function ()
				{
					sm_title('UI Tabs');
					add_path_home();
					add_path('Demos', 'index.php?m=demo');
					add_path_current();
					$ui = new UI();
					$tabs=new Tabs();
					$tabs->Tab('Tab 1');
					$tabs->p('First tab');
					$tabs->Tab('Tab 2');
					$tabs->p('Second tab');
					$tabs->Tab('Tab With URL', 'index.php?m=demo');
					$ui->Add($tabs);
					$ui->Output(true);
				});
			//end-uitabs

			//start-fa
			sm_on_action('fa', function ()
				{
					sm_title('UI Font Awesome Helper');
					add_path_home();
					add_path('Demos', 'index.php?m=demo');
					add_path_current();
					$ui = new UI();
					$ui->p(FA::EmbedCodeFor('star').' - Star');
					$icon=FA::Icon('database');
					$ui->p($icon->Code());
					$icon->Size('2x');
					$ui->p($icon->Code());
					$icon->Size('3x');
					$ui->p($icon->Code());
					$icon->Size('4x');
					$ui->p($icon->Code());
					$icon->Size('5x');
					$ui->p($icon->Code());
					$ui->Output(true);
				});
			//end-fa

			//start-buttons
			sm_on_action('buttons', function ()
				{
					sm_title('UI Buttons');
					add_path_home();
					add_path('Demos', 'index.php?m=demo');
					add_path_current();
					$ui = new UI();
					$b=new Buttons();
					$b->Button('Regular Button', 'index.php?m=demo&d=buttons');
					$b->MessageBox('Confirmarion (default)', 'index.php?m=demo&d=buttons');
					$b->MessageBox('Confirmarion (custom)', 'index.php?m=demo&d=buttons', 'Are you sure you want to visit this page?');
					$b->Button('Bold', 'index.php?m=demo&d=buttons')->Bold();
					$b->Button('Custom Class', 'index.php?m=demo&d=buttons')->AddClassname('btn-danger');
					$b->AddButton('cst', 'Custom Style', 'index.php?m=demo&d=buttons');
					$b->Style('cst', 'text-decoration:underline; color:#00aa00;');
					$b->Button('Dropdown');
					$b->DropDownItem('Dropdown URL', 'http://simancms.apserver.org.ua/');
					$b->DropDownItem('Dropdown URL target=_blank', 'http://simancms.apserver.org.ua/', true);
					$b->DropDownSeparator();
					$b->DropDownOnClick('Dropdown OnClick', "alert('OnClick');");
					$b->DropDownMessageBox('Dropdown Confirmation', 'http://simancms.apserver.org.ua/');
					$ui->Add($b);
					unset($b);
					$ui->AddBlock('Highlights');
					$btnh=new Buttons();
					$btnh->Button('Success', 'index.php?m=demo&d=buttons')
						->HighlightSuccess();
					$btnh->Button('Error', 'index.php?m=demo&d=buttons')
						->HighlightError();
					$btnh->Button('Warning', 'index.php?m=demo&d=buttons')
						->HighlightWarning();
					$btnh->Button('Primary', 'index.php?m=demo&d=buttons')
						->HighlightPrimary();
					$btnh->Button('Information', 'index.php?m=demo&d=buttons')
						->HighlightInfo();
					$btnh->Button('Attention', 'index.php?m=demo&d=buttons')
						->HighlightAttention();
					$ui->Add($btnh);
					$ui->Output(true);
				});
			//end-buttons

			//start-modal
			sm_on_action('modal', function ()
				{
					sm_title('UI Modal Helper');
					add_path_home();
					add_path('Demos', 'index.php?m=demo');
					add_path_current();
					$ui = new UI();
					$b=new Buttons();
					//--------------------------------
					$modal1=new ModalHelper();
					$modal1->SetAJAXSource('index.php?m=demo&d=ajaxresponder&ajax=1');
					$b->Button('Modal with AJAX');
					$b->OnClick($modal1->GetJSCode());
					//--------------------------------
					$modal2=new ModalHelper();
					$modal2->SetContent('Hardocded HTML content, custom with and height');
					$modal2->SetWidth('200px');
					$modal2->SetHeight('10%');
					$b->Button('Modal with Hardocded Content/Dimensions');
					$b->OnClick($modal2->GetJSCode());
					//--------------------------------
					$modal3=new ModalHelper();
					$modal3->SetContentDOMSource('#hiddendiv');
					$b->Button('Modal with DOM Content and Close Helper');
					$b->OnClick($modal3->GetJSCode());
					//--------------------------------
					$ui->Add($b);
					$ui->div('Hidden DOM-element used as content for modal. Click to <a href="javascript:;" onclick="'.ModalHelper::GetCloseJSCode().'">close</a>', 'hiddendiv', '', 'display:none;');
					$ui->Output(true);
				});
			//end-modal

			//start-forms
			sm_on_action('forms', function ()
				{
					sm_title('UI Form - Form');
					add_path_home();
					add_path('Demos', 'index.php?m=demo');
					add_path_current();
					$values = Array(
						'text' => 'Text',
						'select' => 2,
						'radio' => 2,
						'checkbox1' => 1,
						'checkbox3' => '+'
					);
					$ui = new UI();
					$f = new Form('index.php?m=demo&d=forms');
					$f->AddText('text', 'Text field')->SetFocus();
					$f->AddText('calendar', 'Text field with calendar')->Calendar();
					$f->AddText('maskedinput1', 'Text field with phone mask XXX-XXX-XXXX')
						->WithMask('999-999-9999');
					$f->AddText('maskedinput2', 'Text field with date mask mm/dd/yyyy')
						->WithMask('99/99/9999', 'mm/dd/yyyy');
					$f->AddSelectVL('select', 'Select field', Array(1, 2, 3), Array('Label 1', 'Label 2', 'Label 3'));
					$f->AddRadioGroup('radio', 'Radio group field', [1, 2, 3], ['Label 1', 'Label 2', 'Label 3']);
					$f->AddTextarea('textarea', 'Textarea field');
					$f->Separator('Checkboxes');
					$f->AddCheckbox('checkbox1', 'Checkbox 1');
					$f->AddCheckbox('checkbox2', 'Checkbox 2 (label after control)');
					$f->LabelAfterControl();
					$f->AddCheckbox('checkbox3', 'Checkbox 3 (custom value)', '+');
					$f->Separator('Separator');
					$f->AddEditor('editor', 'Editor');
					$f->SetSaveButtonHelperText('Some submit button note (optional)');
					$f->SaveButton('Custom Submit Button Title');
					$f->LoadValuesArray($values);
					$f->SetValue('textarea', 'Custom value');
					$ui->Add($f);
					$ui->h(2, 'Form without action and submission');
					$f2=new Form(false);
					$f2->AddText('dummy_field', 'Some Field')->WithValue('Some value');
					$ui->Add($f2);
					$ui->Output(true);
				});
			//end-forms

			//start-autocomplete
			sm_on_action('autocomplete', function ()
				{
					sm_title('UI Form - Form (autocomplete)');
					add_path_home();
					add_path('Demos', 'index.php?m=demo');
					add_path_current();
					$ui = new UI();
					$f=new Form(false);
					$f->AddText('dummy_field', 'Type Something Here')
						->Autocomplete('index.php?m=demo&d=ajax-autocomplete-values')
						->SetFocus();
					$ui->Add($f);
					$ui->Output(true);
				});
			sm_on_action('ajax-autocomplete-values', function ()
				{
					$values=[
						'Value 1',
						'Value 2',
						'Value 3',
					];
					sm_use('autocomplete');
					sm_autocomplete_output($values);
				});
			//end-autocomplete

			sm_on_action('ajaxresponder', function ()
				{
					out(date(sm_datetime_mask(), time()).'<br />');
					for ($i = 0; $i < 5 + rand(1, 10); $i++)
						{
							out('Line '.$i.'<br />');
						}
				});

			//start-grid
			sm_on_action('grid', function ()
				{
					sm_title('UI Grid - Table');
					add_path_home();
					add_path('Demos', 'index.php?m=demo');
					add_path_current();
					$src = Array(
						Array(
							'text' => 'Sample text 0',
							'url' => ''
						)
					);
					for ($i = 1; $i < 21; $i++)
						{
							$src[] = Array(
								'text' => 'Sample text '.$i,
								'url' => 'index.php?m=demo&d=grid&testid='.$i,
								'expand' => 'Expander for row #'.$i
							);
						}
					$ui = new UI();
					$t = new Grid();
					$t->AddCol('n', '#', '5%');
					$t->AddCol('text', 'Text (header with dropdown)', '55%');
					$t->HeaderDropDownItem('text', 'Dropdown Item 1 - no url params, autoselect', sm_this_url(['dropdownparam'=>'']));
					$t->HeaderDropDownItem('text', 'Dropdown Item 2 - always selected', 'javascript:;');
					$t->HeaderDropDownItemSelect('text');
					$t->HeaderDropDownItem('text', 'Dropdown Item 3 - with url param, autoselect', sm_this_url(['dropdownparam'=>'yes']));
					$t->HeaderDropDownItemAutoSelect('text');
					$t->ColumnAddClass('text', 'at-align-center');
					$t->AddCol('note', 'Note', '40%');
					$t->AddCol('view', 'Actions', '16');
					$t->AddEdit();
					$t->AddDelete();
					$t->AddCol('chk1', '', '10');
					$t->HeaderBulkCheckbox('chk1');
					$t->AddCol('chk2', '', '10');
					$t->HeaderBulkCheckbox('chk2');
					$t->HeaderAutoColspanFor('view');
					for ($i = 0; $i < sm_count($src); $i++)
						{
							if ($i == 1)
								{
									$t->RowHighlightError();
									$t->Label('note', 'Error for row');
									$t->CellAlignCenter('note');
								}
							if ($i == 2)
								{
									$t->RowHighlightInfo();
									$t->Label('note', 'Info for row');
									$t->CellAlignCenter('note');
								}
							if ($i == 3)
								{
									$t->RowHighlightSuccess();
									$t->Label('note', 'Success for row');
									$t->CellAlignCenter('note');
								}
							if ($i == 4)
								{
									$t->RowHighlightWarning();
									$t->Label('note', 'Warning for row');
									$t->CellAlignCenter('note');
								}
							if ($i == 5)
								{
									$t->RowHighlightAttention();
									$t->Label('note', 'Attention for row');
									$t->CellAlignCenter('note');
								}
							if ($i == 10)
								{
									$t->CellHighlightError('text');
									$t->Label('note', '&lt;- Error for cell');
								}
							if ($i == 11)
								{
									$t->CellHighlightInfo('text');
									$t->Label('note', '&lt;- Info for cell');
								}
							if ($i == 12)
								{
									$t->CellHighlightSuccess('text');
									$t->Label('note', '&lt;- Success for cell');
								}
							if ($i == 13)
								{
									$t->CellHighlightWarning('text');
									$t->Label('note', '&lt;- Warning for cell');
								}
							if ($i == 14)
								{
									$t->CellHighlightAttention('text');
									$t->Label('note', '&lt;- Attention for cell');
								}
							$t->Label('n', $i);
							$t->Label('text', $src[$i]['text']);
							$t->URL('text', $src[$i]['url']);
							$t->Image('view', 'info');
							if ($i == 0)
								{
									$t->ExpandAJAX('view', 'index.php?m=demo&d=ajaxresponder&ajax=1');
									$t->Label('note', 'With AJAX expander -&gt;');
									$t->CellAlignRight('note');
									$t->CellAlignLeft('text');
								}
							elseif (!empty($src[$i]['expand']))
								{
									$t->ExpanderHTML($src[$i]['expand']);
									$t->Expand('view');
								}
							if ($i == 17)
								{
									$t->Label('note', 'Drop down menu');
									$t->DropDownItem('note', 'Item 1', 'index.php?m=demo&d=htmlshortcuts');
									$t->DropDownItem('note', 'Item 1 (confirm)', 'index.php?m=demo&d=htmlshortcuts', 'Are you sure?');
								}
							$t->Checkbox('chk1', 'chk1[]', $i, SM::GET('testid')->AsInt() === $i);
							$t->Checkbox('chk2', 'chk2[]', $i);
							$t->URL('edit', 'index.php?m=demo&d=forms');
							$t->URL('delete', 'index.php?m=demo&d=grid');
							$t->NewRow();
						}
					$t->SingleLineLabel('Single Line Notification');
					$t->NewRow();
					$ui->Add($t);
					$ui->Output(true);
				});
			//end-grid

			//start-regular
			sm_on_action('regular', function ()
				{
					//Set breadcrumbs
					add_path_home();
					add_path('Demos', 'index.php?m=demo');
					add_path_current();
					//Set title (h1+html header title)
					sm_title('Smarty Template');
					//Assign demo.tpl to display the results
					sm_template('demo');
					//Assign regular var value
					sm_set_tpl_var('test_var', 'ABCD1234');
					//Assign array value for loop
					$lines=[
						'line A',
						'line B',
						'line C',
					];
					sm_set_tpl_var('lines', $lines);
				});
			//end-regular

			//start-exchangesender
			sm_on_action('exchangesender', function ()
				{
					sm_title('Modal');
					$ui = new UI();
					$b=new Buttons();
					$b->Button('Send Values and Close');
					$sender=new ExchangeSender(SM::GET('listener')->AsString());
					$sender->Add('field1', 'Test 1');
					$sender->Add('field2', 'Test 2');
					$sender->Add('field3', 'Test 3');
					$sender->SetCloseWindowRequest();
					$b->OnClick($sender->GetJSCode());
					$ui->Add($b);
					$ui->Output(true);
				});
			//end-exchangesender

			//start-exchangelistener
			sm_on_action('exchangelistener', function ()
				{
					sm_title('UI Exchange Listener');
					$ui = new UI();
					$f = new Form(false);
					$f->AddText('field1', 'Field 1');
					$f->AddText('field2', 'Field 2');
					$f->AddText('field3', 'Field 3');
					$ui->Add($f);
					$listener=new ExchangeListener();
					$listener->Add('field1');
					$listener->Add('field2');
					$listener->Add('field3');
					$ui->javascript($listener->GetJSCode());
					unset($listener);
					$ui->AddBlock('Exchange');
					$ui->a('index.php?m=demo&d=exchangesender&listener='.sm_pageid(), 'Open Page with Sender', '', 'btn btn-default', '', '', 'target="_blank"');
					$ui->Output(true);
				});
			//end-exchangelistener

			//start-demos
			sm_on_action('demos', function ()
				{
					sm_title('Available Demos');
					add_path_home();
					add_path_current();
					$ui = new UI();
					$nav = new Navigation();
					$nav->AddItem('Smarty Template', 'index.php?m=demo&d=regular');
					$nav->AddItem('UI HTML-shortcuts', 'index.php?m=demo&d=htmlshortcuts');
					$nav->AddItem('UI Grid - Table', 'index.php?m=demo&d=grid');
					$nav->AddItem('UI Form - Form', 'index.php?m=demo&d=forms');
					$nav->AddItem('UI Form - Autocomplete', 'index.php?m=demo&d=autocomplete');
					$nav->AddItem('UI Buttons - Buttons', 'index.php?m=demo&d=buttons');
					$nav->AddItem('UI Navigation - Menus and Navigations', 'index.php?m=demo&d=navigation');
					$nav->AddItem('UI Tabs - Tabs', 'index.php?m=demo&d=uitabs');
					$nav->AddItem('UI ModalHelper - Modal Helper', 'index.php?m=demo&d=modal');
					$nav->AddItem('UI ExchangeListener/ExchangeSender - Exchange values between pages', 'index.php?m=demo&d=exchangelistener');
					$nav->AddItem('UI FA - Font Awesome Helper', 'index.php?m=demo&d=fa');
					$ui->Add($nav);
					$ui->Output(true);
				});
			//end-demos

			//start-navigation
			sm_on_action('navigation', function ()
				{
					sm_title('UI Navigation - Menus and Navigations');
					add_path_home();
					add_path('Demos', 'index.php?m=demo');
					add_path_current();
					$ui = new UI();
					$nav = new Navigation();
					$nav->AddItem('Item 1 - View demos', 'index.php?m=demo&d=regular');
					$nav->AddItem('Item 2 - Home page', sm_homepage());
					$nav->AddItem('Item 3 - Current URL (relative, autodetect active)', 'index.php?m=demo&d=navigation');
					$nav->AddItem('Item 4 - Current URL (absolute)', sm_this_url());
					$nav->AddItem('Item 5 - Custom active URL', 'index.php?m=demo&d=regular')
						->SetActive();
					$nav->AddItem('Item 6 - Custom named item', 'index.php?m=demo&d=regular', 'name1');
					$nav->AddItem('Item 7 - Custom named item, active by name', 'index.php?m=demo&d=regular', 'name2');
					$nav->AddItem('Item 8 - Another one item, in new window/tab, with FontAwesome', 'index.php?m=demo&d=regular')
						->OpenInNewWindow()
						->SetFA('external-link');
					$nav->AutoDetectActive();
					$nav->SetActive('name2');
					$ui->Add($nav);
					$ui->Output(true);
				});
			//end-navigation
			
			sm_on_action('footercode', function ()
				{
					$action=SM::GET('d')->AsString();
					$str=file_get_contents(__FILE__);
					if (sm_strpos($str, '//start-'.$action)!==false && sm_strpos($str, '//end-'.$action)!==false)
						$code=substr($str, sm_strpos($str, '//start-'.$action)+9+sm_strlen($action), sm_strpos($str, '//end-'.$action)-(sm_strpos($str, '//start-'.$action)+9+sm_strlen($action)));
					sm_title('Code Example');
					$ui = new UI();
					$ui->html('<textarea wrap="off" style="width:99%; height:150px;">'.htmlescape($code).'</textarea>');
					$ui->Output(true);
				});

			sm_on_action('footercodetpl', function ()
				{
					$action=SM::GET('d')->AsString();
					$str=file_get_contents('themes/default/demo.tpl');
					if (sm_strpos($str, '{*start-'.$action)!==false && sm_strpos($str, '{*end-'.$action)!==false)
						$code=substr($str, sm_strpos($str, '{*start-'.$action)+10+sm_strlen($action), sm_strpos($str, '{*end-'.$action)-(sm_strpos($str, '{*start-'.$action)+10+sm_strlen($action)));
					else
						$code='';
					sm_title('Smarty Template Example');
					$ui = new UI();
					$ui->html('<textarea wrap="off" style="width:99%; height:150px;">'.htmlescape($code).'</textarea>');
					$ui->Output(true);
				});

			if (SM::isAdministrator())
				{
					sm_on_action('updatesettings', function ()
						{
							sm_update_settings('demo_public', SM::GET('public')->AsInt());
							sm_redirect(SM::GET('returnto')->AsString());
						});

					sm_on_action('admin', function ()
						{
							add_path_modules();
							add_path('Demo', 'index.php?m=demo&d=admin');
							sm_title('Demo');
							$ui = new UI();
							$b = new Buttons();
							$b->Button('View Demos', 'index.php?m=demo');
							if (intval(sm_settings('demo_public')) > 0)
								$b->Button('Set Public Access OFF', 'index.php?m='.sm_current_module().'&d=updatesettings&public=0&returnto='.urlencode(sm_this_url()));
							else
								$b->Button('Set Public Access ON', 'index.php?m='.sm_current_module().'&d=updatesettings&public=1&returnto='.urlencode(sm_this_url()));
							$ui->Add($b);
							$ui->Output(true);
						});

					sm_on_action('uninstall', function ()
						{
							sm_unregister_module('demo');
							sm_delete_settings('demo_public');
							sm_redirect('index.php?m=admin&d=modules');
						});
				}

		}
	elseif (!sm_is_installed(sm_current_module()) && SM::isAdministrator())
		{
			sm_on_action('install', function ()
				{
					sm_register_module('demo', 'Demo');
					sm_add_settings('demo_public', 0);
					sm_redirect('index.php?m=admin&d=modules');
				});
		}
