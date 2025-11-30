<?php

    class FileValidator{

        var $rules = [];
        var $file = '';
        var $error_messages = [];

        public function __construct($file){
            $this->file = $file;
        }

        /*
         * $rules = [
         *  'max_file_size' => [
         *      'value' => '10',
         *      'error_message' => 'Exceeded filesize limit. Max file size is: :value'
         *  ]
         *  'allowed_ext' => [
         *      'value' => ['png', 'gif'],
         *      'error_message' => 'Allowed file type: :value. :current given'
         *  ]
         * ]
         * */

        private function prepareErrorMessage($message, $value, $current_value = false){

            if(is_array($value)) $value = implode(', ', $value);

            $str = str_replace(':value', $value, $message);

            if($current_value){
                if(is_array($current_value)) $current_value = implode(', ', $current_value);
                $str = str_replace(':current', $current_value, $str);
            }

            return $str;
        }

        public function setRules($rules = []){

            if(isset($rules['max_file_size'])){
                $rule = $rules['max_file_size'];

                $rule['value'] = $rule['value'] * 1024 * 1024;

                if ($this->file['size'] > $rule['value']) {
                    $rule['value'] = ($rule['value'] / 1024 / 1024).'MB';
                    $this->errors[] = $this->prepareErrorMessage($rule['error_message'], $rule['value']);
                }
            }

            if(isset($rules['allowed_ext'])){
                $rule = $rules['allowed_ext'];

                if(!is_array($rule['value']) || empty($rule['value'])) return;

                $ext = end(explode(".", $this->file['name']));

                $rule['value'] = array_map(function($v){
                    return strtolower($v);
                }, $rule['value']);

                if (!in_array($ext, $rule['value'])) {
                    $this->errors[] =  $this->prepareErrorMessage($rule['error_message'], $rule['value'], $ext);
                }
            }
        }

        public function getErrors(){
            return $this->errors;
        }

        public function hasErrors(){
            return count($this->errors) > 0;
        }

			public static function isImage($filetype)
				{
					$supported_types = Array(
						'image/jpeg',
						'image/gif',
						'image/png'
					);
					return in_array($filetype, $supported_types);
				}
    }