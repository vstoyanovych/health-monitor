<?php

	//==============================================================================
	//#revision 2020-09-20
	//==============================================================================

	namespace SM\UI\Exchange;

	sm_add_jsfile('ext/smuiexchange.js', true);

	/**
	 * Class ExchangeSender
	 *
	 * Provides an interface for sending messages to ExchangeListener
	 */
	class ExchangeSender
		{
			protected $info;

		/**
		 * ExchangeSender constructor.
		 * @param $listener_id - destination listener ID
		 */
			function __construct($listener_id)
				{
					$this->info['id'] = $listener_id;
					$this->info['fields'] = Array();
				}

		/**
		 * Send a value to listener.
		 * @param $id - destination DOM id from ExchangeListener::Add
		 * @param $value - DOM value. Keep in mind that it should be properly formatted for javascript code
		 * @return $this
		 */
			function Add($id, $value)
				{
					$this->info['fields'][$id] = $value;
					return $this;
				}

		/**
		 * Add a window.close(); for javascript code
		 * @return $this
		 */
			function SetCloseWindowRequest()
				{
					$this->info['close'] = true;
					return $this;
				}

		/**
		 * @return string - javascript code for sender
		 */
			function GetJSCode()
				{
					$js = '';
					foreach ($this->info['fields'] as $id => $val)
						{
							$js .= "sm_ls_send_to_listener('".$this->info['id']."', '".$id."', '".jsescape($val)."');";
						}
					if ($this->info['close'])
						$js .= 'window.close();';
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
