<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	if (!defined("EXTEDITOR_FUNCTIONS_DEFINED"))
		{
			function siman_prepare_to_exteditor($str)
				{
					return $str;
				}

			function siman_exteditor_insert_image($image)
				{
					return "tinyMCE.execCommand('mceInsertContent',false,'<img src=\\'".jsescape($image)."\\'>')";
				}

			function siman_exteditor_insert_html($html)
				{
					return "tinyMCE.execCommand('mceInsertContent',false,'".jsescape($html)."')";
				}

			$sm['tinymce5_1_6_default_params']=',menubar: false, plugins: [
				\'assistant advlist autolink lists link image charmap print preview anchor\',
				\'searchreplace visualblocks code fullscreen\',
				\'insertdatetime media table paste code help wordcount\'
			  ],
			  toolbar: \'undo redo | formatselect | \' +
			  \' assistant bold italic strikethrough | image link | bullist numlist outdent indent\' +
			  \'  | alignleft aligncenter alignright alignjustify |\' +
			  \' backcolor | removeformat | fontsizeselect | fontselect | help\'';

			define("EXTEDITOR_FUNCTIONS_DEFINED", 1);
		}

