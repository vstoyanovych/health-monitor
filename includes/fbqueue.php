<?php

	function fb_queue_link($employee, $id_page, $id_content, $url, $message, $picture = '', $title_link = '', $description_link = '', $caption_link = '', $scheduled_time=0)
		{
			/** @var $employee TEmployee */
			$q=new TQuery('fbqueue');
			$q->Add('id_employee', $employee->ID());
			$q->Add('id_page', intval($id_page));
			$q->Add('id_content', intval($id_content));
			$q->Add('service', dbescape('facebook'));
			$q->Add('scheduledtime', intval($scheduled_time));
			$q->Add('message', dbescape($message));
			$q->Add('url', dbescape($url));
			$q->Add('image', dbescape($picture));
			$q->Add('title', dbescape($title_link));
			$q->Add('description', dbescape($description_link));
			$q->Add('caption', dbescape($caption_link));
			$q->Insert();
		}

	function fb_queue_message($employee, $id_page, $message, $picture = '', $scheduled_time=0)
		{
			/** @var $employee TEmployee */
			$q=new TQuery('fbqueue');
			$q->Add('id_employee', intval($employee->ID()));
			$q->Add('id_company', intval($employee->CompanyID()));
			$q->Add('id_page', intval($id_page));
			$q->Add('service', dbescape('facebook'));
			$q->Add('scheduledtime', intval($scheduled_time));
			$q->Add('message', dbescape($message));
			$q->Add('image', dbescape($picture));
			$q->Insert();
		}

	function twitter_queue_link($employee, $id_content, $url, $message, $picture = '', $scheduled_time=0)
		{
			/** @var $employee TEmployee */
			$q=new TQuery('fbqueue');
			$q->Add('id_employee', intval($employee->ID()));
			$q->Add('id_company', intval($employee->CompanyID()));
			$q->Add('id_page', 0);
			$q->Add('id_content', intval($id_content));
			$q->Add('service', dbescape('twitter'));
			$q->Add('scheduledtime', intval($scheduled_time));
			$q->Add('message', dbescape($message));
			$q->Add('url', dbescape($url));
			$q->Add('image', dbescape($picture));//Temporary not realized
			$q->Insert();
		}

	function twitter_queue_message($employee, $message, $image = '', $scheduled_time=0)
		{
			/** @var $employee TEmployee */
			$q = new TQuery('fbqueue');
			$q->Add('id_employee', $employee->ID());
			$q->Add('id_company', $employee->CompanyID());
			$q->Add('id_page', 0);
			$q->Add('service', dbescape('twitter'));
			$q->Add('scheduledtime', intval($scheduled_time));
			$q->Add('message', dbescape($message));
			$q->Add('image', dbescape($image));
			$q->Insert();
		}

	function linkedin_queue_link($employee, $id_content, $url, $message, $picture = '', $title_link = '', $description_link = '', $scheduled_time=0)
		{
			/** @var $employee TEmployee */
			$q=new TQuery('fbqueue');
			$q->Add('id_employee', intval($employee->ID()));
			$q->Add('id_company', intval($employee->CompanyID()));
			$q->Add('id_page', 0);
			$q->Add('id_content', intval($id_content));
			$q->Add('service', dbescape('linkedin'));
			$q->Add('scheduledtime', intval($scheduled_time));
			$q->Add('message', dbescape($message));
			$q->Add('url', dbescape($url));
			$q->Add('image', dbescape($picture));
			$q->Add('title', dbescape($title_link));
			$q->Add('description', dbescape($description_link));
			$q->Insert();
		}

	function linkedin_queue_message($employee, $message, $picture = '', $scheduled_time=0)
		{
			/** @var $employee TEmployee */
			$q=new TQuery('fbqueue');
			$q->Add('id_employee', $employee->ID());
			$q->Add('id_company', $employee->CompanyID());
			$q->Add('id_page', 0);
			$q->Add('service', dbescape('linkedin'));
			$q->Add('scheduledtime', intval($scheduled_time));
			$q->Add('message', dbescape($message));
			$q->Add('image', dbescape($picture));
			$q->Insert();
		}

	function sms_queue_link($employee, $id_content, $recipient, $url, $message, $picture = '', $scheduled_time=0)
		{
			/** @var $employee TEmployee */
			$q=new TQuery('fbqueue');
			$q->Add('id_employee', intval($employee->ID()));
			$q->Add('id_company', intval($employee->CompanyID()));
			$q->Add('id_page', 0);
			$q->Add('id_content', intval($id_content));
			$q->Add('recipient', dbescape($recipient));
			$q->Add('service', dbescape('sms'));
			$q->Add('scheduledtime', intval($scheduled_time));
			$q->Add('message', dbescape($message));
			$q->Add('url', dbescape($url));
			$q->Add('image', dbescape($picture));
			$q->Insert();
		}
