<?php

	namespace SM\Common\Output;

	class PageGeneration
		{

			public static function SetPrintMode()
				{
					global $special;
					$special['printmode'] = 'on';
					$special['main_tpl'] = 'indexprint';
				}

			public static function SetOutputMainBlockOnly()
				{
					global $special;
					$special['main_tpl']='theonepage';
					$special['no_blocks']=true;
					$special['no_borders_main_block']=true;
				}

		}
