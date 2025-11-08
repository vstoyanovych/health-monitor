<?php

	//------------------------------------------------------------------------------
	//|                                                                            |
	//|            Content Management System SiMan CMS                             |
	//|                                                                            |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#revision 2020-09-20
	//==============================================================================

	if (!defined("admininterface_DEFINED"))
		{
			/** @deprecated  */
			class TGenericInterface extends \SM\UI\GenericInterface
				{
				}

			/** @deprecated  */
			class TInterface extends \SM\UI\UI
				{
				}

			/** @deprecated  */
			class TPanel extends \SM\UI\Panel
				{
				}

			define("admininterface_DEFINED", 1);
		}
