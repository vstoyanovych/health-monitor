<?php

	//==============================================================================
	//#revision 2020-09-20
	//==============================================================================

	namespace SM\UI;

	sm_add_cssfile('ext/tools/fontawesome/css/font-awesome.css', true);

	class FA
		{
			protected $icon='';
			protected $size='';

			function __construct()
				{
				}

			function SetIcon($iconkeyword)
				{
					if ($iconkeyword=='settings')
						$iconkeyword='gear';
					$this->icon=$iconkeyword;
					return $this;
				}

			function Size($sizekeyword)
				{
					$this->size=$sizekeyword;
					return $this;
				}

			function Code()
				{
					$str='<i class="fa fa-';
					$str.=$this->icon;
					if (!empty($this->size))
						$str.=' fa-'.$this->size;
					$str.='"></i>';
					return $str;
				}

			public static function Icon($iconkeyword)
				{
					$fa=new FA();
					$fa->SetIcon($iconkeyword);
					return $fa;
				}

			public static function EmbedCodeFor($iconkeyword)
				{
					$fa=new FA();
					$fa->SetIcon($iconkeyword);
					return $fa->Code();
				}
		}
