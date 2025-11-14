<?php

	namespace NUWM\MainWebsite;

	use NUWM\ORM\EntityObject;

	class MainWebsitePage extends EntityObject
		{
			public static function TableName(): string
				{
					return 'main_website_pages';
				}

			public static function IdFieldName(): string
				{
					return 'id';
				}

			public static function TitleFieldName(): ?string
				{
					return 'title';
				}

			public function URL(): ?string
				{
					return $this->FieldStringValue('url');
				}

			public function Ready(): bool
				{
					return intval($this->FieldIntValue('ready')) === 1;
				}

			public function NeedToCheck(): bool
				{
					return intval($this->FieldIntValue('need_to_check')) === 1;
				}

			public function Admin(): ?string
				{
					return $this->FieldStringValue('admin');
				}

			public function SetURL(?string $url): void
				{
					$this->UpdateValues(['url' => $url]);
				}

			public function SetReady($ready): void
				{
					$this->UpdateValues(['ready' => intval($ready) ? 1 : 0]);
				}

			public function SetNeedToCheck($need_to_check): void
				{
					$this->UpdateValues(['need_to_check' => intval($need_to_check) ? 1 : 0]);
				}

			public function SetAdmin(?string $admin): void
				{
					$this->UpdateValues(['admin' => $admin]);
				}

			public static function Create(?string $title, ?string $url, $ready = 0, ?string $admin = null): self
				{
					return self::CreateObjectWithParams(
						self::TableName(),
						[
							'title' => $title,
							'url' => $url,
							'ready' => intval($ready) ? 1 : 0,
							'admin' => $admin,
						]
					);
				}
		}


