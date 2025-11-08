<?php

	namespace NUWM\Resources;

	use function array_fill;
	use function floor;
	use function in_array;
	use function max;
	use function min;
	use function strtotime;
	use function time;

	class ResourceStatus
		{
			public const STATUS_ONLINE = 'online';
			public const STATUS_OFFLINE = 'offline';
			public const STATUS_UNKNOWN = 'unknown';

			public static function Normalize(?string $status): string
				{
					$status = strtolower(trim((string) $status));

					if (in_array($status, ['online', 'up', 'success', 'ok', 'available', '1', 'true'], true))
						return self::STATUS_ONLINE;

					if (in_array($status, ['offline', 'down', 'error', 'failed', 'unavailable', '0', 'false'], true))
						return self::STATUS_OFFLINE;

					return self::STATUS_UNKNOWN;
				}

			public static function Label(string $normalized_status): string
				{
					switch ($normalized_status)
						{
							case self::STATUS_ONLINE:
								return 'Online';
							case self::STATUS_OFFLINE:
								return 'Offline';
							default:
								return 'Unknown';
						}
				}

			public static function Current(Resource $resource): array
				{
					$logs = new ResourceLogsList();
					$logs->SetFilterResourceID($resource->ID());
					$logs->OrderByTimeChecked(false);
					$logs->Limit(1);
					$logs->ShowAllItemsIfNoFilters();
					$logs->Load();

					if ($logs->Count() > 0)
						{
							$log = $logs->Item(0);
							$normalized_status = self::Normalize($log->Status());
							$last_checked = $log->TimeChecked();
						}
					else
						{
							$normalized_status = self::STATUS_UNKNOWN;
							$last_checked = null;
						}

					return [
						'status' => $normalized_status,
						'label' => self::Label($normalized_status),
						'last_checked' => $last_checked,
					];
				}

			public static function History(Resource $resource, int $hours = 24): array
				{
					$hours = max(1, min($hours, 168));

					$midnight = strtotime(date('Y-m-d 00:00:00'));
					$end_of_day = $midnight + (24 * 3600) - 1;

					$logs = new ResourceLogsList();
					$logs->SetFilterResourceID($resource->ID());
					$logs->SetFilterForPeriod(date('Y-m-d H:i:s', $midnight), date('Y-m-d H:i:s', $end_of_day));
					$logs->OrderByTimeChecked(true);
					$logs->ShowAllItemsIfNoFilters();
					$logs->Load();

					$buckets = array_fill(0, $hours, null);

					foreach ($logs->EachItem() as $log)
						{
							$log_timestamp = strtotime($log->TimeChecked());
							if ($log_timestamp === false)
								continue;

							if ($log_timestamp < $midnight || $log_timestamp > $end_of_day)
								continue;

							$index = (int) floor(($log_timestamp - $midnight) / 3600);
							if ($index < 0)
								continue;

							if ($index >= $hours)
								$index = $hours - 1;

							$buckets[$index] = self::Normalize($log->Status());
						}

					$history = [];

					for ($i = 0; $i < $hours; $i++)
						{
							if ($buckets[$i] !== null)
								$history[$i] = $buckets[$i];
							else
								$history[$i] = self::STATUS_UNKNOWN;
						}

					return $history;
				}

			public static function Summary(Resource $resource, int $hours = 24): array
				{
					return [
						'status' => self::Current($resource),
						'history' => self::History($resource, $hours),
					];
				}
		}


