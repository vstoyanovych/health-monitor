<?php

	include_once 'includes/mailjet.php';

	use ParseRoute\Route as MailJet;
	use SM\Common\Redirect;
	use SM\SM;
	use SM\UI\Form;
	use SM\UI\Grid;
	use SM\UI\UI;

	if (SM::isLoggedIn() && SM::User()->Level() == 3)
		{
			sm_default_action('view');

			sm_add_body_class('template_categories templates_section');

			if (!System::HasMailjetApiKey())
				Redirect::To('index.php?m=dashboard');

			if (sm_action('getdns'))
				{
					$apikey = System::MailjetApiKey();
					$apisecret = System::MailjetApiSecret();

					$mail = new MailJet($apikey, $apisecret);
					$routeInfo = $mail->getDNS();

					print_r($routeInfo);
				}

			if (sm_action('getsenders'))
				{
					$apikey = System::MailjetApiKey();
					$apisecret = System::MailjetApiSecret();

					$mail = new MailJet($apikey, $apisecret);
					$routeInfo = $mail->senders();

					print_r($routeInfo);
				}

			if (sm_action('getroutes'))
				{
					$apikey = System::MailjetApiKey();
					$apisecret = System::MailjetApiSecret();

					$mail = new MailJet($apikey, $apisecret);
					$routeInfo = $mail->getRoutes();
					print_r($routeInfo);
				}

			if (sm_action('postaddemail'))
				{
					if (empty(trim($_postvars['sender_email'])))
						$error_message = 'Fill required fields';
					elseif (empty(System::EmailDomain()))
						$error_message = 'Domain is empty';
					elseif (!System::isEmailActive())
						$error_message = 'Domain name wasn\'t activated yet';

					$domain = trim(SM::POST('sender_email')->AsString()) . '@' . System::EmailDomain();

					if ( empty($error_message) && ( !System::HasEmailParseRouteURL() || !System::HasEmailParseRouteID()) )
						{
							$apikey = System::MailjetApiKey();
							$apisecret = System::MailjetApiSecret();

							$mail = new MailJet($apikey, $apisecret);
							$webhookURL = sm_homepage() . 'index.php?m=receivemailjetwebhook';
							$routeInfo = $mail->addRoute($domain, $webhookURL);
							if ($routeInfo && is_array($routeInfo) && isset($routeInfo['Data'][0]['ID']))
								{
									// route added successfully
									$route_id = $routeInfo['Data'][0]['ID'];
									System::SetEmailParseRouteID($route_id);
									System::SetEmailParseRouteURL($routeInfo['Data'][0]['Url']);

									// if route added succesfully then change the status of verification in db
									$senderDetails = $mail->getSender(System::EmailDomainID());
									if (isset($senderDetails['Data'][0]['Status']))
										System::SetEmailStatus($senderDetails['Data'][0]['Status']);

									sm_notify('Domain has been verified.');
								}
							elseif ($routeInfo && !is_array($routeInfo))
								{
									// set error msg recived from mail jet
									$error_message = $routeInfo;
								}
						}
					elseif ( empty($error_message) && ( System::HasEmailParseRouteURL() || System::HasEmailParseRouteID()) && $domain != System::EmailFrom())
						{
							$apikey = System::MailjetApiKey();
							$apisecret = System::MailjetApiSecret();


							$mail = new MailJet($apikey, $apisecret);
							$webhookURL = sm_homepage() . 'index.php?m=receivemailjetwebhook';
							$routeInfo = $mail->updateRoute(System::EmailParseRouteID(), $webhookURL, $domain);
						}

					if ( empty($error_message) )
						{
							System::SetEmailFrom($domain);
							sm_notify('Email has been added.');
							sm_redirect('index.php?m=' . sm_current_module());
						}
					else
						sm_set_action('editemail');
				}

			if (sm_action('postdelete'))
				{
					$error_message = '';

					$apikey = System::MailjetApiKey();
					$apisecret = System::MailjetApiSecret();

					if ( $apikey && $apisecret )
						{
							if (System::HasEmailDomainID())
								{
									$mail = new MailJet($apikey, $apisecret);
									$deleteSender = $mail->deleteSender(System::EmailDomainID());
									if (System::HasEmailParseRouteID())
										$mail->deleteRoute(System::EmailParseRouteID());

									System::SetEmailDnsID('');
									System::SetEmailDomainID('');
									System::SetEmailStatus('');
									System::SetEmailDomain('');
									System::SetEmailOwnerShipToken('');
									System::SetEmailOwnerShipTokenRecordName('');
									System::SetEmailParseRouteID('');
									System::SetEmailParseRouteURL('');
									System::SetEmailSPFRecordValue('');
									System::SetEmailDKIMRecordName('');
									System::SetEmailDKIMRecordValue('');
									System::SetEmailSPFRecordStatus('');
									System::SetEmailDKIMRecordStatus('');

									sm_notify('Domain has been deleted.');
									sm_redirect('index.php?m=' . sm_current_module());
								}
							else
								$error_message = "Domain does not exist";

							Redirect::To(SM::GET('returnto')->AsString());

						}
					else
						$error_message = "API key not found";

					sm_set_action('view');
				}

			if (sm_action('verifydns'))
				{
					$error_message = '';

					if (System::HasEmailDomainID())
						{
							$apikey = System::MailjetApiKey();
							$apisecret = System::MailjetApiSecret();

							$mail = new MailJet($apikey, $apisecret);
							$result = $mail->validateSender(System::EmailDomainID());

							if ( $mail->HasError() && $mail->ErrorMessage() != 'The sender is already active!')
								$error_message = $mail->ErrorMessage();

							if (empty($error_message))
								{
									$dnsInfo = $mail->dns_check(System::EmailDnsID());
									if ( is_array($dnsInfo) )
										{
											if ( strtolower($dnsInfo['Data'][0]['DKIMStatus']) != 'ok' )
												$error_message = 'DKIM validation failed. Check your CNAME record';
											else
												System::SetEmailDKIMRecordStatus($dnsInfo['Data'][0]['DKIMStatus']);

											if ( strtolower($dnsInfo['Data'][0]['SPFStatus']) != 'ok' )
												$error_message = 'SPF validation failed. Check your TXT record';
											else
												System::SetEmailSPFRecordStatus($dnsInfo['Data'][0]['SPFStatus']);
										}
									else
										$error_message = $dnsInfo;

								}
						}
					else
						$error_message = 'Domain Record Does not exist.';

					if ( empty($error_message) )
						{
							sm_notify('Domain was added');
							System::SetEmailStatus('Active');
							sm_redirect('index.php?m='.sm_current_module().'&d=editemail');
						}
					else
						sm_set_action('view');
				}


			if (sm_action('postadd'))
				{
					$error_message = '';

					$_postvars['domain'] = trim(SM::POST('domain')->AsString());

					if (System::HasEmailDomain())
						$error_message = 'Already One Domain Exist!';

					if (empty($_postvars['domain']))
						$error_message = 'Fill required fields';

					if (empty($error_message))
						$error_message = url_validator($_postvars['domain']);

					if (empty($error_message))
						{
							$apikey = System::MailjetApiKey();
							$apisecret = System::MailjetApiSecret();

							$mail = new MailJet($apikey, $apisecret);
							$domainEmail = '*@' . trim($_postvars['domain']);
							$result = $mail->create('', $domainEmail);

							if ( is_array($result) )
								{
									System::SetEmailDnsID($result['Data'][0]['DNSID']);
									System::SetEmailDomainID($result['Data'][0]['ID']);
									System::SetEmailStatus($result['Data'][0]['Status']);
									$dnsInfo = $mail->dns(System::EmailDnsID());

									if ( is_array($dnsInfo) )
										{
											System::SetEmailDomain($dnsInfo['Data'][0]['Domain']);
											System::SetEmailSPFRecordValue($dnsInfo['Data'][0]['SPFRecordValue']);
											System::SetEmailSPFRecordStatus($dnsInfo['Data'][0]['SPFStatus']);
											System::SetEmailDKIMRecordName($dnsInfo['Data'][0]['DKIMRecordName']);
											System::SetEmailDKIMRecordValue($dnsInfo['Data'][0]['DKIMRecordValue']);
											System::SetEmailDKIMRecordStatus($dnsInfo['Data'][0]['DKIMStatus']);
											System::SetEmailOwnerShipToken($dnsInfo['Data'][0]['OwnerShipToken']);
											System::SetEmailOwnerShipTokenRecordName($dnsInfo['Data'][0]['OwnerShipTokenRecordName']);

											sm_notify('Domain has been added.');
											Redirect::To(SM::GET('returnto')->AsString());
										}
									else
										$error_message = $dnsInfo;
								}
							elseif ($result == 'There is an already existing inactive sender with the same email. You can use "validate" action in order to activate it.' ||  strpos($result, 'Email already exists') !== false)
								{
									$senderInfo = $mail->senders();
									foreach ($senderInfo['Data'] as $sender)
										{
											if ($sender['Email'] == $domainEmail)
												{
													System::SetEmailDnsID($sender['DNSID']);
													System::SetEmailDomainID($sender['ID']);
													System::SetEmailStatus($sender['Status']);

													$dnsInfo = $mail->dns($sender['DNSID']);
													System::SetEmailDomain($dnsInfo['Data'][0]['Domain']);
													System::SetEmailSPFRecordValue($dnsInfo['Data'][0]['SPFRecordValue']);
													System::SetEmailSPFRecordStatus($dnsInfo['Data'][0]['SPFStatus']);
													System::SetEmailDKIMRecordName($dnsInfo['Data'][0]['DKIMRecordName']);
													System::SetEmailDKIMRecordValue($dnsInfo['Data'][0]['DKIMRecordValue']);
													System::SetEmailDKIMRecordStatus($dnsInfo['Data'][0]['DKIMStatus']);
													System::SetEmailOwnerShipToken($dnsInfo['Data'][0]['OwnerShipToken']);
													System::SetEmailOwnerShipTokenRecordName($dnsInfo['Data'][0]['OwnerShipTokenRecordName']);
												}
										}
									System::SetEmailFrom('');
									sm_notify('Domain has been added.');
									Redirect::To(SM::GET('returnto')->AsString());
								}
							elseif ($result == 'There is an already existing deleted sender with the same email. You can use "validate" action in order to activate it.')
								{
									$senderInfo = $mail->sendersDeleted();
									foreach ($senderInfo['Data'] as $sender)
										{
											if ($sender['Email'] == $domainEmail)
												{
													System::SetEmailDnsID($sender['DNSID']);
													System::SetEmailDomainID($sender['ID']);
													System::SetEmailDomain(str_replace('*@', '', $sender['Email']));
													$result = $mail->validateSender(System::EmailDomainID());
													System::SetEmailStatus('Active');
												}
										}
									System::SetEmailFrom('');
									sm_notify('Domain has been added.');
									sm_redirect('index.php?m='.sm_current_module().'&d=editemail');
								}
							else
								$error_message = $result;
						}

					if (!empty($error_message))
						sm_set_action('view');
				}

			if (sm_action('editemail'))
				{
					global $pb;

					sm_title('Edit Email');

					add_path_home();

					add_path_current();

					sm_use('ui.interface');
					sm_use('ui.grid');

					$ui = new UI();

					$ui->html('<div class="additional-buttons-section extended-buttons">');

					$ui->html('<div class="pipeline-dropdown"></div>');
					$ui->html('<div class="buttons flex">');
					$ui->AddTPL('businesssettingsbuttons.tpl', $pb['business_settings_buttons']);

					$ui->html('</div>');
					$ui->html('</div>');

					$ui->div_open('', 'card rounded-md bg-white w-full shadow-base p-4');

					if (!empty($error_message))
						$ui->NotificationError($error_message);

					$ui->h('4', 'Add Sender Email');
					sm_use('ui.form');
					$f = new Form('index.php?m=' . sm_current_module() . '&d=postaddemail&returnto=' . SM::GET('returnto')->UrlencodedString());
					$f->AddText('sender_email', 'Sender Email', true);

					if (System::HasEmailDomain() && strpos(System::EmailFrom(), '@'.System::EmailDomain()) !== false)
						$f->SetValue('sender_email', str_replace('@'.System::EmailDomain(), '', System::EmailFrom()));

					$f->SetFieldEndText('sender_email', '@' . System::EmailDomain());
					$f->LoadValuesArray($_postvars);
					$ui->AddForm($f);
					$ui->style('#sender_email {width:60%;}');
					$ui->div_close();
					$ui->Output(true);
				}

			if (sm_action('view'))
				{
					global $pb;
					
					sm_title('Domain');

					add_path_home();
					if (SM::GET('type')->AsString() == 'system')
						add_path('Control Panel', 'index.php?m=sacabinet');
					add_path_current();

					sm_use('ui.interface');
					sm_use('ui.grid');
					sm_use('ui.buttons');

					$ui = new UI();
					$ui->AddTPL('settings_header.tpl', '', ['current_action' => 'sendingdomain']);

					$ui->div_open('', 'card rounded-md bg-white w-full shadow-base p-4');
					if (!empty($error_message))
						$ui->NotificationError($error_message);

					if (!System::HasEmailDomain())
						{
							$ui->h('4', 'Add Domain');
							sm_use('ui.form');
							$f = new Form('index.php?m=' . sm_current_module() . '&d=postadd&returnto=' . urlencode('index.php?m='.sm_current_module().'&d=view'));
							$f->AddText('domain', 'Domain', true)->SetFieldBottomText('domain', 'Enter only domain name without http or www For example: google.com')->SetFocus();

							if (is_array($_postvars) && count($_postvars) > 0 )
								$f->LoadValuesArray($_postvars);

							$ui->AddForm($f);
						}
					elseif (System::EmailStatus() != 'Active')
						{
							// if email status is not active then show verify page with dns details

							$ui->h('4', 'Create TXT DNS Record');
							$ui->p('If you manage ' . System::EmailDomain() . ' and you have access to your DNS records, you can create a  new TXT record with the following values.');
							$t = new Grid();
							$t->AddCol('key', 'Key');
							$t->AddCol('value', 'Value');

							$t->Label('key', 'Host name');
							$t->Label('value', System::EmailOwnerShipTokenRecordName());
							$t->NewRow();
							$t->Label('key', 'Value');
							$t->Label('value', System::EmailOwnerShipToken());
							$t->NewRow();
							$ui->AddGrid($t);

							$ui->h('4', 'Create TXT DNS Record');

							$t = new Grid();
							$t->AddCol('key', 'Key');
							$t->AddCol('value', 'Value');

							$t->Label('key', 'Host name');
							$t->Label('value', System::EmailDomain().'.');
							$t->NewRow();
							$t->Label('key', 'Value');
							$t->Label('value', System::EmailSPFRecordValue());
							$t->NewRow();
							$ui->AddGrid($t);

							$ui->h('4', 'Create TXT DNS Record');

							$t = new Grid();
							$t->AddCol('key', 'Key');
							$t->AddCol('value', 'Value');

							$t->Label('key', 'Host name');
							$t->Label('value', System::EmailDKIMRecordName());
							$t->NewRow();
							$t->Label('key', 'Value');
							$t->Label('value', System::EmailDKIMRecordValue());
							$t->CellAddStyle('value', 'word-break: break-all;');
							$t->NewRow();
							$ui->AddGrid($t);

							$ui->h('4', 'Create MX DNS Record');
							$ui->p('Add an MX entry on the domain or subdomain DNS to receive emails on your own domain name');
							$t = new Grid();
							$t->AddCol('key', 'Key');
							$t->AddCol('value', 'Value');

							$t->Label('key', 'Host name');
							$t->Label('value', System::EmailDomain());
							$t->NewRow();
							$t->Label('key', 'Value');
							$t->Label('value', '10 parse.mailjet.com. (final dot is important)');
							$t->NewRow();

							$t->SingleLineLabel('<img src="themes/default/images/gdomainexample.jpg" style="max-width:800px;"/>');
							$t->NewRow();

							$ui->AddGrid($t);
							$ui->html('<div class="flex gap-10">');
							$ui->a('index.php?m=' . sm_current_module() . '&d=verifydns&returnto=' . urlencode(sm_this_url()), 'Verify', '', 'ab-button');
							$ui->a('index.php?m=' . sm_current_module() . '&d=postdelete&returnto=' . urlencode(sm_this_url()), 'Delete', '', 'ab-button', '', " return confirm('Are you sure?')");
							$ui->html('</div>');
						}
					elseif (System::EmailStatus() == 'Active' && !System::HasEmailFrom())
						Redirect::To('index.php?m='.sm_current_module().'&d=editemail');
					else
						{
							$ui->h('4', 'Domain Details');
							$t = new Grid();
							$t->AddCol('email', 'Email');
							$t->AddCol('domain', 'Sender Domain');
							$t->AddEdit();
							$t->AddDelete();

							$t->Label('email', System::EmailFrom());
							$t->Label('domain', System::EmailDomain());
							$t->URL('edit', 'index.php?m=' . sm_current_module() . '&d=editemail&id=&returnto=' . urlencode(sm_this_url()));
							$t->URL('delete', 'index.php?m=' . sm_current_module() . '&d=postdelete&id=&returnto=' . urlencode(sm_this_url()));

							$ui->AddGrid($t);
						}
					$ui->div_close();
					$ui->Output(true);
				}
		}
	else
		Redirect::Now('index.php?m=dashboard');