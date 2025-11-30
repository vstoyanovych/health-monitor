<?php

	//==============================================================================
	//#revision 2019-09-20
	//==============================================================================

	namespace SM\UI;


	sm_add_cssfile('common_admintabs.css');

	class Tabs extends GenericInterface
		{
			var $activeindex;
			protected static $tabs_index=0;
			protected $globaldata;

			function __construct($activeindex=0)
				{
					parent::__construct('', 0);
					$this->activeindex=$activeindex;
					$this->blocks[0]['globaldata']=[];
					$this->globaldata=&$this->blocks[0]['globaldata'];
					$this->globaldata['main_container']['attrs']['role']='tabpanel';
					$this->globaldata['main_content_container']['attrs']['class']='tab-content';
					$this->globaldata['tabs_container']['attrs']['class']='nav nav-tabs';
					$this->globaldata['tabs_container']['attrs']['role']='tablist';
					self::$tabs_index++;
				}

			private function Postfix()
				{
					return 'tabspfx'.self::$tabs_index;
				}

			function Tab($title, $tab_url='')
				{
					$this->AddBlock($title);
					if (!empty($tab_url))
						$this->blocks[$this->currentblock]['taburl']=$tab_url;
					$this->blocks[$this->currentblock]['postfix']=$this->Postfix();
					return $this;
				}

			function SetTitleForIndex($title, $index)
				{
					$this->blocks[$index]['title']=$title;
				}

			function TitleForIndex($index)
				{
					return $this->blocks[$index]['title'];
				}

			function SetActiveIndex($activeindex)
				{
					$this->activeindex=$activeindex;
				}

			function SetActiveIndexCurrent()
				{
					$this->activeindex=sm_count($this->blocks)-1;
					if ($this->activeindex==0)
						$this->activeindex=0;
				}

			function Output()
				{
					global $sm;
					$blocks=$this->blocks;
					$blocks[$this->activeindex]['active']=true;
					foreach ($blocks as $index=>&$data)
						{
							$data['tab_header_container']['attrs']['class']='at-tab-header-container';
							$data['tab_header_container']['attrs']['role']='presentation';
							if (!empty($sm['admintabs']['tab_header_container']['class']))
								$data['tab_header_container']['attrs']['class'].=' '.$sm['admintabs']['tab_header_container']['class'];
							if (isset($data['active']) && $data['active'])
								$data['tab_header_container']['attrs']['class'].=' active';
							//----------------------------------------------------------------------------------
							$data['tab_header_item']['attrs']['role']='tab';
							$data['tab_header_item']['attrs']['class']='at-tab-header-item';
							if (!empty($sm['admintabs']['tab_header_item']['class']))
								$data['tab_header_item']['attrs']['class'].=' '.$sm['admintabs']['tab_header_item']['class'];
							if (isset($data['active']) && $data['active'] && !empty($sm['admintabs']['tab_header_item']['active_item_class']))
								$data['tab_header_item']['attrs']['class'].=' '.$sm['admintabs']['tab_header_item']['active_item_class'];
							if (!empty($data['taburl']))
								$data['tab_header_item']['attrs']['href']=$data['taburl'];
							else
								{
									$data['tab_header_item']['attrs']['href']=sm_this_url().'#tab-'.$this->Postfix().'-'.$index;
									$data['tab_header_item']['attrs']['data-toggle']='tab';
									$data['tab_header_item']['attrs']['data-bs-toggle']='tab';
									$data['tab_header_item']['attrs']['data-bs-target']='#tab-'.$this->Postfix().'-'.$index;
								}
							$data['tab_header_item']['attrs']['aria-controls']='tab-'.$this->Postfix().'-'.$index;
							//----------------------------------------------------------------------------------
							$data['tab_content_container']['attrs']['tabpanel']='tabpanel';
							$data['tab_content_container']['attrs']['class']='tab-pane';
							if (isset($data['active']) && $data['active'])
								$data['tab_content_container']['attrs']['class'].=' active';
							$data['tab_content_container']['attrs']['id']='tab-'.$this->Postfix().'-'.$index;
							//----------------------------------------------------------------------------------
						}
					return $blocks;
				}
		}
