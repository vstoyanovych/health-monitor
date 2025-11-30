<?php

	//==============================================================================
	//#revision 2020-09-20
	//==============================================================================

	namespace SM\UI;

	sm_add_cssfile('common_adminnavigation.css');

	class Navigation
		{
			protected $nav = [
				'class'=>'',
				'style'=>'',
				'items'=>[],
			];
			protected $currentitem;

			function __construct()
				{
					global $sm;
					if (!empty($sm['adminnavigation']['globalclass']))
						$this->AddClassnameGlobal($sm['adminnavigation']['globalclass']);
				}

			function AddItem($title, $url, $name='')
				{
					global $sm;
					if (empty($name))
						$name = md5(rand(1, 999999));
					$this->SetActiveItem($name);
					$this->SetTitle($title);
					$this->SetURL($url);
					$this->currentitem['level']=1;
					$this->currentitem['active']=false;
					$this->currentitem['active_on_partial']=false;
					if (!empty($sm['adminnavigation']['item_li_class']))
						$this->currentitem['container']['attrs']['class']=$sm['adminnavigation']['item_li_class'];
					if (!empty($sm['adminnavigation']['item_a_class']))
						{
							$this->AddClassname($sm['adminnavigation']['item_a_class']);
						}
					return $this;
				}

			protected function SetActiveItem($name)
				{
					$this->currentitem=&$this->nav['items'][$name];
					if (!isset($this->currentitem))
						{
							$this->currentitem['name']=$name;
							$this->currentitem['class']='';
							$this->currentitem['style']='';
							$this->currentitem['onclick']='';
							$this->currentitem['container']['attrs']['class']='';
						}
					return $this;
				}

			function SetURL($url, $name='')
				{
					if (!empty($name))
						$this->SetActiveItem($name);
					$this->currentitem['attrs']['href']=$url;
					return $this;
				}

			function SetTitle($title, $name='')
				{
					if (!empty($name))
						$this->SetActiveItem($name);
					$this->currentitem['title']=$title;
					return $this;
				}

			function SetImage($image, $name='')
				{
					if (!empty($name))
						$this->SetActiveItem($name);
					if (sm_strlen($image)>0 && sm_strpos($image, '://')===false && sm_strpos($image, '.')===false)
						$image.='.png';
					if (!empty($image) && sm_strpos($image, '/')===false)
						{
							if (!file_exists('themes/'.sm_current_theme().'/images/adminnavigation/'.$image))
								$image='themes/default/images/adminnavigation/'.$image;
							else
								$image='themes/'.sm_current_theme().'/images/adminnavigation/'.$image;
						}
					$this->currentitem['image']=$image;
					return $this;
				}

			function AddClassname($classname, $name='')
				{
					if (!empty($name))
						$this->SetActiveItem($name);
					$this->currentitem['class'].=(empty($this->currentitem['class'])?'':' ').$classname;
					return $this;
				}

			function AddClassnameGlobal($classname)
				{
					$this->nav['class'].=(empty($this->nav['class'])?'':' ').$classname;
					return $this;
				}

			function SetStyle($style, $name='')
				{
					if (!empty($name))
						$this->SetActiveItem($name);
					$this->currentitem['style']=$style;
					return $this;
				}

			function SetFA($fa_tag, $name='')
				{
					if (!empty($name))
						$this->SetActiveItem($name);
					$this->currentitem['fa']=$fa_tag;
					return $this;
				}

			function SetActive($name='')
				{
					if (!empty($name))
						$this->SetActiveItem($name);
					$this->currentitem['active']=true;
					$this->currentitem['container']['attrs']['class'].=(empty($this->currentitem['container']['attrs']['class'])?'':' ').' active';
					return $this;
				}

			function SetAutodetectionPartialMode($name='')
				{
					if (!empty($name))
						$this->SetActiveItem($name);
					$this->currentitem['active_on_partial']=true;
					return $this;
				}

			function OpenInNewWindow($name='')
				{
					if (!empty($name))
						$this->SetActiveItem($name);
					$this->currentitem['attrs']['target']='_blank';
					return $this;
				}

			function SetStyleGlobal($style)
				{
					$this->nav['style']=$style;
					return $this;
				}

			function AutoDetectActive()
				{
					global $sm;
					if (is_array($this->nav['items']))
						{
							$tmp_index=sm_strpos($sm['_s']['resource_url'], '/');
							$main_suburl=substr($sm['_s']['resource_url'], $tmp_index);
							foreach ($this->nav['items'] as $itemname=>&$itemparams)
								{
									if (
										(sm_strcmp($main_suburl.$itemparams['attrs']['href'], $sm['server']['REQUEST_URI'])==0
											||
											sm_strcmp($main_suburl.$itemparams['attrs']['href'], $sm['server']['REQUEST_URI'].'index.php')==0)
										|| (sm_is_index_page() && sm_strcmp($itemparams['attrs']['href'], $sm['s']['page']['scheme'].'://'.$sm['_s']['resource_url'])==0)
									)
										$this->SetActive($itemname);
									if (!$itemparams['active'] && $itemparams['active_on_partial'])
										{
											if (sm_strpos($sm['server']['REQUEST_URI'], $main_suburl.$itemparams['attrs']['href'])===0)
												$this->SetActive($itemname);
										}
								}
						}
					return $this;
				}

			function Count()
				{
					return sm_count($this->nav['items']);
				}

			function Output()
				{
					global $sm;
					if (is_array($this->nav['items']))
						{
							foreach ($this->nav['items'] as $itemname=>&$itemparams)
								{
									$itemparams['container']['attrs']['class'].=(empty($itemparams['container']['attrs']['class'])?'':' ').'anav-item';
									$itemparams['class'].=(empty($itemparams['class'])?'':' ').'anav-a';
									if ($itemparams['active'])
										{
											$itemparams['class'].=' anav-a-active';
											if (!empty($sm['adminnavigation']['item_a_class_active']))
												$itemparams['class'].=' '.$sm['adminnavigation']['item_a_class_active'];
										}
									$itemparams['html']=$itemparams['title'];
									if (!empty($itemparams['fa']))
										$itemparams['html']='<span class="anav-fa">'.FA::EmbedCodeFor($itemparams['fa']).'</span> '.$itemparams['html'];
									$itemparams['attrs']['style']=$itemparams['style'];
									$itemparams['attrs']['onclick']=$itemparams['onclick'];
									$itemparams['attrs']['class']=$itemparams['class'];
								}
							$items=Array();
							foreach ($this->nav['items'] as $itemname=>&$itemparams)
								{
									$items[]=$itemparams;
								}
							$this->nav['items']=$items;
						}
					$this->nav['count']=sm_count($this->nav['items']);
					return $this->nav;
				}
		}
