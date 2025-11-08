<?php

	//==============================================================================
	//#revision 2022-09-20
	//==============================================================================

	namespace SM\UI;

	sm_add_cssfile('common_admintable.css');

	class Grid
		{
			var $table;
			var $rownumber;

			static $grids_used=0;

			private $sort_statement = '';
			protected $apply_column_hint=false;
			protected $generate_id_for_cells=true;
			protected $generate_classname_for_cells=true;

			function __construct($default_column = '', $postfix = '')
				{
					global $sm;
					$this->rownumber = 0;
					$this->table['columns']=[];
					$this->table['default_column'] = $default_column;
					$this->table['class']='';
					$this->table['no_highlight']=0;
					$this->table['hideheader']=0;
					$this->table['rows']=[];
					$this->SetWidth('100%');
					if (sm_strlen($postfix) == 0)
						$this->table['postfix'] = Grid::$grids_used;
					else
						$this->table['postfix'] = $postfix;
					$this->AddClassnameGlobal('admintable');
					if (!empty($sm['admintable']['globalclass']))
						$this->AddClassnameGlobal($sm['admintable']['globalclass']);
					if (!empty($sm['admintable']['header_tag']))
						$this->table['header_tag']=$sm['admintable']['header_tag'];
					else
						$this->table['header_tag']='td';
					$this->SetDOMID('admintable'.$this->table['postfix']);
					$this->SetHeaderRowAttr('class', 'admintable_header');
					$this->SetHeaderRowAttr('id', 'admintable_header'.$this->table['postfix']);
					$this->table['head_html_start']='<thead>';
					$this->table['head_html_end']='</thead>';
					$this->table['body_html_start']='<tbody>';
					$this->table['body_html_end']='</tbody>';
					Grid::$grids_used++;
				}

			function UseColumnHintForRows()
				{
					$this->apply_column_hint=true;
				}

			function DisableCellsClassnameGeneration()
				{
					$this->generate_classname_for_cells=false;
				}

			function DisableCellsIDGeneration()
				{
					$this->generate_id_for_cells=false;
				}

			function SetWidth($width)
				{
					$this->table['attrs']['width'] = $width;
					return $this;
				}

			function SetInlineImagesStyleGlobal($style)
				{
					$this->table['inlineimages']['style'] = $style;
					return $this;
				}

			function SetInlineImagesClassGlobal($class)
				{
					$this->table['inlineimages']['class'] = $class;
					return $this;
				}

			function AddCol($name, $title, $width = '', $hint = '', $default_text = '', $default_image = '', $messagebox = 0, $messagebox_text = '')
				{
					$this->table['columns'][$name]['caption'] = $title;
					$this->table['columns'][$name]['width'] = $width;
					if (sm_strlen($hint)>0)
						$this->table['columns'][$name]['hint'] = htmlescape(strip_tags($hint));
					$this->table['columns'][$name]['default_text'] = $default_text;
					$this->table['columns'][$name]['imagepath'] = true;//DEPRECATED: Left for compatibility with 1.6.9 and less
					if (!empty($default_image) && sm_strpos($default_image, '/') === false)
						$this->table['columns'][$name]['default_image'] = Grid::ImageURL($default_image);
					$this->table['columns'][$name]['messagebox'] = $messagebox;
					$this->table['columns'][$name]['messagebox_text'] = $messagebox_text;
					$this->table['columns'][$name]['column_class'] = '';
					$this->table['columns'][$name]['html'] = '';
					$this->table['columns'][$name]['onclick'] = '';
					$this->table['columns'][$name]['url'] = '';
					$this->table['columns'][$name]['dropdownitems'] = [];
					return $this;
				}

			function RemoveColumn($name)
				{
					if ($this->HasColumn($name))
						unset($this->table['columns'][$name]);
				}

			function HasColumn($colname)
				{
					if (is_array($this->table['columns']) && array_key_exists($colname, $this->table['columns']))
						return true;
					else
						return false;
				}

			function GetColumnNames()
				{
					$cols=[];
					if (is_array($this->table['columns']))
						{
							foreach ($this->table['columns'] as $name => $columnval)
								$cols[]=$name;
						}
					return $cols;
				}

			function GetColumnNameByIndex($column_index)
				{
					$cols=$this->GetColumnNames();
					return $cols[$column_index];
				}

			function GetColumnTitle($colname)
				{
					return $this->table['columns'][$colname]['caption'];
				}

			function SetColumnTitle($colname, $title)
				{
					$this->table['columns'][$colname]['caption']=$title;
					return $this;
				}

			function SetColumnHeaderAttr($colname, $attrname, $attrval)
				{
					$this->table['columns'][$colname]['header_attr'][$attrname] = $attrval;
					return $this;
				}

			function GetColumnHeaderAttr($colname, $attrname)
				{
					return $this->table['columns'][$colname]['header_attr'][$attrname];
				}

			function AppendCoumnHeaderAttr($colname, $attrname, $attrval, $append_prefix = ' ')
				{
					$this->table['columns'][$colname]['header_attr'][$attrname] .= (sm_strlen($this->table['columns'][$colname]['header_attr'][$attrname])>0 ? $append_prefix : '').$attrval;
					return $this;
				}

			function SetHeaderRowAttr($attrname, $attrval)
				{
					$this->table['header_attrs'][$attrname] = $attrval;
					return $this;
				}

			function GetHeaderRowAttr($attrname)
				{
					return $this->table['header_attrs'][$attrname];
				}

			function AppendHeaderRowAttr($attrname, $attrval, $append_prefix = ' ')
				{
					$this->table['header_attrs'][$attrname] .= (sm_strlen($this->table['header_attrs'][$attrname])>0 ? $append_prefix : '').$attrval;
					return $this;
				}

			function SetHeaderImage($name, $image)
				{
					$this->table['columns'][$name]['html'] .= '<img src="'.Grid::ImageURL($image).'" class="adminform_header_image" />';
					return $this;
				}

			function AddIcon($name, $image, $hint = '')
				{
					if (sm_strpos($image, '.') === false && sm_strpos($image, '://') === false)
						$image .= '.gif';
					$this->AddCol($name, '', '16', $hint, $hint, $image);
					return $this;
				}

			function AddEdit($name = 'edit')
				{
					global $lang;
					$this->AddCol($name, '', '16', $lang['common']['edit'], '<svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2411 2.99111L12.3661 1.86612C12.8543 1.37796 13.6457 1.37796 14.1339 1.86612C14.622 2.35427 14.622 3.14573 14.1339 3.63388L7.05479 10.713C6.70234 11.0654 6.26762 11.3245 5.78993 11.4668L4 12L4.53319 10.2101C4.67548 9.73239 4.93456 9.29767 5.28701 8.94522L11.2411 2.99111ZM11.2411 2.99111L13 4.74999M12 9.33333V12.5C12 13.3284 11.3284 14 10.5 14H3.5C2.67157 14 2 13.3284 2 12.5V5.49999C2 4.67157 2.67157 3.99999 3.5 3.99999H6.66667" stroke="#747B88" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>', '');
					return $this;
				}

			function AddDelete($msg = '', $name = 'delete')
				{
					global $lang;
					if (empty($msg))
						$msg = $lang['common']['really_want_delete'];
					$this->AddCol($name, '', '16', $lang['common']['delete'], '<svg width="18" height="20" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.82692 6L8.59615 12M5.40385 12L5.17308 6M11.8184 3.86038C12.0464 3.89481 12.2736 3.93165 12.5 3.97086M11.8184 3.86038L11.1065 13.115C11.0464 13.8965 10.3948 14.5 9.61095 14.5H4.38905C3.60524 14.5 2.95358 13.8965 2.89346 13.115L2.18157 3.86038M11.8184 3.86038C11.0542 3.74496 10.281 3.65657 9.5 3.59622M1.5 3.97086C1.72638 3.93165 1.95358 3.89481 2.18157 3.86038M2.18157 3.86038C2.94585 3.74496 3.719 3.65657 4.5 3.59622M9.5 3.59622V2.98546C9.5 2.19922 8.8929 1.54282 8.10706 1.51768C7.73948 1.50592 7.37043 1.5 7 1.5C6.62957 1.5 6.26052 1.50592 5.89294 1.51768C5.1071 1.54282 4.5 2.19922 4.5 2.98546V3.59622M9.5 3.59622C8.67504 3.53247 7.84131 3.5 7 3.5C6.15869 3.5 5.32496 3.53247 4.5 3.59622" stroke="#747B88" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>', '', 1, addslashes($msg));
					return $this;
				}

			function AddActions($name = 'actions')
				{
					global $lang;
					$this->AddCol($name, '', '16', $lang['common']['actions'], $lang['common']['actions'], 'actions');
					return $this;
				}

			function SetAsMessageBox($name, $msg)
				{
					$this->table['columns'][$name]['messagebox'] = 1;
					$this->table['columns'][$name]['messagebox_text'] = $msg;
					return $this;
				}

			function ColumnAddClass($name, $classname)
				{
					$this->table['columns'][$name]['column_class'] .= ' '.$classname;
					return $this;
				}

			function HeaderUrl($name, $url)
				{
					$this->table['columns'][$name]['headerurl'] = $url;
					return $this;
				}

			function AddMenuInsert($name = 'tomenu')
				{
					global $lang;
					$this->AddCol($name, '', '', $lang['module_menu']['add_to_menu'], $lang['module_menu']['add_to_menu']);
					$this->table['columns'][$name]['nobr'] = 1;
					return $this;
				}

			function SingleLineLabel($label)
				{
					$first=true;
					foreach ($this->GetColumnNames() as $key)
						{
							if ($first)
								{
									$this->Label($key, $label);
									$first=false;
								}
							else
								$this->Label($key, '');
						}
					$this->AttachEmptyCellsToLeft();
					return $this;
				}

			function AttachEmptyCellsToLeft()
				{
					if ($this->ColCount()>0)
						{
							$i = 0;
							$notempty = '';
							$colspan = 1;
							foreach ($this->GetColumnNames() as $key)
								{
									$info=$this->table['rows'][$this->rownumber][$key];
									if (sm_strlen(sm_get_array_value($info, 'data')) == 0 && sm_strlen(sm_get_array_value($info, 'image')) == 0 && sm_strlen(sm_get_array_value($info, 'url')) == 0 && $i>0)
										{
											$this->Hide($key);
											$colspan++;
										}
									else
										{
											if (!empty($notempty))
												{
													$this->Colspan($notempty, $colspan);
												}
											$notempty = $key;
											$colspan = 1;
										}
									$i++;
								}
							if ($colspan>1)
								$this->Colspan($notempty, $colspan);
						}
					return $this;
				}

			function AutoColspanFor($column_name)
				{
					if (count($this->GetColumnNames())>0)
						{
							$colspan = 1;
							$found=false;
							foreach ($this->GetColumnNames() as $key)
								{
									if (!$found)
										{
											if ($key==$column_name)
												$found=true;
											continue;
										}
									if (sm_strlen($this->table['rows'][$this->rownumber][$key]['data']) == 0 && sm_strlen($this->table['rows'][$this->rownumber][$key]['image']) == 0 && sm_strlen($this->table['rows'][$this->rownumber][$key]['headerurl']) == 0)
										{
											$this->Hide($key);
											$colspan++;
										}
									else
										break;
								}
							if ($colspan>1)
								$this->Colspan($column_name, $colspan);
						}
					return $this;
				}

			function AutoRowspanFor($column_name)
				{
					$row_index = 0;
					while ($row_index < $this->RowCount()-1)
						{
							$rowspan = 1;
							$rowspan_index=$row_index;
							for ($i = $row_index + 1; $i < $this->RowCount(); $i++)
								{
									if (
										sm_strlen($this->table['rows'][$i][$column_name]['data']) == 0
										&& sm_strlen($this->table['rows'][$i][$column_name]['image']) == 0
										&& sm_strlen($this->table['rows'][$i][$column_name]['headerurl']) == 0
										&& intval($this->table['rows'][$i][$column_name]['hide']) != 1
									)
										{
											$this->Hide($column_name, $i);
											$rowspan++;
											$row_index++;
										}
									else
										{
											$row_index++;
											break;
										}
								}
							if ($rowspan > 1)
								$this->Rowspan($column_name, $rowspan, $rowspan_index);
						}
					return $this;
				}

			function HeaderAutoColspanFor($fieldname)
				{
					if (count($this->GetColumnNames())>0)
						{
							$colspan = 1;
							$found=false;
							foreach ($this->GetColumnNames() as $key)
								{
									if (!$found)
										{
											if ($key==$fieldname)
												$found=true;
											continue;
										}
									if (
										sm_strlen($this->table['columns'][$key]['caption']) == 0
										&& sm_strlen($this->table['columns'][$key]['html']) == 0
										&& sm_strlen($this->table['columns'][$key]['url']) == 0
									)
										{
											$this->HeaderHideCol($key);
											$colspan++;
										}
									else
										break;
								}
							if ($colspan>1)
								$this->HeaderColspan($fieldname, $colspan);
						}
					return $this;
				}

			function Colspan($name, $value)
				{
					$this->GetCell($this->rownumber, $name)['colspan'] = $value;
					return $this;
				}

			function Rowspan($name, $value, $row_index=NULL)
				{
					if ($row_index===NULL)
						$row_index=$this->rownumber;
					$this->table['rows'][$row_index][$name]['attrs']['rowspan'] = $value;
					return $this;
				}

			function RowCount()
				{
					return sm_count($this->table['rows']);
				}

			function ColCount()
				{
					return sm_count($this->table['columns']);
				}

			function NewRow()
				{
					if (sm_count($this->table['rows'])==0)
						$this->SetActiveRow(1);
					else
						{
							if ($this->rownumber<sm_count($this->table['rows']))
								$this->rownumber=sm_count($this->table['rows']);
							else
								$this->rownumber++;
							$this->SetActiveRow($this->rownumber);
						}
					return $this;
				}

			function SetActiveRow($index)
				{
					$this->rownumber=$index;
					while(sm_count($this->table['rows'])<$this->rownumber)
						$this->table['rows'][]=Array();
				}

			function RemoveRow($row_index)
				{
					if ($row_index<=$this->RowCount())
						{
							array_splice($this->table['rows'], $row_index, 1);
							//Todo: $this->table['rowparams']
							if ($row_index+1<=$this->rownumber)
								$this->rownumber--;
						}
				}

			function NextRow()
				{
					$this->SetActiveRow($this->rownumber+1);
				}

			function Label($name, $value)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->Label($name[$i], $value);
						}
					else
						$this->GetCell($this->rownumber, $name)['data'] = $value;
					return $this;
				}

			function LabelForDropdown($name, $value, $hide_if_no_items=true)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->LabelForDropdown($name[$i], $value, $hide_if_no_items);
						}
					else
						{
							$this->Label($name, $value);
							$this->GetCell($this->rownumber, $name)['hide_label_if_no_dropdown_items']=$hide_if_no_items;
						}
					return $this;
				}

			function LabelAppend($name, $value)
				{
					$this->GetCell($this->rownumber, $name)['data'] .= $value;
					return $this;
				}

		//Data type should be used in export
			function SetDataTypeInteger($name)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->SetDataTypeInteger($name[$i]);
						}
					else
						$this->GetCell($this->rownumber, $name)['datatype'] = 'integer';
					return $this;
				}

		//Data type should be used in export
			function SetDataTypeMoney($name)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->SetDataTypeMoney($name[$i]);
						}
					else
						$this->GetCell($this->rownumber, $name)['datatype'] = 'money';
					return $this;
				}

		//Data type should be used in export
			function SetDataTypeFloat($name)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->SetDataTypeFloat($name[$i]);
						}
					else
						$this->GetCell($this->rownumber, $name)['datatype'] = 'float';
					return $this;
				}

		//Data type should be used in export
			function SetDataTypeText($name)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->SetDataTypeText($name[$i]);
						}
					else
						$this->GetCell($this->rownumber, $name)['datatype'] = '';
					return $this;
				}

			function GetLabelText($name, $row_index=NULL)
				{
					if ($row_index===NULL)
						$row_index=$this->rownumber;
					return $this->table['rows'][$row_index][$name]['data'];
				}

			function AddClassnameGlobal($classname)
				{
					$this->table['class'] .= ' '.$classname;
					return $this;
				}

			function CellAddClass($name, $classname, $rownumber=NULL)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->CellAddClass($name[$i], $classname, $rownumber);
						}
					else
						{
							if ($rownumber===NULL)
								$rownumber=$this->rownumber;
							$this->GetCell($rownumber, $name)['class'].=' '.$classname;
						}
					return $this;
				}

			function CellHasClass($name, $classname, $rownumber=NULL)
				{
					if ($rownumber === NULL)
						$rownumber = $this->rownumber;
					$classes=explode(' ', $this->GetCell($rownumber, $name)['class']);
					if (in_array($classname, $classes))
						return true;
					else
						return false;
				}

			function CellAddStyle($name, $style)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->CellAddStyle($name[$i], $style);
						}
					else
						$this->GetCell($this->rownumber, $name)['style'] .= $style;
					return $this;
				}

			function Hint($name, $value)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->Hint($name[$i], $value);
						}
					else
						$this->GetCell($this->rownumber, $name)['hint'] = htmlescape(strip_tags($value));
					return $this;
				}

			function SetCellHeaderHTML($name, $value)
				{
					$this->GetCell($this->rownumber, $name)['html_start'] = $value;
					return $this;
				}

			function SetCellFooterHTML($name, $value)
				{
					$this->GetCell($this->rownumber, $name)['html_end'] = $value;
					return $this;
				}

			function AppendCellHeaderHTML($name, $value)
				{
					$this->GetCell($this->rownumber, $name)['html_start'] .= $value;
					return $this;
				}

			function AppendCellFooterHTML($name, $value)
				{
					$this->GetCell($this->rownumber, $name)['html_end'] .= $value;
					return $this;
				}

			function CellHeaderHTML($name)
				{
					return $this->GetCell($this->rownumber, $name)['html_start'];
				}

			function CellFooterHTML($name)
				{
					return $this->GetCell($this->rownumber, $name)['html_end'];
				}

			function CellDOMID($name)
				{
					return 'at'.$this->table['postfix'].'-cell-'.$name.'-'.$this->rownumber;
				}

			public static function ImageURL($image_name)
				{
					if (sm_strpos($image_name, '.') === false && sm_strpos($image_name, '://') === false)
						$image_name .= '.gif';
					if (sm_strpos($image_name, '/') === false)
						{
							if (file_exists('themes/'.sm_current_theme().'/images/admintable/'.$image_name))
								$image_name = 'themes/'.sm_current_theme().'/images/admintable/'.$image_name;
							else
								$image_name = 'themes/default/images/admintable/'.$image_name;
						}
					return $image_name;
				}

			function Image($name, $image_url)
				{
					if (!empty($image_url))
						{
							$this->GetCell($this->rownumber, $name)['imagepath']=true;//DEPRECATED: Left for compatibility with 1.6.9 and less
							$this->GetCell($this->rownumber, $name)['image']=Grid::ImageURL($image_url);
						}
					return $this;
				}

			function InlineImage($name, $image, $url='', $onclick_javascript='')
				{
					$i=sm_count($this->GetCell($this->rownumber, $name)['inlineimages']);
					$this->GetCell($this->rownumber, $name)['inlineimages'][$i]['image'] = Grid::ImageURL($image);
					if (!empty($onclick_javascript) && empty($url))
						$url='javascript:;';
					$this->GetCell($this->rownumber, $name)['inlineimages'][$i]['url'] = $url;
					$this->GetCell($this->rownumber, $name)['inlineimages'][$i]['onclick'] = $onclick_javascript;
					return $this;
				}

			function CustomMessageBox($name, $message)
				{
					$this->GetCell($this->rownumber, $name)['messagebox_text'] = $message;
					return $this;
				}

			function URL($name, $value, $open_in_new_window = false)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->URL($name[$i], $value, $open_in_new_window);
						}
					else
						{
							$this->GetCell($this->rownumber, $name)['url'] = $value;
							$this->GetCell($this->rownumber, $name)['new_window'] = $open_in_new_window;
						}
					return $this;
				}

			function Menu($menu_caption, $menu_url, $name = 'tomenu')
				{
					$this->URL($name, sm_tomenuurl($menu_caption, $menu_url, sm_this_url()));
					return $this;
				}

			function Hide($name, $row_index=NULL)
				{
					if ($row_index===NULL)
						$row_index=$this->rownumber;
					$this->table['rows'][$row_index][$name]['hide'] = 1;
					return $this;
				}

			function ExpanderHTML($html)
				{
					$this->table['expanders'][$this->rownumber]['html'] = $html;
					$this->table['expanders'][$this->rownumber]['enabled'] = true;
					return $this;
				}

			function Expand($name)
				{
					$this->GetCell($this->rownumber, $name)['url'] = 'javascript:;';
					$this->GetCell($this->rownumber, $name)['onclick'] .= "document.getElementById('admintable-expander-".$this->rownumber."-".$this->table['postfix']."').style.display=(document.getElementById('admintable-expander-".$this->rownumber."-".$this->table['postfix']."').style.display)?'':'none';";
					//$this->GetCell($this->rownumber, $name)['url'] = 'javascript:;';
					//$this->GetCell($this->rownumber, $name)['onclick'] .= "document.getElementById('admintable-expander-".$this->rownumber."-".$this->table['postfix']."').style.display=(document.getElementById('admintable-expander-".$this->rownumber."-".$this->table['postfix']."').style.display)?'':'none';";
					return $this;
				}

			function ExpandAJAX($name, $url)
				{
					$this->Expand($name);
					$this->table['expanders'][$this->rownumber]['enabled'] = true;
					$this->GetCell($this->rownumber, $name)['onclick'] .= "admintable_ajax_load".$this->table['postfix']."('".$url."', 'admintable-expanderarea-".$this->rownumber."-".$this->table['postfix']."');";
					return $this;
				}

			protected function &GetCell($row_number, $col_name)
				{
					$cell=&$this->table['rows'][$row_number][$col_name];
					if (!isset($cell))
						{
							$this->table['rows'][$row_number][$col_name]=[];
							$cell['class']='';
							$cell['url']='';
							$cell['onclick']='';
							$cell['style']='';
							$cell['element']='';
							$cell['dropdownitems']=[];
							$cell['inlineimages']=[];
						}
					return $cell;
				}

		//--------------------------------------------------------------------------------------------------------
			function HeaderColspan($name, $value = 2)
				{
					$this->table['columns'][$name]['headercolspan'] = $value;
					return $this;
				}

			function HeaderHideCol($name)
				{
					$this->table['columns'][$name]['hideheader'] = 1;
					return $this;
				}

			function HideHeader()
				{
					$this->table['hideheader'] = 1;
					return $this;
				}

		//--------------------------------------------------------------------------------------------------------
			function OnClick($name, $code)
				{
					if (is_array($name))
						{
							for ($i = 0; $i<sm_count($name); $i++)
								$this->OnClick($name[$i], $code);
						}
					else
						$this->GetCell($this->rownumber, $name)['onclick'] .= $code;
					return $this;
				}

			function HeaderOnClick($name, $code)
				{
					$this->table['columns'][$name]['onclick'] .= $code;
					return $this;
				}

			function DropDownItemsCount($name)
				{
					return sm_count($this->GetCell($this->rownumber, $name)['dropdownitems']);
				}

			function DropDownItem($name, $title, $url, $confirm_message = '', $tomenutitle = '')
				{
					$this->GetCell($this->rownumber, $name)['dropdown'] = 1;
					$this->URL($name, 'javascript:;');
					$this->OnClick($name, "atdropdownopen".$this->table['postfix']."('atdropdown-".$name."-".$this->rownumber."-".$this->table['postfix']."');");
					$i = sm_count($this->GetCell($this->rownumber, $name)['dropdownitems']);
					$this->GetCell($this->rownumber, $name)['dropdownitems'][$i]['title'] = $title;
					$this->GetCell($this->rownumber, $name)['dropdownitems'][$i]['url'] = $url;
					$this->GetCell($this->rownumber, $name)['dropdownitems'][$i]['confirm_message'] = htmlescape($confirm_message);
					$this->GetCell($this->rownumber, $name)['dropdownitems'][$i]['tomenutitle'] = $tomenutitle;
					return $this;
				}

			function DropDownItemSelect($name, $index = -1)
				{
					if ($index == -1)
						$i = sm_count($this->GetCell($this->rownumber, $name)['dropdownitems'])-1;
					else
						$i = $index;
					$this->GetCell($this->rownumber, $name)['dropdownitems'][$i]['selected'] = 1;
					return $this;
				}

			function HeaderDropDownItem($name, $title, $url, $confirm_message = '')
				{
					$this->table['columns'][$name]['dropdown'] = 1;
					$this->HeaderUrl($name, 'javascript:;');
					$this->HeaderOnClick($name, "atdropdownopen".$this->table['postfix']."('atdropdown-".$name."-".$this->table['postfix']."');");
					$i = sm_count($this->table['columns'][$name]['dropdownitems']);
					$this->table['columns'][$name]['dropdownitems'][$i]['title'] = $title;
					$this->table['columns'][$name]['dropdownitems'][$i]['url'] = $url;
					$this->table['columns'][$name]['dropdownitems'][$i]['confirm_message'] = $confirm_message;
					return $this;
				}

			function HeaderDropDownItemSelect($name, $index = -1)
				{
					if ($index == -1)
						$i = sm_count($this->table['columns'][$name]['dropdownitems'])-1;
					else
						$i = $index;
					$this->table['columns'][$name]['dropdownitems'][$i]['selected'] = 1;
					return $this;
				}

			function HeaderDropDownItemAutoSelect($name, $url=NULL)
				{
					if ($url===NULL)
						$url=sm_this_url();
					for ($i = 0; $i<sm_count($this->table['columns'][$name]['dropdownitems']); $i++)
						{
							if (sm_strcmp(sm_relative_url($this->table['columns'][$name]['dropdownitems'][$i]['url']), sm_relative_url($url))==0)
								$this->HeaderDropDownItemSelect($name, $i);
						}
					return $this;
				}

			private function USortRowsByColumnData($a, $b)
				{
					if ($a == $b)
						return 0;
					$cols = explode(',', $this->sort_statement);
					for ($j = 0; $j<sm_count($cols); $j++)
						{
							$col = explode(' ', trim($cols[$j]));
							if (strtoupper($col[2]) == 'NUM' || strtoupper($col[1]) == 'NUM')
								{
									if ($a[$col[0]]['data'] == $b[$col[0]]['data'])
										$result = 0;
									else
										$result = $a[$col[0]]['data']>$b[$col[0]]['data'] ? 1 : -1;
								}
							else
								$result = sm_strcmp($a[$col[0]]['data'], $b[$col[0]]['data']);
							if ($result != 0)
								return (strtoupper($col[1]) == 'DESC' ? -1 : 1)*($result<0 ? -1 : 1);
						}
					return 0;
				}

			function SortRowsByColumnData($comma_separaded_columns)
				{
					if ($this->RowCount()==0)
						return $this;
					$this->sort_statement = $comma_separaded_columns;
					usort($this->table['rows'], array(
						$this,
						"USortRowsByColumnData"
					));
					return $this;
				}

		//-------- FORM FUNCTIONS ------------------------------------------------------------------------------------------------
			function Textbox($name, $varname, $value)
				{
					$this->GetCell($this->rownumber, $name)['data'] = $value;
					$this->GetCell($this->rownumber, $name)['element'] = 'text';
					$this->GetCell($this->rownumber, $name)['varname'] = $varname;
					return $this;
				}

			function Selectbox($name, $varname, $value, $valuesarrayornllist, $labelsarrayornllist)
				{
					if (!is_array($valuesarrayornllist))
						$valuesarrayornllist = nllistToArray($valuesarrayornllist);
					if (!is_array($labelsarrayornllist))
						$labelsarrayornllist = nllistToArray($labelsarrayornllist);
					$this->GetCell($this->rownumber, $name)['data'] = $value;
					$this->GetCell($this->rownumber, $name)['element'] = 'select';
					$this->GetCell($this->rownumber, $name)['values'] = $valuesarrayornllist;
					$this->GetCell($this->rownumber, $name)['labels'] = $labelsarrayornllist;
					$this->GetCell($this->rownumber, $name)['varname'] = $varname;
					return $this;
				}

			function Checkbox($name, $varname, $checkedvalue, $checked = false)
				{
					$this->GetCell($this->rownumber, $name)['data'] = $checkedvalue;
					$this->GetCell($this->rownumber, $name)['element'] = 'checkbox';
					$this->GetCell($this->rownumber, $name)['varname'] = $varname;
					$this->GetCell($this->rownumber, $name)['checked'] = $checked;
					return $this;
				}

			function RadioItem($name, $varname, $checkedvalue, $checked = false)
				{
					$this->GetCell($this->rownumber, $name)['data'] = $checkedvalue;
					$this->GetCell($this->rownumber, $name)['element'] = 'radioitem';
					$this->GetCell($this->rownumber, $name)['varname'] = $varname;
					$this->GetCell($this->rownumber, $name)['checked'] = $checked;
					return $this;
				}

			function SetControlAttr($name, $attrname, $attrval)
				{
					$this->GetCell($this->rownumber, $name)['control_attr'][$attrname] = $attrval;
					return $this;
				}

			function GetControlAttr($name, $attrname)
				{
					return $this->GetCell($this->rownumber, $name)['control_attr'][$attrname];
				}

			function AppendControlAttr($name, $attrname, $attrval, $append_prefix = ' ')
				{
					if (!isset($this->GetCell($this->rownumber, $name)['control_attr'][$attrname]))
						$this->GetCell($this->rownumber, $name)['control_attr'][$attrname]='';
					$this->GetCell($this->rownumber, $name)['control_attr'][$attrname] .= (sm_strlen($this->GetCell($this->rownumber, $name)['control_attr'][$attrname])>0 ? $append_prefix : '').$attrval;
					return $this;
				}

			function GetControlDOMID($name, $rownumber = NULL)
				{
					if ($rownumber === NULL)
						$rownumber = $this->rownumber;
					return 'control-'.$this->table['postfix'].'-'.$name.'-row'.$rownumber;
				}

		//Input type=hidden + Label
			function StoredLabel($name, $varname, $value)
				{
					$this->GetCell($this->rownumber, $name)['data'] = $value;
					$this->GetCell($this->rownumber, $name)['element'] = 'storedlabel';
					$this->GetCell($this->rownumber, $name)['varname'] = $varname;
					return $this;
				}

		//-------- /FORM FUNCTIONS ------------------------------------------------------------------------------------------------
			function NoHighlight()
				{
					$this->table['no_highlight'] = 1;
					return $this;
				}

			function HeaderBulkCheckbox($name)
				{
					$this->table['columns'][$name]['html'] = '<input type="checkbox" id="'.$name.'-'.($this->table['postfix']).'-bulkcheckbox" class="at-bulk-checkbox" onchange="'.
						"\$('.admintable-".($this->table['postfix'])."-control-".$name."').prop('checked', \$('#".$name.'-'.($this->table['postfix'])."-bulkcheckbox').prop('checked')?true:false);$('.admintable-".($this->table['postfix'])."-control-".$name."').trigger('change');".
						'" />';
					return $this;
				}

		//-----------------------------
			function LabelsFromArray($array)
				{
					if (!is_array($this->table['columns']) || !is_array($array))
						return $this;
					foreach ($this->table['columns'] as $key => $val)
						{
							if (array_key_exists($key, $array))
								$this->Label($key, $array[$key]);
						}
					return $this;
				}
			function SetLabels()
				{
					if (func_num_args()==0)
						return $this;
					$columns=$this->GetColumnNames();
					for ($i = 0; $i < sm_count($columns) && $i<func_num_args(); $i++)
						{
							$this->Label($columns[$i], func_get_arg($i));
						}
					return $this;
				}

		//-----------------------------
			protected function &GetRowParams($row_number)
				{
					$params=&$this->table['rowparams'][$row_number];
					if (!isset($params))
						{
							$params['class']='';
							$params['style']='';
						}
					return $params;
				}

			function RowAddClass($classname, $rownumber = NULL)
				{
					if ($rownumber === NULL)
						$rownumber = $this->rownumber;
					$this->GetRowParams($rownumber)['class'] .= ' '.$classname;
					//$this->GetRowParams($rownumber)['class'] .= ' '.$classname;
					return $this;
				}

			function RowAddStyle($rule, $rownumber = NULL)
				{
					if ($rownumber === NULL)
						$rownumber = $this->rownumber;
					$this->GetRowParams($rownumber)['style'] .= $rule;
					return $this;
				}
			function RowHighlightError($rownumber = NULL)
				{
					$this->RowAddClass('at-highlight-error', $rownumber);
				}
			function RowHighlightWarning($rownumber = NULL)
				{
					$this->RowAddClass('at-highlight-warning', $rownumber);
				}
			function RowHighlightInfo($rownumber = NULL)
				{
					$this->RowAddClass('at-highlight-info', $rownumber);
				}
			function RowHighlightSuccess($rownumber = NULL)
				{
					$this->RowAddClass('at-highlight-success', $rownumber);
				}
			function RowHighlightAttention($rownumber = NULL)
				{
					$this->RowAddClass('at-highlight-attention', $rownumber);
				}
			function CellHighlightError($name)
				{
					$this->CellAddClass($name, 'at-highlight-error');
				}
			function CellHighlightWarning($name)
				{
					$this->CellAddClass($name, 'at-highlight-warning');
				}
			function CellHighlightInfo($name)
				{
					$this->CellAddClass($name, 'at-highlight-info');
				}
			function CellHighlightSuccess($name)
				{
					$this->CellAddClass($name, 'at-highlight-success');
				}
			function CellHighlightAttention($name)
				{
					$this->CellAddClass($name, 'at-highlight-attention');
				}
			function CellAlignLeft($name)
				{
					$this->CellAddStyle($name, 'text-align:left;');
				}
			function CellAlignRight($name)
				{
					$this->CellAddStyle($name, 'text-align:right;');
				}
			function CellAlignCenter($name)
				{
					$this->CellAddStyle($name, 'text-align:center;');
				}
			function NoBR($name=NULL)
				{
					if ($name===NULL)
						{
							foreach ($this->table['columns'] as $name => $columnval)
								$this->NoBR($name);
						}
					elseif (is_array($name))
						{
							foreach ($name as $colname)
								$this->NoBR($colname);
						}
					else
						$this->CellAddClass($name, 'at-nobr');
				}

		//====================================================
			function SetGlobalAttribute($attribute, $value)
				{
					if ($value===NULL)
						unset($this->table['attrs'][$attribute]);
					else
						$this->table['attrs'][$attribute] = $value;
					return $this;
				}

			function HasGlobalAttribute($attribute)
				{
					return is_array($this->table['attrs']) && array_key_exists($attribute, $this->table['attrs']);
				}

			function GetGlobalAttribute($attribute)
				{
					return $this->table['attrs'][$attribute];
				}

			function AppendGlobalAttribute($attribute, $value, $delimiter=' ')
				{
					$attrval=$this->GetGlobalAttribute($attribute);
					if (!empty($attrval))
						$attrval.=$delimiter;
					$attrval.=$value;
					$this->SetGlobalAttribute($attribute, $attrval);
					return $this;
				}

			function UnsetGlobalAttribute($attribute)
				{
					$this->SetGlobalAttribute($attribute, NULL);
					return $this;
				}

			function SetDOMID($id)
				{
					$this->SetGlobalAttribute('id', $id);
				}

			function GetDOMID()
				{
					return $this->GetGlobalAttribute('id');
				}

		//====================================================
			protected function BeforeOutput()
				{}

			function Output()
				{
					global $sm;
					$this->BeforeOutput();
					$this->table['colcount'] = sm_count($this->table['columns']);
					$this->table['rowcount'] = sm_count($this->table['rows']);
					if (!empty($this->table['class']))
						$this->SetGlobalAttribute('class', $this->table['class']);
					foreach ($this->table['columns'] as $name => $columnval)
						{
							if (!empty($columnval['hint']))
								$this->SetColumnHeaderAttr($name, 'title', $columnval['hint']);
							if (!empty($columnval['width']))
								$this->SetColumnHeaderAttr($name, 'width', $columnval['width']);
							if (!empty($columnval['align']))
								$this->SetColumnHeaderAttr($name, 'align', $columnval['align']);
							if (!empty($columnval['headercolspan']))
								$this->SetColumnHeaderAttr($name, 'colspan', $columnval['headercolspan']);
							if (!empty($sm['admintable']['header_th_wrapper_begin']))
								$this->table['columns'][$name]['th_html_start'] = $sm['admintable']['header_th_wrapper_begin'].$this->table['columns'][$name]['th_html_start'];
							if (!empty($sm['admintable']['header_th_wrapper_end']))
								$this->table['columns'][$name]['th_html_end'] = $this->table['columns'][$name]['th_html_end'].$sm['admintable']['header_th_wrapper_end'];
						}
					for ($this->rownumber = 0; $this->rownumber<$this->RowCount(); $this->rownumber++)
						{
							$this->RowAddClass('at-row-'.$this->rownumber, $this->rownumber);
							if (intval($this->table['no_highlight']) != 1)
								if ($this->rownumber%2 == 0)
									$this->RowAddClass('at-row-pair', $this->rownumber);
								else
									$this->RowAddClass('at-row-odd', $this->rownumber);
							foreach ($this->table['columns'] as $name => $columnval)
								{
									if (in_array($this->GetCell($this->rownumber, $name)['element'], Array(
										'text',
										'select',
										'checkbox',
										'radioitem',
										'storedlabel'
									))
									)
										{
											if ($this->GetCell($this->rownumber, $name)['element'] == 'text')
												$this->SetControlAttr($name, 'type', 'text');
											if ($this->GetCell($this->rownumber, $name)['element'] == 'checkbox')
												{
													$this->SetControlAttr($name, 'type', 'checkbox');
													if ($this->GetCell($this->rownumber, $name)['checked'])
														$this->SetControlAttr($name, 'checked', 'checked');
												}
											if ($this->GetCell($this->rownumber, $name)['element'] == 'radioitem')
												$this->SetControlAttr($name, 'type', 'radio');
											if ($this->GetCell($this->rownumber, $name)['element'] == 'storedlabel')
												$this->SetControlAttr($name, 'type', 'hidden');
											if ($this->GetCell($this->rownumber, $name)['element'] == 'select')
												{
													$this->SetControlAttr($name, 'size', '1');
													$this->AppendControlAttr($name, 'class', 'admintable-control-select');
													$this->AppendControlAttr($name, 'class', 'admintable-'.$this->table['postfix'].'-control-select');
												}
											else
												{
													$this->SetControlAttr($name, 'value', $this->GetCell($this->rownumber, $name)['data']);
													$this->AppendControlAttr($name, 'class', 'admintable-control-'.$this->GetControlAttr($name, 'type'));
													$this->AppendControlAttr($name, 'class', 'admintable-'.$this->table['postfix'].'-control-'.$this->GetControlAttr($name, 'type'));
													$this->AppendControlAttr($name, 'class', 'admintable-'.$this->table['postfix'].'-control-'.$name);
												}
											$this->SetControlAttr($name, 'name', $this->GetCell($this->rownumber, $name)['varname']);
											$this->SetControlAttr($name, 'id', $this->GetControlDOMID($name, $this->rownumber));
											if (!empty($this->GetCell($this->rownumber, $name)['onclick']))
												$this->SetControlAttr($name, 'onclick', $this->GetCell($this->rownumber, $name)['onclick']);
										}
									if (sm_count($this->GetCell($this->rownumber, $name)['inlineimages'])>0)
										{
											$inlineimages='';
											for ($i = 0; $i<sm_count($this->GetCell($this->rownumber, $name)['inlineimages']); $i++)
												{
													if (!empty($this->GetCell($this->rownumber, $name)['inlineimages'][$i]['url']))
														{
															$html='<a href="'.$this->GetCell($this->rownumber, $name)['inlineimages'][$i]['url'].'"';
															if (!empty($this->GetCell($this->rownumber, $name)['inlineimages'][$i]['onclick']))
																$html.=' onclick="'.$this->GetCell($this->rownumber, $name)['inlineimages'][$i]['onclick'].'"';
															$html.='>'.'<img src="'.$this->GetCell($this->rownumber, $name)['inlineimages'][$i]['image'].'" />'.'</a>';
														}
													else
														$html='<img src="'.$this->GetCell($this->rownumber, $name)['inlineimages'][$i]['image'].'" />';
													$inlineimages.=$html;
												}
											$this->GetCell($this->rownumber, $name)['data'].='<span class="at-inlineimages'.(empty($this->table['inlineimages']['class'])?'':' '.$this->table['inlineimages']['class']).'"'.(empty($this->table['inlineimages']['style'])?'':' style="'.$this->table['inlineimages']['style']).'">'.$inlineimages.'</span>';
										}
									if (!empty($this->table['columns'][$name]['column_class']))
										{
											$this->CellAddClass($name, $this->table['columns'][$name]['column_class'], $this->rownumber);
										}
									if (!empty($this->GetCell($this->rownumber, $name)['colspan']))
										$this->GetCell($this->rownumber, $name)['attrs']['colspan']=$this->GetCell($this->rownumber, $name)['colspan'];
									if (!empty($this->GetCell($this->rownumber, $name)['hint']))
										$this->GetCell($this->rownumber, $name)['attrs']['title']=$this->GetCell($this->rownumber, $name)['hint'];
									elseif ($this->apply_column_hint && !empty($this->table['columns'][$name]['hint']))
										$this->GetCell($this->rownumber, $name)['attrs']['title']=$this->table['columns'][$name]['hint'];
									if (!empty($this->GetCell($this->rownumber, $name)['align']))
										$this->GetCell($this->rownumber, $name)['attrs']['align']=$this->GetCell($this->rownumber, $name)['align'];
									if ($this->table['hideheader']==1 && !empty($this->table['columns'][$name]['width']))
										$this->GetCell($this->rownumber, $name)['attrs']['width']=$this->table['columns'][$name]['width'];
									if ($this->generate_id_for_cells)
										$this->GetCell($this->rownumber, $name)['attrs']['id']='at'.$this->table['postfix'].'-cell-'.$name.'-'.$this->rownumber;
									if ($this->generate_classname_for_cells)
										$this->GetCell($this->rownumber, $name)['attrs']['class']='at-cell-'.$name;
									if (!empty($this->GetCell($this->rownumber, $name)['class']))
										$this->GetCell($this->rownumber, $name)['attrs']['class'].=$this->GetCell($this->rownumber, $name)['class'];
									if (!empty($this->GetCell($this->rownumber, $name)['style']))
										$this->GetCell($this->rownumber, $name)['attrs']['style']=$this->GetCell($this->rownumber, $name)['style'];
									if (!empty($this->GetCell($this->rownumber, $name)['hide_label_if_no_dropdown_items']))
										{
											if (empty($this->GetCell($this->rownumber, $name)['dropdownitems']))
												$this->GetCell($this->rownumber, $name)['data']='';
										}
								}
						}
					return $this->table;
				}
		}

	Grid::$grids_used = 0;
