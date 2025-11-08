<?php

	//------------------------------------------------------------------------------
	//|            Content Management System SiMan CMS                             |
	//|              http://simancms.apserver.org.ua                               |
	//------------------------------------------------------------------------------

	//==============================================================================
	//#ver 1.6.19
	//#revision 2020-09-20
	//==============================================================================

	use SM\SM;

	if (!defined("SIMAN_DEFINED"))
		exit('Hacking attempt!');

	if (!defined("ACCOUNT_MEMBERS_PRIVMSG_FUNCTIONS_DEFINED"))
		{
			function siman_get_userid_by_name($name)
				{
					$sql = "SELECT * FROM ".sm_global_table_prefix()."users WHERE lower(login)=lower('".dbescape($name)."') LIMIT 1";
					$result = execsql($sql);
					$id = 0;
					while ($row = database_fetch_object($result))
						{
							$id = $row->id_user;
						}
					return $id;
				}

			function siman_get_privmsgcount($user)
				{
					$result['inbox']['all'] = 0;
					$result['inbox']['unread'] = 0;
					$result['outbox']['all'] = 0;
					$sql = "SELECT count(*), sum(unread_privmsg), sum(folder_privmsg) FROM ".sm_global_table_prefix()."privmsg WHERE folder_privmsg=1 AND id_sender_privmsg=$user OR folder_privmsg=0 AND id_recipient_privmsg=$user";
					$rezult = execsql($sql);
					while ($row = database_fetch_row($rezult))
						{
							$result['inbox']['all'] = $row[0];
							$result['inbox']['unread'] = $row[1];
							$result['outbox']['all'] = $row[2];
						}
					return $result;
				}

			define("ACCOUNT_MEMBERS_PRIVMSG_FUNCTIONS_DEFINED", 1);
		}

	if (sm_settings('allow_private_messages') == 1 && !empty($userinfo['id']))
		{
			if (sm_action('viewprivmsg'))
				{
					sm_page_viewid('account-viewprivmsg');
					sm_template('account');
					if (SM::GET('folder')->isEmpty())
						SM::GET('folder')->SetValue('inbox');
					$m["privmsg_folder"] = sm_getvars('folder');
					$tmp_folder = sm_getvars('folder');
					if (strcmp($tmp_folder, 'outbox') == 0)
						{
							sm_title($lang['module_account']['outbox']);
							$tmp_filter = ' folder_privmsg=1 AND id_sender_privmsg='.intval($userinfo['id']);
						}
					if (empty($tmp_filter))
						{
							sm_title($lang['module_account']['inbox']);
							$tmp_filter = ' folder_privmsg=0 AND id_recipient_privmsg='.intval($userinfo['id']);
							$tmp_folder = 'inbox';
						}
					if (empty($tmp_filter))
						$tmp_filter='1=2';
					$sql = "SELECT * FROM ".sm_global_table_prefix()."privmsg, ".sm_global_table_prefix()."users ";
					if (strcmp($tmp_folder, 'outbox') == 0)
						$sql .= " WHERE ".sm_global_table_prefix()."privmsg.id_sender_privmsg=".sm_global_table_prefix()."users.id_user";
					else
						$sql .= " WHERE ".sm_global_table_prefix()."privmsg.id_recipient_privmsg=".sm_global_table_prefix()."users.id_user";
					$sql .= ' AND '.$tmp_filter;
					$sql .= ' ORDER BY time_privmsg DESC ';
					sm_use('admintable');
					$t = new \SM\UI\Grid('edit');
					$t->AddCol('ico', '', '16');
					$t->AddCol('title', $lang['common']['title'], '80%');
					$t->AddCol('time', $lang['module_account']['sent'], '10%');
					$t->AddCol('user', $lang['user'], '10%');
					$t->AddDelete();
					$result = execsql($sql);
					$i = 0;
					while ($row = database_fetch_object($result))
						{
							if ($row->folder_privmsg == 0 && $row->unread_privmsg == 1)
								$t->Image('ico', 'newmessage.gif');
							else
								$t->Image('ico', 'message.gif');
							$t->Label('title', $row->theme_privmsg);
							$t->URL('title', 'index.php?m=account&d=readprivmsg&id='.$row->id_privmsg.'&folder='.$tmp_folder);
							$t->Label('user', $row->login);
							$t->Label('time', date(sm_datetime_mask(), $row->time_privmsg));
							$t->URL('delete', 'index.php?m=account&d=postdeleteprivmsg&id='.$row->id_privmsg.'&folder='.$tmp_folder);
							$t->NewRow();
							$i++;
						}
					if ($t->RowCount()===0)
						$t->SingleLineLabel($lang['messages']['nothing_found']);
					$m['table'] = $t->Output();
				}
			if (sm_action('postsendprivmsg'))
				{
					sm_template('account');
					sm_title($lang['module_account']['send_message']);
					$m['data']['recipient'] = htmlescape(sm_postvars('p_recipient'));
					$m['data']['theme'] = htmlescape(sm_postvars('p_theme'));
					$m['data']['text'] = htmlescape(sm_postvars('p_text'));
					if (empty(sm_postvars('p_recipient')))
						{
							$m['mode'] = 'sendprivmsg';
							$m['error_message'] = $lang['module_account']['error_message_recipient'];
						}
					elseif (empty(sm_postvars('p_theme')) || empty(sm_postvars('p_text')))
						{
							$m['mode'] = 'sendprivmsg';
							$m['error_message'] = $lang['module_account']['error_message_theme_text'];
						}
					elseif (siman_get_userid_by_name(dbescape(sm_postvars('p_recipient'))) < 1)
						{
							$m['mode'] = 'sendprivmsg';
							$m['error_message'] = $lang['module_account']['error_message_recipient'];
						}
					else
						{
							$id_sender_privmsg = $userinfo['id'];
							$id_recipient_privmsg = siman_get_userid_by_name(dbescape(sm_postvars('p_recipient')));
							$folder_privmsg = 0;
							$unread_privmsg = 1;
							$theme_privmsg = dbescape(sm_postvars('p_theme'));
							$body_privmsg = dbescape(sm_postvars('p_text'));
							$time_privmsg = time();
							$sql = "INSERT INTO ".sm_global_table_prefix()."privmsg (`id_sender_privmsg`, `id_recipient_privmsg`, `folder_privmsg`, `unread_privmsg`, `theme_privmsg`, `body_privmsg`, `time_privmsg`) VALUES('$id_sender_privmsg', '$id_recipient_privmsg', '$folder_privmsg', '$unread_privmsg', '$theme_privmsg', '$body_privmsg', '$time_privmsg')";
							$result = execsql($sql);
							$folder_privmsg = 1;
							$unread_privmsg = 0;
							$sql = "INSERT INTO ".sm_global_table_prefix()."privmsg (`id_sender_privmsg`, `id_recipient_privmsg`, `folder_privmsg`, `unread_privmsg`, `theme_privmsg`, `body_privmsg`, `time_privmsg`) VALUES('$id_sender_privmsg', '$id_recipient_privmsg', '$folder_privmsg', '$unread_privmsg', '$theme_privmsg', '$body_privmsg', '$time_privmsg')";
							$result = execsql($sql);
							log_write(LOG_USEREVENT, $lang['module_account']['log']['user_send_privmsg']);
							sm_redirect('index.php?m=account&d=viewprivmsg&folder=inbox');
						}
				}
			if (sm_action('sendprivmsg'))
				{
					sm_page_viewid('account-sendprivmsg');
					sm_template('account');
					sm_title($lang['module_account']['send_message']);
					$m['data']['recipient'] = htmlescape(sm_postvars('p_recipient'));
					$m['data']['theme'] = htmlescape(sm_postvars('p_theme'));
					$m['data']['text'] = htmlescape(sm_postvars('p_text'));
				}
			if (sm_action('readprivmsg'))
				{
					sm_page_viewid('account-readprivmsg');
					sm_template('account');
					sm_title($lang['module_account']['read_message']);
					if (SM::GET('folder')->isEmpty())
						SM::GET('folder')->SetValue('inbox');
					$tmp_folder = sm_getvars('folder');
					$m["folder_privmsg"] = sm_getvars('folder');
					$sql = "SELECT * FROM ".sm_global_table_prefix()."privmsg, ".sm_global_table_prefix()."users ";
					if (strcmp($tmp_folder, 'outbox') == 0)
						$sql .= " WHERE ".sm_global_table_prefix()."privmsg.id_recipient_privmsg=".sm_global_table_prefix()."users.id_user AND id_sender_privmsg=".intval($userinfo['id']);
					else
						$sql .= " WHERE ".sm_global_table_prefix()."privmsg.id_sender_privmsg=".sm_global_table_prefix()."users.id_user AND id_recipient_privmsg=".intval($userinfo['id']);
					$tmp_filter = ' id_privmsg='.intval(sm_getvars('id'));
					$sql .= ' AND '.$tmp_filter;
					$result = execsql($sql);
					$i = 0;
					while ($row = database_fetch_object($result))
						{
							$m['message']['id'] = $row->id_privmsg;
							$m['message']['theme'] = $row->theme_privmsg;
							$m['message']['body'] = nl2br($row->body_privmsg);
							$m['message']['time'] = date(sm_datetime_mask(), $row->time_privmsg);
							$m['message']['user'] = $row->login;
							$m['message']['rebody'] = "-------------------\n&gt; ".str_replace("\n", "\n&gt; ", $row->body_privmsg);
							$i++;
						}
					if ($i == 1)
						{
							$sql = " UPDATE ".sm_global_table_prefix()."privmsg SET unread_privmsg=0 WHERE id_privmsg=".intval(sm_getvars('id'));
							$result = execsql($sql);
						}
				}
			if (sm_action('postdeleteprivmsg'))
				{
					execsql("DELETE FROM ".sm_global_table_prefix()."privmsg WHERE id_privmsg=".intval(sm_getvars('id'))." and (folder_privmsg=1 and id_sender_privmsg=".intval($userinfo['id'])." or folder_privmsg=0 and id_recipient_privmsg=".intval($userinfo['id']).")");
					sm_redirect('index.php?m=account&d=viewprivmsg&folder='.sm_getvars('folder'));
				}
		}
	