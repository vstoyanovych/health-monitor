<?php

	namespace NUWM\Resources;

	use Cleaner;
	use DateTimeInterface;
	use NUWM\ORM\EntityObject;

	class ResourceLog extends EntityObject
		{
			public static function TableName(): string
				{
					return 'nuwm_resource_logs';
				}

			public static function IdFieldName(): string
				{
					return 'id';
				}

			public static function TitleFieldName(): ?string
				{
					return null;
				}

			public function ResourceID(): ?int
				{
					return $this->FieldIntValue('id_resources');
				}

			public function TimeChecked(): ?string
				{
					return $this->FieldStringValue('time_checked');
				}

			public function Status(): ?string
				{
					return $this->FieldStringValue('status');
				}

			public function TotalTime(): ?float
				{
					return $this->FieldFloatValue('total_time');
				}

			public function RedirectCount(): ?int
				{
					return $this->FieldIntValue('redirect_count');
				}

			public function IP(): ?string
				{
					return $this->FieldStringValue('ip');
				}

			public function Error(): ?string
				{
					return $this->FieldStringValue('error');
				}

			public function SetResourceID($resource_id): void
				{
					$this->UpdateValues(['id_resources' => Cleaner::IntObjectID($resource_id)]);
				}

			public function SetTimeChecked($time_checked): void
				{
					$this->UpdateValues(['time_checked' => self::NormalizeDateTimeValue($time_checked)]);
				}

			public function SetStatus(string $status): void
				{
					$this->UpdateValues(['status' => $status]);
				}

			public function SetTotalTime(?float $total_time): void
				{
					if ($total_time === null)
						return;

					$this->UpdateValues(['total_time' => floatval($total_time)]);
				}

			public function SetRedirectCount(?int $redirect_count): void
				{
					if ($redirect_count === null)
						return;

					$this->UpdateValues(['redirect_count' => intval($redirect_count)]);
				}

			public function SetIP(?string $ip): void
				{
					if ($ip === null)
						return;

					$this->UpdateValues(['ip' => $ip]);
				}

			public function SetError(?string $error): void
				{
					$this->UpdateValues(['error' => $error ?? '']);
				}

			public static function Create($resource_id, string $status, $time_checked = null, ?float $total_time = null, ?int $redirect_count = null, ?string $ip = null, ?string $error = null): self
				{
					$params = [
						'id_resources' => Cleaner::IntObjectID($resource_id),
						'status' => $status,
						'time_checked' => self::NormalizeDateTimeValue($time_checked),
					];

					if ($total_time !== null)
						$params['total_time'] = floatval($total_time);

					if ($redirect_count !== null)
						$params['redirect_count'] = intval($redirect_count);

					if ($ip !== null)
						$params['ip'] = $ip;

					if ($error !== null)
						$params['error'] = $error;

					return self::CreateObjectWithParams(self::TableName(), $params);
				}

			protected static function NormalizeDateTimeValue($value): string
				{
					if ($value instanceof DateTimeInterface)
						return $value->format('Y-m-d H:i:s');

					if (is_numeric($value))
						return date('Y-m-d H:i:s', intval($value));

					if (is_string($value) && strtotime($value) !== false)
						return date('Y-m-d H:i:s', strtotime($value));

					return date('Y-m-d H:i:s');
				}
		}

