<?php

	/*
	Module Name: Code Generator
	Module URI: http://simancms.apserver.org.ua/
	Description: Code generator for UI
	Version: 1.6.23
	Revision: 2023-08-27
	Author URI: http://simancms.apserver.org.ua/
	*/

	use SM\Common\Redirect;
	use SM\SM;
	use SM\UI\Form;
	use SM\UI\UI;

	sm_default_action('prepare');

	if (sm_is_installed(sm_current_module()))
		{
			function parse_mysql_create($sql)
				{
					preg_match_all('/`(.+)` (\w+)\(? ?(\d*) ?\)?/', $sql, $fields, PREG_SET_ORDER);
					$result['fields'] = $fields;
					if (preg_match('/CREATE\s+(?:TEMPORARY\s+)?TABLE\s+(?:IF NOT EXISTS\s+)?([^\s]+)/i', $sql, $matches))
						{
							$tableName = $matches[1];
						}
					$result['table'] = str_replace('`', '', $tableName);
					if (sm_strcmp(substr($result['table'], 0, sm_strlen(sm_table_prefix())), sm_table_prefix()) == 0)
						{
							$result['tableprefix'] = 'sm_table_prefix().';
							$result['table'] = substr($result['table'], sm_strlen(sm_table_prefix()));
						}
					else
						{
							$result['tableprefix'] = '';
						}
					if (preg_match('#.*PRIMARY\s+KEY\s+\(`(.*?)`\).*#i', $sql, $matches))
						{
							$result['id'] = $matches[1];
						}
					return $result;
				}

			function get_postdelete_code($data)
				{
					$info = parse_mysql_create($data['sql']);
					$str = "
			sm_on_action('postdelete', function ()
				{
					\$q=new TQuery(".$info['tableprefix']."'".$info['table']."');
					\$q->AddWhere('".$info['id']."', SM::GET('id')->AsInt());
					\$q->Remove();
					sm_saferemove('index.php?m='.sm_current_module().'&d=view&id='.SM::GET('id')->AsInt());
					Redirect::Now(SM::GET('returnto')->AsString());
				});
			";
					return $str;
				}

			function get_postadd_code($data)
				{
					$info = parse_mysql_create($data['sql']);
					$req = '';
					for ($i = 0; $i < sm_count($data['fields']); $i++)
						{
							if ($data['fields'][$i]['required'])
								{
									if (!empty($req))
										$req .= ' || ';
									$req .= "SM::POST('".$data['fields'][$i]['name']."')->isEmpty()";
								}
						}
					$str = "
			sm_on_action(['postadd', 'postedit'], function ()
				{\n";
					if (!empty($req))
						$str .= "\t\t\t\t\tif (".$req.")
						SM::Errors()->AddError(sm_lang('messages.fill_required_fields'));\n";
					$str .= "\t\t\t\t\tif (SM::Errors()->Count()===0)
						{
							\$q=new TQuery(".$info['tableprefix']."'".$info['table']."');\n";
					for ($i = 0; $i < sm_count($data['fields']); $i++)
						{
							if ($info['id'] == $data['fields'][$i]['name'])
								continue;
							if ($data['fields'][$i]['control'] == 'disabled')
								continue;
							if ($data['fields'][$i]['datatype'] == 'tinyint' || $data['fields'][$i]['datatype'] == 'int')
								$str .= "\t\t\t\t\t\t\t\$q->AddNumeric('".$data['fields'][$i]['name']."', SM::POST('".$data['fields'][$i]['name']."')->AsInt());\n";
							elseif ($data['fields'][$i]['datatype'] == 'decimal')
								$str .= "\t\t\t\t\t\t\t\$q->AddNumeric('".$data['fields'][$i]['name']."', SM::POST('".$data['fields'][$i]['name']."')->AsFloat());\n";
							else
								$str .= "\t\t\t\t\t\t\t\$q->AddString('".$data['fields'][$i]['name']."', SM::POST('".$data['fields'][$i]['name']."')->AsString());\n";
						}
					$str .= "\t\t\t\t\t\t\tif (sm_action('postadd'))
								\$q->Insert();
							else
								\$q->Update('".$info['id']."', SM::GET('id')->AsInt());
							Redirect::Now(SM::GET('returnto')->AsString());
						}
					else
						sm_set_action(['postadd'=>'add', 'postedit'=>'edit']);
				});
			";
					return $str;
				}

			function get_add_code($data)
				{
					$info = parse_mysql_create($data['sql']);
					$setfocus = '';
					$str = "
			sm_on_action(['add', 'edit'], function ()
				{
					".($data['breadcrumbs']=='control'?'add_path_modules()':'add_path_home()').";
					add_path('".$data['moduletitle']."', 'index.php?m='.sm_current_module().'&d=list');
					add_path_current();
					\$ui = new UI();
					SM::Errors()->DisplayUIErrors(\$ui);
					if (sm_action('edit'))
						{
							sm_title(sm_lang('common.edit'));
							\$f=new Form('index.php?m='.sm_current_module().'&d=postedit&id='.SM::GET('id')->AsInt().'&returnto='.SM::GET('returnto')->UrlencodedString());
						}
					else
						{
							sm_title(sm_lang('common.add'));
							\$f=new Form('index.php?m='.sm_current_module().'&d=postadd&returnto='.SM::GET('returnto')->UrlencodedString());
						}\n";
					for ($i = 0; $i < sm_count($data['fields']); $i++)
						{
							if ($info['id'] == $data['fields'][$i]['name'])
								continue;
							if ($data['fields'][$i]['control'] == 'disabled')
								continue;
							if (empty($setfocus))
								$setfocus = $data['fields'][$i]['name'];
							if ($data['fields'][$i]['datatype'] == 'tinyint')
								$str .= "\t\t\t\t\t\$f->AddCheckbox('".$data['fields'][$i]['name']."', '".$data['fields'][$i]['caption']."'".($data['fields'][$i]['required'] ? ', true' : '').");\n";
							elseif ($data['fields'][$i]['datatype'] == 'text')
								$str .= "\t\t\t\t\t\$f->AddTextarea('".$data['fields'][$i]['name']."', '".$data['fields'][$i]['caption']."'".($data['fields'][$i]['required'] ? ', true' : '').");\n";
							elseif ($data['fields'][$i]['datatype'] == 'editor')
								$str .= "\t\t\t\t\t\$f->AddEditor('".$data['fields'][$i]['name']."', '".$data['fields'][$i]['caption']."'".($data['fields'][$i]['required'] ? ', true' : '').");\n";
							else
								$str .= "\t\t\t\t\t\$f->AddText('".$data['fields'][$i]['name']."', '".$data['fields'][$i]['caption']."'".($data['fields'][$i]['required'] ? ', true' : '').");\n";
						}
					$str .= "\t\t\t\t\tif (sm_action('edit'))
						{
							\$q=new TQuery(".$info['tableprefix']."'".$info['table']."');
							\$q->AddWhere('".$info['id']."', SM::GET('id')->AsInt());
							\$f->LoadValuesArray(\$q->Get());
							unset(\$q);
						}
					\$f->LoadValuesArray(SM::Requests()->POSTAsArray());
					\$ui->Add(\$f);
					\$ui->Output(true);
					sm_setfocus('".$setfocus."');
				});
			";
					return $str;
				}

			function get_list_code($data)
				{
					$info = parse_mysql_create($data['sql']);
					$str = "
			sm_on_action('list', function ()
				{
					".($data['breadcrumbs']=='control'?'add_path_modules()':'add_path_home()').";
					add_path('".$data['moduletitle']."', 'index.php?m='.sm_current_module().'&d=list');
					sm_title('".$data['moduletitle']."');
					\$offset=SM::GET('from')->AsAbsInt();
					\$limit=30;
					\$ui = new UI();
					\$b=new Buttons();
					\$b->AddButton('add', sm_lang('common.add'), 'index.php?m='.sm_current_module().'&d=add&returnto='.urlencode(sm_this_url()));
					\$ui->Add(\$b);
					\$t=new Grid();\n";
					for ($i = 0; $i < sm_count($data['fields']); $i++)
						{
							$str .= "\t\t\t\t\t\$t->AddCol('".$data['fields'][$i]['name']."', '".$data['fields'][$i]['caption']."');\n";
						}
					$str .= "\t\t\t\t\t\$t->AddEdit();
					\$t->AddDelete();
					\$q=new TQuery(".$info['tableprefix']."'".$info['table']."');
					\$q->Limit(\$limit);
					\$q->Offset(\$offset);
					\$q->Select();
					for (\$i = 0; \$i<\$q->Count(); \$i++)
						{\n";
					for ($i = 0; $i < sm_count($data['fields']); $i++)
						{
							$str .= "\t\t\t\t\t\t\t\$t->Label('".$data['fields'][$i]['name']."', \$q->items[\$i]['".$data['fields'][$i]['name']."']);\n";
						}
					$str .= "\t\t\t\t\t\t\t\$t->URL('edit', 'index.php?m='.sm_current_module().'&d=edit&id='.\$q->items[\$i]['".$info['id']."'].'&returnto='.urlencode(sm_this_url()));
							\$t->URL('delete', 'index.php?m='.sm_current_module().'&d=postdelete&id='.\$q->items[\$i]['".$info['id']."'].'&returnto='.urlencode(sm_this_url()));
							\$t->NewRow();
						}
					if (\$t->RowCount()==0)
						\$t->SingleLineLabel(sm_lang('messages.nothing_found'));
					\$ui->Add(\$t);
					\$ui->AddPagebarParams(\$q->TotalCount(), \$limit, \$offset);
					\$ui->Add(\$b);
					\$ui->Output(true);
				});
			";
					return ($str);
				}

			function get_admin_code($data)
				{
					$info = parse_mysql_create($data['sql']);
					$str = "
			if (SM::isAdministrator())
				{
					sm_on_action('admin', function ()
						{
							add_path_modules();
							sm_title('".$data['moduletitle']."');
							\$ui = new UI();
							\$nav=new Navigation();
							\$nav->AddItem(sm_lang('common.list'), 'index.php?m='.sm_current_module().'&d=list');
							\$ui->Add(\$nav);
							\$ui->Output(true);
						});
					sm_on_action('install', function ()
						{
							sm_register_module('".$data['modulename']."', '".$data['moduletitle']."');
							//sm_register_autoload('".$data['modulename']."');
							//sm_register_postload('".$data['modulename']."');
							Redirect::Now('index.php?m=admin&d=modules');
						});
					sm_on_action('uninstall', function ()
						{
							sm_unregister_module('".$data['modulename']."');
							//sm_unregister_autoload('".$data['modulename']."');
							//sm_unregister_postload('".$data['modulename']."');
							Redirect::Now('index.php?m=admin&d=modules');
						});
				}
			";
					return $str;
				}

			if (sm_action('generate'))
				{
					$data=[
						'modulename'=>SM::POST('module')->AsString(),
						'moduletitle'=>SM::POST('title')->AsString(),
						'author_uri'=>SM::POST('author_uri')->AsString(),
						'module_uri'=>SM::POST('module_uri')->AsString(),
						'description'=>SM::POST('description')->AsString(),
						'access_level'=>SM::POST('level')->AsInt(),
						'sql'=>SM::POST('sql')->AsString(),
						'breadcrumbs'=>SM::POST('breadcrumbs')->AsString(),
						'fields'=>[],
					];
					$info = parse_mysql_create($data['sql']);
					for ($i = 0; $i < sm_count($info['fields']); $i++)
						{
							$data['fields'][$i]['name'] = $info['fields'][$i][1];
							$data['fields'][$i]['datatype'] = $info['fields'][$i][2];
							$data['fields'][$i]['control'] = SM::POST('field_'.$i)->AsString();
							$data['fields'][$i]['caption'] = SM::POST('fieldcap_'.$i)->AsString();
							$data['fields'][$i]['required'] = SM::POST('required_'.$i)->AsInt() === 1;
						}
					$info = '<'.'?'."php\n\n";
					$info .= "/*\n";
					$info .= "Module Name: ".$data['moduletitle']."\n";
					$info .= "Module URI: ".$data['module_uri']."\n";
					$info .= "Description: ".$data['description']."\n";
					$info .= "Version: 1.0\n";
					$info .= "Revision: ".date('Y-m-d')."\n";
					$info .= "Author URI: ".$data['author_uri']."\n";
					$info .= "*/\n\n";
					$info .= "	use SM\Common\Redirect;\n";
					$info .= "	use SM\SM;\n";
					$info .= "	use SM\UI\Buttons;\n";
					$info .= "	use SM\UI\Grid;\n";
					$info .= "	use SM\UI\Form;\n";
					$info .= "	use SM\UI\Navigation;\n";
					$info .= "	use SM\UI\UI;\n";
					$info .= "\n";
					$info .= '	if (SM::isLoggedIn() && SM::User()->Level()>='.$data['access_level'].')'."\n\t\t{\n";;
					$info .= get_postdelete_code($data);
					$info .= get_postadd_code($data);
					$info .= get_add_code($data);
					$info .= get_list_code($data);
					$info .= get_admin_code($data);
					$info .= "\n\t\t}\n";
					sm_title('Code Generator');
					$ui = new UI();
					//$ui->html('<pre>'.$info.'</pre>');
					$f = new Form(false);
					$f->Separator('PHP');
					$f->AddText('file_name', sm_lang('file_name'))
					  ->WithValue('modules/'.$data['modulename'].'.php');
					$f->AddTextarea('php', 'Code')
						->WithValue($info);
					$f->SetFieldAttribute('php', 'wrap', 'off');
					$f->MergeColumns('php');
					$f->Separator('Template');
					$f->Label('*.tpl file', 'Not required');
					$ui->Add($f);
					$ui->style('#php{height:500px;}');
					$ui->Output(true);
				}

			if (sm_action('prepare'))
				{
					sm_title('Code Generator');
					if (SM::POST('sql')->isEmpty())
						SM::GET('type')->SetValue('');
					$ui = new UI();
					if (SM::GET('type')->isStringEqual('fields'))
						$f = new Form('index.php?m=modulegenerator&d=generate');
					else
						$f = new Form('index.php?m=modulegenerator&d=prepare&type=fields');
					$f->AddText('module', 'Module ID (file name)')->SetFocus();
					$f->AddText('title', 'Module Title');
					$f->AddText('description', 'Module Description');
					$f->AddSelect('level', 'Access Level', [0, 1, 2, 3], [sm_lang('all_users'), sm_lang('logged_users'), sm_lang('power_users'), sm_lang('administrators')])->WithValue(3);
					$f->AddSelect('breadcrumbs', 'Breadcrumbs', ['control', 'home'], ['Control Panel', 'Home']);
					$f->AddText('author_uri', 'Author URL')->WithValue(sm_homepage());
					$f->AddText('module_uri', 'Module URL')->WithValue(sm_homepage());
					$f->AddTextarea('sql', 'SQL Create Query');
					if (SM::GET('type')->isStringEqual('fields'))
						{
							$info = parse_mysql_create(SM::POST('sql')->AsString());
							for ($i = 0; $i < sm_count($info['fields']); $i++)
								{
									$f->Separator('Field: '.$info['fields'][$i][1]);
									$f->AddSelect('field_'.$i, 'Type', ['text', 'textarea', 'editor', 'checkbox', 'disabled'], ['Text', 'Textarea', 'WYSIWYG editor', 'Checkbox', 'Disabled']);
									if ($info['fields'][$i][2] == 'tinyint')
										$f->WithValue('checkbox');
									elseif ($info['fields'][$i][2] == 'text')
										$f->WithValue('textarea');
									else
										$f->WithValue('text');
									$f->AddText('fieldcap_'.$i, 'Caption');
									$cap = str_replace('_', ' ', $info['fields'][$i][1]);
									$cap = strtoupper(substr($cap, 0, 1)).substr($cap, 1);
									$f->WithValue($cap);
									$f->AddCheckbox('required_'.$i, 'Required');
								}
						}
					$f->LoadValuesArray(SM::Requests()->POSTAsArray());
					$f->SaveButton('Next');
					$ui->Add($f);
					$ui->Output(true);
				}

			if (SM::isAdministrator())
				{
					if (sm_action('admin'))
						{
							Redirect::Now('index.php?m=modulegenerator&d=prepare');
						}
					if (sm_action('uninstall'))
						{
							sm_unregister_module('modulegenerator');
							Redirect::Now('index.php?m=admin&d=modules');
						}
				}
		}
	if (!sm_is_installed(sm_current_module()) && SM::isAdministrator())
		{
			if (sm_action('install'))
				{
					sm_register_module('modulegenerator', 'Code Generator');
					Redirect::Now('index.php?m=admin&d=modules');
				}
		}
