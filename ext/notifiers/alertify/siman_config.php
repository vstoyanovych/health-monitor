<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	if (!defined("NOTIFIER_FUNCTIONS_DEFINED"))
		{
			if (isset($sm['s']['notifications']) && is_array($sm['s']['notifications']))
				{
					sm_add_cssfile('ext/notifiers/alertify/themes/alertify.core.css', true);
					sm_add_cssfile('ext/notifiers/alertify/themes/alertify.default.css', true);
					sm_add_jsfile('ext/notifiers/alertify/lib/alertify.min.js', true);
					sm_html_bodyend('<script>(function() {alertify.set({ delay: 7000 });');
					foreach ($sm['s']['notifications'] as $key=>$val)
						{
							if (!empty($val['onpage']) && sm_strcmp($val['onpage'], sm_relative_url(sm_this_url()))!=0)
								continue;
							if (sm_strcmp($val['type'], 'error')==0)
								sm_html_bodyend('alertify.error("'.(empty($val['title'])?'':'<b>'.jsescape($val['title']).'<b><br />').jsescape($val['message']).'");');
							elseif (sm_strcmp($val['type'], 'info')==0)
								sm_html_bodyend('alertify.log("'.(empty($val['title'])?'':'<b>'.jsescape($val['title']).'<b><br />').jsescape($val['message']).'");');
							else
								sm_html_bodyend('alertify.success("'.(empty($val['title'])?'':'<b>'.jsescape($val['title']).'<b><br />').jsescape($val['message']).'");');
						}
					sm_html_bodyend('})();</script>');
				}
		}
