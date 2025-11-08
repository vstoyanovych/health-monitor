<?php

	namespace NUWM\Resources;

	use NUWM\ORM\EntityList;

	/**
	 * @method ResourceLog Item($index)
	 * @method ResourceLog|bool Fetch()
	 * @method ResourceLog[] EachItem()
	 */
	class ResourceLogsList extends EntityList
		{
			public function EntityName(): string
				{
					return ResourceLog::class;
				}

			public function SetFilterResourceID($resource_id): void
				{
					$this->SetFilterFieldIntValue('id_resources', $resource_id);
				}

			public function SetFilterForDate(string $date): void
				{
					$timestamp = strtotime($date);
					if ($timestamp === false)
						return;

					$day_start = date('Y-m-d 00:00:00', $timestamp);
					$day_end = date('Y-m-d 23:59:59', $timestamp);

					$this->SetFilterFieldBetweenStringDateValues('time_checked', $day_start, $day_end);
				}

			public function SetFilterForPeriod(string $start_datetime, ?string $end_datetime = null): void
				{
					$start_timestamp = strtotime($start_datetime);
					if ($start_timestamp === false)
						return;

					$period_start = date('Y-m-d H:i:s', $start_timestamp);

					$end_timestamp = $end_datetime !== null ? strtotime($end_datetime) : time();
					if ($end_timestamp === false)
						return;

					$period_end = date('Y-m-d H:i:s', $end_timestamp);

					$this->SetFilterFieldBetweenStringDateValues('time_checked', $period_start, $period_end);
				}

			public function OrderByTimeChecked(bool $asc = true): self
				{
					$this->OrderByField('time_checked', $asc);
					return $this;
				}
		}

