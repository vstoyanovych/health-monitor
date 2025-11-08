<?php

	namespace NUWM\Resources;

	use NUWM\ORM\EntityList;

	/**
	 * @method Resource Item($index)
	 * @method Resource|bool Fetch()
	 * @method Resource[] EachItem()
	 */
	class ResourcesList extends EntityList
		{
			public function EntityName(): string
				{
					return Resource::class;
				}
		}

