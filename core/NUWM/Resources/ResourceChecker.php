<?php

	namespace NUWM\Resources;

	use DateTimeImmutable;

	class ResourceChecker
		{
			public static function Check(Resource $resource, bool $log_result = true): array
				{
					$result = [
						'status' => ResourceStatus::STATUS_UNKNOWN,
						'http_code' => 0,
						'total_time' => null,
						'redirect_count' => 0,
						'primary_ip' => '',
						'error' => null,
					];

					$url = trim((string) $resource->URL());
					if ($url === '')
						{
							$result['error'] = 'Resource URL is empty.';
							$result['status'] = ResourceStatus::STATUS_UNKNOWN;
							self::Finalize($resource, $result, $log_result);
							return $result;
						}

					$ch = curl_init($url);
					if ($ch === false)
						{
							$result['error'] = 'Failed to initialize cURL session.';
							$result['status'] = ResourceStatus::STATUS_UNKNOWN;
							self::Finalize($resource, $result, $log_result);
							return $result;
						}

					$timeout = 15;
					$connect_timeout = 8;

					$options = [
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_HEADER => true,
						CURLOPT_NOBODY => false,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_MAXREDIRS => 5,
						CURLOPT_USERAGENT => 'NUWM Resource Monitor/1.0 (+https://nuwm)',
						CURLOPT_TIMEOUT => $timeout,
						CURLOPT_CONNECTTIMEOUT => $connect_timeout,
						CURLOPT_SSL_VERIFYPEER => true,
						CURLOPT_SSL_VERIFYHOST => 2,
					];

					curl_setopt_array($ch, $options);

					$response = curl_exec($ch);
					$curl_error = null;

					if ($response === false)
						$curl_error = curl_error($ch);

					$info = curl_getinfo($ch);
					curl_close($ch);

					$result['http_code'] = (int) ($info['http_code'] ?? 0);
					$result['total_time'] = isset($info['total_time']) ? (float) $info['total_time'] : null;
					$result['redirect_count'] = isset($info['redirect_count']) ? (int) $info['redirect_count'] : 0;
					$result['primary_ip'] = (string) ($info['primary_ip'] ?? '');

					if ($curl_error !== null)
						{
							$result['error'] = 'cURL error: '.$curl_error;
							$result['status'] = ResourceStatus::STATUS_OFFLINE;
						}
					else
						{
							if ($result['http_code'] >= 200 && $result['http_code'] < 400)
								$result['status'] = ResourceStatus::STATUS_ONLINE;
							elseif ($result['http_code'] > 0)
								{
									$result['status'] = ResourceStatus::STATUS_OFFLINE;
									$result['error'] = 'Unexpected HTTP status code '.$result['http_code'];
								}
							else
								$result['status'] = ResourceStatus::STATUS_UNKNOWN;
						}

					self::Finalize($resource, $result, $log_result);

					return $result;
				}

			protected static function Finalize(Resource $resource, array $result, bool $log_result): void
				{
					if ($result['status'] === ResourceStatus::STATUS_ONLINE)
						$resource->SetAvailability(1);
					elseif ($result['status'] === ResourceStatus::STATUS_OFFLINE)
						$resource->SetAvailability(0);

					if ($log_result)
						{
							ResourceLog::Create(
								$resource->ID(),
								$result['status'],
								new DateTimeImmutable(),
								$result['total_time'],
								$result['redirect_count'],
								$result['primary_ip'],
								$result['error']
							);
						}
				}

			public static function CheckAll(ResourcesList $resources, bool $log_result = true): array
				{
					$results = [];
					foreach ($resources->EachItem() as $resource)
						$results[$resource->ID()] = self::Check($resource, $log_result);

					return $results;
				}
		}


