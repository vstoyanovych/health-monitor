<?php

	namespace NUWM\Common\Legacy;

	trait EachItemTrait
		{
			function EachItemOfLoaded()
				{
					for ($i=0; $i<$this->Count(); $i++)
						yield $this->Item($i);
				}
		}
