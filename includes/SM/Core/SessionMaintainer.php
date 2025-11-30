<?php

	namespace SM\Core;

	class SessionMaintainer
		{

			public static function WriteNotificationsFor($destination_url)
				{
					global $sm;
					if (!empty($sm['session']['notifications']))
						for ($i = 0; $i < sm_count($sm['session']['notifications']); $i++)
							if (!empty($sm['session']['notifications'][$i]['frompage']) && strcmp(sm_relative_url($sm['session']['notifications'][$i]['frompage']), sm_relative_url(sm_this_url()))==0 && empty($sm['session']['notifications'][$i]['onpage']))
								$sm['session']['notifications'][$i]['onpage']=sm_relative_url($destination_url);
				}

		}
