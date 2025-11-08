<?php

	//==============================================================================
	//#revision 2019-09-20
	//==============================================================================

	namespace SM\UI;

	class UI extends GenericInterface
		{
			function Output($replace_template=false)
				{
					global $modules, $modules_index;
					if ($replace_template)
						{
							sm_template('common_admininterface');
							sm_set_action('common_admininterface_launcher');
							$modules[$modules_index]['common_admininterface_output']=$this->blocks;
							return $this->blocks;
						}
					else
						return $this->blocks;
				}
		}
