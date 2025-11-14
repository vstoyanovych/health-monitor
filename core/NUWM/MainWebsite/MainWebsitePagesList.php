<?php

	namespace NUWM\MainWebsite;

	use NUWM\ORM\EntityList;

	/**
	 * @method MainWebsitePage Item($index)
	 * @method MainWebsitePage|bool Fetch()
	 * @method MainWebsitePage[] EachItem()
	 */
	class MainWebsitePagesList extends EntityList
		{
			public function EntityName(): string
				{
					return MainWebsitePage::class;
				}

			public function FilterByReadyState(?bool $is_ready): self
				{
					if ($is_ready === null)
						return $this;

					$this->SetFilterFieldIntValue('ready', $is_ready ? 1 : 0);
					return $this;
				}

			public function FilterByAdminPresence(?bool $has_admin): self
				{
					if ($has_admin === null)
						return $this;

					$this->ConcatCondition();
					if ($has_admin)
						$this->Condition("(`admin` <> '' AND `admin` IS NOT NULL)");
					else
						$this->Condition("(`admin` = '' OR `admin` IS NULL)");

					return $this;
				}

			public function OrderByReady(bool $asc = false): self
				{
					$this->OrderByField('ready', $asc);
					$this->OrderByFieldAppend('title', true);
					return $this;
				}

			public function OrderByAdmin(bool $asc = true): self
				{
					$this->NoOrder();
					$this->OrderByExpressionAppend("CASE WHEN (`admin` IS NULL OR `admin`='') THEN 1 ELSE 0 END", true);
					$this->OrderByFieldAppend('admin', $asc);
					$this->OrderByFieldAppend('title', true);
					return $this;
				}
		}


