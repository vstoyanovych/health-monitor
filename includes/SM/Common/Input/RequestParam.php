<?php


	namespace SM\Common\Input;

	class RequestParam
		{
			private $current_request;
			private $param_name;

			function __construct(&$request_array, $request_param_name)
				{
					$this->current_request=&$request_array;
					$this->param_name=$request_param_name;
				}

			protected function RawValue()
				{
					return isset($this->current_request[$this->param_name]) ? $this->current_request[$this->param_name] : NULL;
				}

			function AsString()
				{
					return (string)$this->RawValue();
				}

			function AsStringOrDefault($default)
				{
					$str=$this->AsString();
					if (empty($str))
						return $default;
					else
						return $str;
				}

			function UrlencodedString()
				{
					return urlencode($this->AsString());
				}

			function EscapedString()
				{
					return htmlescape($this->AsString());
				}

			function isStringEqual($string_to_compare)
				{
					return strcmp($this->AsString(), $string_to_compare)===0;
				}

			function AsFloat()
				{
					return floatval($this->RawValue());
				}

			function AsInt()
				{
					return intval($this->RawValue());
				}

			function AsAbsInt()
				{
					return abs($this->AsInt());
				}

			function AsArray()
				{
					if ($this->RawValue()===NULL)
						return [];
					elseif (!is_array($this->RawValue()))
						return [$this->RawValue()];
					else
						return $this->RawValue();
				}

			function Exists()
				{
					return array_key_exists($this->param_name, $this->current_request);
				}

			function SetValue($new_value)
				{
					$this->current_request[$this->param_name]=$new_value;
				}

			function isEmpty()
				{
					return empty($this->RawValue());
				}

		}
