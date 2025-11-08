<?php

	namespace NUWM\Resources;

	use Cleaner;
	use DateTimeInterface;
	use NUWM\ORM\EntityObject;

	class Resource extends EntityObject
		{
			public static function TableName(): string
				{
					return 'nuwm_resources';
				}

			public static function IdFieldName(): string
				{
					return 'id';
				}

			public static function TitleFieldName(): ?string
				{
					return 'service';
				}

			public function Service(): ?string
				{
					return $this->FieldStringValue('service');
				}

			public function URL(): ?string
				{
					return $this->FieldStringValue('url');
				}

			public function Availability(): ?int
				{
					return $this->FieldIntValue('availability');
				}

			public function Department(): ?string
				{
					return $this->FieldStringValue('department');
				}

			public function NotificationEmail(): ?string
				{
					return $this->FieldStringValue('notification_email');
				}

			public function AddedTime(): ?string
				{
					return $this->FieldStringValue('added_time');
				}

			public function AddedBy(): ?int
				{
					return $this->FieldIntValue('added_by');
				}

			public function SetService(string $service): void
				{
					$this->UpdateValues(['service' => $service]);
				}

			public function SetURL(string $url): void
				{
					$this->UpdateValues(['url' => $url]);
				}

			public function SetAvailability($availability): void
				{
					$this->UpdateValues(['availability' => intval($availability)]);
				}

			public function SetDepartment(string $department): void
				{
					$this->UpdateValues(['department' => $department]);
				}

			public function SetNotificationEmail(?string $email): void
				{
					$this->UpdateValues(['notification_email' => $email ?? '']);
				}

			public function SetAddedTime($added_time): void
				{
					$this->UpdateValues(['added_time' => self::NormalizeDateTimeValue($added_time)]);
				}

			public function SetAddedBy($user_id): void
				{
					$this->UpdateValues(['added_by' => Cleaner::IntObjectID($user_id)]);
				}

			public static function Create(string $service, string $url, string $department, $added_by = null, $added_time = null, $availability = null, ?string $notification_email = null): self
				{
					$params = [
						'service' => $service,
						'url' => $url,
						'department' => $department,
						'added_time' => self::NormalizeDateTimeValue($added_time),
					];

					if ($added_by !== null)
						$params['added_by'] = Cleaner::IntObjectID($added_by);

					if ($availability !== null)
						$params['availability'] = intval($availability);

					if ($notification_email !== null)
						$params['notification_email'] = $notification_email;

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

