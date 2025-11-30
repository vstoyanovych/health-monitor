<?php

	namespace SM\Common\Input;

	class RequestManager
		{
			function &POSTAsArray()
				{
					global $_postvars;
					if (!is_array($_postvars))
						$_postvars=[];
					return $_postvars;
				}

			function &GETAsArray()
				{
					global $_getvars;
					if (!is_array($_getvars))
						$_getvars=[];
					return $_getvars;
				}

			function SetGETParams($params_array_key_val)
				{
					global $_getvars;
					foreach ($params_array_key_val as $key=>$val)
						$_getvars[$key]=$val;
				}

		}
