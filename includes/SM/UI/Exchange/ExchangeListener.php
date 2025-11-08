<?php

	//==============================================================================
	//#revision 2020-09-20
	//==============================================================================

	namespace SM\UI\Exchange;

	sm_add_jsfile('ext/smuiexchange.js', true);

	/**
	 * Class ExchangeListener
	 *
	 *    Alows to generata javascript code for listen messages from ExchangeSender.
	 *    When message arrived, it will be scanned for ID/Value pairs,
	 *    Each value will be assigned for DOM-element with ID received.
	 */
	class ExchangeListener
		{
			protected $info;

		/**
		 * ExchangeListener constructor.
		 * @param mixed $listener_id - use NULL for using sm_pageid() as listener ID
		 */
			function __construct($listener_id = NULL)
				{
					if ($listener_id === NULL)
						$listener_id = sm_pageid();
					$this->info['id'] = $listener_id;
					$this->info['fields'] = Array();
				}

		/**
		 * Ad an element to listen.
		 * @param $id - DOM-element identoifier
		 * @return $this
		 */
			function Add($id)
				{
					if (!in_array($id, $this->info['fields']))
						$this->info['fields'][] = $id;
					return $this;
				}

		/**
		 * @return string - javascript code for listener
		 */
			function GetJSCode()
				{
					$js = "sm_ls_init_listener('".$this->info['id']."');";
					for ($i = 0; $i < sm_count($this->info['fields']); $i++)
						{
							$js .= "sm_ls_add_listen_key('".$this->ListenerID()."', '".$this->info['fields'][$i]."');";
						}
					return $js;
				}

		/**
		 * @return string - listener ID (initiated in __construct)
		 */
			function ListenerID()
				{
					return $this->info['id'];
				}
		}
