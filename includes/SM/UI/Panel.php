<?php

	//==============================================================================
	//#revision 2019-09-20
	//==============================================================================

	namespace SM\UI;

	class Panel extends GenericInterface
		{
			protected $params=Array();

			function __construct($width='', $height='', $style='', $class='', $id='')
				{
					parent::__construct('', 0);
					$this->params['width']=$width;
					$this->params['height']=$height;
					$this->params['style']=$style;
					$this->params['class']=$class;
					$this->params['id']=$id;
				}

			function AddClassnameGlobal($classname)
				{
					$this->params['class'].=(empty($this->params['class'])?'':' ').$classname;
					return $this;
				}

			function SetClassnameGlobal($classname)
				{
					$this->params['class']=$classname;
					return $this;
				}

			function Output()
				{
					$this->html('</div>');
					$this->InsertItemAtIndex(0);
					$style=$this->params['style'];
					if (!empty($this->params['width']))
						$style.='width:'.$this->params['width'].';';
					if (!empty($this->params['height']))
						$style.='height:'.$this->params['height'].';';
					$this->html('<div class="common_adminpanel'.(empty($this->params['class'])?'':' '.$this->params['class']).'" style="'.$style.'"'.(empty($this->params['id'])?'':' id="'.$this->params['id'].'"').'>');
					return $this->blocks;
				}
		}

