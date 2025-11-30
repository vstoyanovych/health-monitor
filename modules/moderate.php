<?php

	use SM\SM;
	use SM\UI\Grid;
	use SM\UI\UI;

	if ( SM::User()->Level() == 3 )
		{
			sm_default_action('list');

			if ( sm_action('list') )
				{
					add_path_home();
					add_path_current();
					sm_title('Moderate Content');

					$ui = new UI();

					if (SM::GET('type')->AsString() == 'all')
						$data['active_tab'] = 'All';
					elseif (SM::GET('type')->AsString() == 'articles')
						$data['active_tab'] = 'Articles';
					else
						$data['active_tab'] = 'Videos';

					$data['options'][] = [
						'title' => 'All',
						'url' => sm_this_url(['type' => 'all']),
						'selected' => SM::GET('type')->AsString() == 'all'
					];
					$data['options'][] = [
						'title' => 'Videos',
						'url' => sm_this_url(['type' => '']),
						'selected' => SM::GET('type')->isEmpty()
					];
					$data['options'][] = [
						'title' => 'Articles',
						'url' => sm_this_url(['type' => 'articles']),
						'selected' => SM::GET('type')->AsString() == 'articles'
					];

					$ui->div_open('', 'filter customer_activity_filters');
					$ui->div_open('', 'wrapper flex align-items-center mb-10');
					$ui->AddTPL('newsfeed_filters.tpl', '', $data);
					$ui->html('<div class="flex-1"></div>');
					$ui->div_close();
					$ui->div_close();

					$t = new Grid();
					$t->AddCol('thumb', 'Preview', '50%');
					$t->AddCol('title', 'Title', '50%');
					$t->AddCol('publish', '');
					$t->AddEdit();
					$t->AddDelete();
					if(!empty($_getvars['from']))
						$offset = abs(intval($_getvars['from']));
					else
						$offset = 0;
					$limit = 30;
					$videos = new TContentList();
					if (SM::GET('type')->AsString() == 'articles')
						$videos->SetFilterArticles();
					elseif (SM::GET('type')->AsString() == 'videos' || SM::GET('type')->isEmpty())
						$videos->SetFilterTypeVideos();
					$videos->SetFilterHidden();
					$videos->OrderByID(false);
					$videos->Offset($offset);
					$videos->Limit($limit);
					$videos->Load();

					for ($i = 0; $i < $videos->Count(); $i++)
						{
							/** @var  $video TContent */
							$video = $videos->Item($i);
							$t->Image('thumb', $video->ImageF());
							$t->ExpanderHTML($video->YouTubeObject()->GetEmbedCode(500, 300));
							$t->Expand('thumb');
							$t->Label('title', $video->TextF());
							$t->URL('title', 'https://'.FrontEndDomain().'/index.php?m=entertainment&d=viewvideo&id='.$video->ID(), true);
							$t->Label('views', $video->ViewCount());
							$t->Label('publish', 'Publish');
							$t->URL('publish', 'index.php?m=article&d=publisharticle&id='.$video->ID().'&returnto='.urlencode(sm_this_url()));
							$t->URL('edit', 'index.php?m=article&d=add&id='.$video->ID().'&returnto='.urlencode(sm_this_url()));
							$t->URL('delete', 'index.php?m=contentmgmt&d=postdelete&id='.$video->ID().'&returnto='.urlencode(sm_this_url()));
							$t->NewRow();
						}
					if ($videos->Count() == 0)
						$t->SingleLineLabel('Nothing found');

					$ui->AddGrid($t);

					$ui->AddPagebarParams($videos->TotalCount(), $limit, $offset);
					$ui->Output(true);

				}
		}
	else
		\SM\Common\Redirect::Now('index.php');