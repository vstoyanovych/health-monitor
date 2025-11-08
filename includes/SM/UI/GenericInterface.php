<?php

	//==============================================================================
	//#revision 2020-09-20
	//==============================================================================

	namespace SM\UI;

	sm_add_cssfile('common_admininterface.css');

	class GenericInterface
		{
			var $blocks;
			var $currentblock;
			var $items;
			var $item;

			function __construct($title='', $showborders=1)
				{
					$this->currentblock=-1;
					$this->AddBlock($title, $showborders);
				}

		/**
		 * @param int $index - if $index===NULL - next item will be placed at the end of the list
		 */
			protected function SetActiveItem($index=NULL)
				{
					if ($index===NULL)
						$index=sm_count($this->blocks[$this->currentblock]['items']);
					$this->item=&$this->blocks[$this->currentblock]['items'][$index];
				}

			function InsertItemAtIndex($index)
				{
					array_splice($this->blocks[$this->currentblock]['items'], $index, 0, Array(Array()));
					$this->SetActiveItem($index);
				}

			function AddBlock($title, $showborders=1)
				{
					if (!($this->currentblock==0 && $this->blocks[$this->currentblock]['itemscount']==0))
						$this->currentblock++;
					$this->blocks[$this->currentblock]['title']=$title;
					$this->blocks[$this->currentblock]['show_borders']=$showborders;
					$this->blocks[$this->currentblock]['items']=Array();
					$this->items=&$this->blocks[$this->currentblock]['items'];
					$this->blocks[$this->currentblock]['itemscount']=0;
					$this->SetActiveItem();
				}

		/**
		 * @param bool $val
		 */
			function SetShowBordersValue($val)
				{
					if ($val)
						$this->blocks[$this->currentblock]['show_borders']=1;
					else
						$this->blocks[$this->currentblock]['show_borders']=0;
				}

			function AddOutputObject($type, $object, $tpl='', $use_data_as_output=false)
				{
					$this->blocks[$this->currentblock]['itemscount']++;
					$this->item['type']=$type;
					$this->item['tpl']=$tpl;
					if (is_object($object) && !$use_data_as_output)
						$this->item[$type]=$object->Output();
					else
						$this->item['data']=$object->Output();
					$this->SetActiveItem();
				}

			function Add($object)
				{
					if (!is_object($object))
						return;
					if (is_a($object, TreeView::class))
						$this->html($object->Output());
					elseif (is_a($object, Grid::class))
						$this->AddOutputObject('table', $object);
					elseif (is_a($object, Form::class))
						$this->AddOutputObject('form', $object);
					elseif (is_a($object, Buttons::class))
						$this->AddOutputObject('bar', $object);
					elseif (is_a($object, Panel::class))
						$this->AddOutputObject('panel', $object);
					elseif (is_a($object, Tabs::class))
						$this->AddOutputObject('tabs', $object, 'common_admintabs.tpl', true);
					elseif (get_class($object)=='TDashBoard')
						$this->AddOutputObject('dashboard', $object, 'common_admindashboard.tpl', true);
					elseif (is_a($object, Navigation::class))
						$this->AddOutputObject('navigation', $object, 'common_adminnavigation.tpl', true);
				}

			function AddForm($form)
				{
					$this->AddOutputObject('form', $form);
				}

			function AddTPL($tplname, $action='view', $data=Array())
				{
					$this->blocks[$this->currentblock]['itemscount']++;
					$this->item['type']='tpl';
					$this->item['action']=$action;
					$this->item['tpl']=$tplname;
					$this->item['data']=$data;
					$this->SetActiveItem();
				}

			function AddGrid($grid)
				{
					$this->AddOutputObject('table', $grid);
				}

			function AddButtons($buttons)
				{
					$this->AddOutputObject('bar', $buttons);
				}

			function AddPanel($panel)
				{
					$this->AddOutputObject('panel', $panel);
				}

			function AddPagebarParams($count, $limit, $offset)
				{
					global $sm;
					sm_pagination_init($count, $limit, $offset);
					$this->AddPagebar();
				}

			function AddPagebar($html_not_used='')
				{
					$this->blocks[$this->currentblock]['itemscount']++;
					$this->item['type']='pagebar';
					$this->SetActiveItem();
				}

			function GetPagebarPagesCount()
				{
					global $sm;
					return intval($sm['m']['pages']['pages']);
				}

			function AddDashboard($dashboard)
				{
					$this->AddOutputObject('dashboard', $dashboard, 'common_admindashboard.tpl', true);
				}

			function AddNavigation($navigation)
				{
					$this->AddOutputObject('navigation', $navigation, 'common_adminnavigation.tpl', true);
				}

			function html($html)
				{
					$this->blocks[$this->currentblock]['itemscount']++;
					$this->item['type']='html';
					$this->item['html']=$html;
					$this->SetActiveItem();
				}

			function span($html, $id='', $class='', $style='', $additionaltagattrs='', $writeclosetag=true)
				{
					$code='<span'.(empty($id)?'':' id="'.$id.'"').''.(empty($class)?'':' class="'.$class.'"').''.(empty($style)?'':' style="'.$style.'"').$additionaltagattrs.'>'.$html.($writeclosetag?'</span>':'');
					$this->html($code);
				}

			function div($html, $id='', $class='', $style='', $additionaltagattrs='', $writeclosetag=true)
				{
					$code='<div'.(empty($id)?'':' id="'.$id.'"').''.(empty($class)?'':' class="'.$class.'"').''.(empty($style)?'':' style="'.$style.'"').$additionaltagattrs.'>'.$html.($writeclosetag?'</div>':'');
					$this->html($code);
				}

			function div_open($id='', $class='', $style='', $additionaltagattrs='')
				{
					$this->div('', $id, $class, $style, $additionaltagattrs, false);
				}

			function div_close()
				{
					$this->html('</div>');
				}

			function form_open($action, $method='post', $id='', $class='', $style='', $additionaltagattrs='')
				{
					if (empty($method))
						$method='post';
					$code='<form action="'.$action.'" method="'.$method.'"'.(empty($id)?'':' id="'.$id.'"').''.(empty($class)?'':' class="'.$class.'"').''.(empty($style)?'':' style="'.$style.'"').$additionaltagattrs.'>';
					$this->html($code);
				}

			function form_close()
				{
					$this->html('</form>');
				}

			function p($html, $id='', $class='', $style='', $additionaltagattrs='', $writeclosetag=true)
				{
					$code='<p'.(empty($id)?'':' id="'.$id.'"').''.(empty($class)?'':' class="'.$class.'"').''.(empty($style)?'':' style="'.$style.'"').$additionaltagattrs.'>'.$html.($writeclosetag?'</p>':'');
					$this->html($code);
				}

			function p_open($id='', $class='', $style='', $additionaltagattrs='')
				{
					$this->p('', $id, $class, $style, $additionaltagattrs, false);
				}

			function p_close()
				{
					$this->html('</p>');
				}

			function img($src, $id='', $class='', $style='', $additionaltagattrs='')
				{
					$code='<img src="'.$src.'"'.(empty($id)?'':' id="'.$id.'"').''.(empty($class)?'':' class="'.$class.'"').''.(empty($style)?'':' style="'.$style.'"').$additionaltagattrs.' />';
					$this->html($code);
				}

			function h($type, $html, $id='', $class='', $style='', $additionaltagattrs='')
				{
					$code='<h'.$type.(empty($id)?'':' id="'.$id.'"').''.(empty($class)?'':' class="'.$class.'"').''.(empty($style)?'':' style="'.$style.'"').$additionaltagattrs.'>'.$html.'</h'.$type.'>';
					$this->html($code);
				}

			function a($href, $html, $id='', $class='', $style='', $onclick='', $additionaltagattrs='')
				{
					$code='<a href="'.$href.'"'.(empty($id)?'':' id="'.$id.'"').''.(empty($class)?'':' class="'.$class.'"').''.(empty($style)?'':' style="'.$style.'"').''.(empty($onclick)?'':' onclick="'.$onclick.'"').$additionaltagattrs.'>'.$html.'</a>';
					$this->html($code);
				}

			function br()
				{
					$this->html('<br />');
				}

			function style($css)
				{
					$this->html('<style type="text/css">'.$css.'</style>');
				}

			function javascript($jscode)
				{
					$this->html('<script type="text/javascript">'.$jscode.'</script>');
				}

			function hr($id='', $class='', $style='', $additionaltagattrs='')
				{
					$code='<hr '.(empty($id)?'':' id="'.$id.'"').''.(empty($class)?'':' class="'.$class.'"').''.(empty($style)?'':' style="'.$style.'"').$additionaltagattrs.' />';
					$this->html($code);
				}

			function NotificationError($message, $url='', $open_url_in_new_window=false)
				{
					if (sm_strlen($url)>0)
						$message='<a href="'.$url.'"'.($open_url_in_new_window?' target="_blank"':'').'>'.$message.'</a>';
					$this->div($message, '', 'aui-message aui-message-error');
				}

			function NotificationWarning($message, $url='', $open_url_in_new_window=false)
				{
					if (sm_strlen($url)>0)
						$message='<a href="'.$url.'"'.($open_url_in_new_window?' target="_blank"':'').'>'.$message.'</a>';
					$this->div($message, '', 'aui-message aui-message-warning');
				}

			function NotificationInfo($message, $url='', $open_url_in_new_window=false)
				{
					if (sm_strlen($url)>0)
						$message='<a href="'.$url.'"'.($open_url_in_new_window?' target="_blank"':'').'>'.$message.'</a>';
					$this->div($message, '', 'aui-message aui-message-info');
				}

			function NotificationSuccess($message, $url='', $open_url_in_new_window=false)
				{
					if (sm_strlen($url)>0)
						$message='<a href="'.$url.'"'.($open_url_in_new_window?' target="_blank"':'').'>'.$message.'</a>';
					$this->div($message, '', 'aui-message aui-message-success');
				}

			function Output()
				{
					return $this->blocks;
				}

			function AJAXLoader($url)
				{
					$id='uial-'.md5(rand().microtime().rand());
					$this->html('<div id="'.$id.'" class="ui-ajax-loading">Loading...</div>');
					$this->javascript('$(document).ready(function(){$("#'.$id.'").load( "'.$url.'");});');
				}

			function HasElements()
				{
					if ($this->currentblock>0 || intval($this->blocks[0]['itemscount'])>0)
						return true;
					else
						return false;
				}

		}

