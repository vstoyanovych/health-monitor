<?php
	
	//------------------------------------------------------------------------------
	//|                                                                            |
	//|            Content Management System SiMan CMS                             |
	//|                                                                            |
	//------------------------------------------------------------------------------
	
	//==============================================================================
	//#revision 2020-09-20
	//==============================================================================

	if (!defined("ui_exchange_DEFINED"))
		{
			class TExchangeListener extends \SM\UI\Exchange\ExchangeListener
				{
				}

			class TExchangeSender extends \SM\UI\Exchange\ExchangeSender
				{
				}
			
			define("ui_exchange_DEFINED", 1);
		}
