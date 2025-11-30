<?php

	namespace NUWM\Common;

	use TQuery;
	use NUWM\Common\DB\DBQuery;

	trait GenericMetadataTrait
		{
			protected $metadata;

			function HasMetaData($object_name, $key): bool
				{
					$this->LoadMetaData($object_name);
					if (!is_array($this->metadata))
						return false;
					return array_key_exists($key, $this->metadata);
				}

			protected function LoadMetaData($object_name): self
				{
					if ($this->metadata===NULL)
						{
							$this->metadata=[];
							$data=DBQuery::ForTable($this->table_name.'_metadata')
								->AddWhere('object_id', $this->ID())
								->AddWhere('object_name', $object_name)
								->Select()
								->items;

							for ($i=0; $i<count($data); $i++)
								$this->metadata[$data[$i]['key_name']]=$data[$i]['val'];
						}
					return $this;
				}

			function GetMetaData($object_name, $key): string
				{
					$this->LoadMetaData($object_name);
					return $this->metadata[$key] ?? '';
				}

			function isMetaDataEmpty($key): bool
				{
					return empty($this->GetMetaData($key));
				}

			function UnsetMetaData($key): void
				{
					$this->SetMetaData($key, NULL);
				}

			protected function RemoveAllMetaData(): void
				{
					$q = new DBQuery($this->table_name.'_metadata');
					$q->AddInt('object_id', $this->ID());
					$q->Remove();
					$this->metadata=[];
				}

			/*
			 * @param $value - use NULL to delete metadata
			 */
			function SetMetaData($object_name, $key, $value, $use_empty_as_null=false): self
				{
					if (empty($value) && $use_empty_as_null)
						$value=NULL;
					$this->LoadMetaData($object_name);
					$q = new TQuery($this->table_name.'_metadata');
					$q->Add('object_name', dbescape($object_name));
					$q->Add('object_id', $this->ID());
					$q->Add('key_name', dbescape($key));
					$info=$q->Get();
					if (!empty($info['id']))
						{
							$q = new TQuery($this->table_name.'_metadata');
							if ($value===NULL)
								{
									$q->Add('id', intval($info['id']));
									$q->Remove();
									unset($this->metadata[$key]);
								}
							else
								{
									$q = new TQuery($this->table_name.'_metadata');
									$q->Add('object_name', dbescape($object_name));
									$q->Add('val', dbescape($value));
									$q->Update('id', intval($info['id']));
									$this->metadata[$key]=$value;
								}
						}
					elseif ($value!==NULL)
						{
							$q = new TQuery($this->table_name.'_metadata');
							$q->Add('object_name', dbescape($object_name));
							$q->Add('object_id', $this->ID());
							$q->Add('key_name', dbescape($key));
							$q->Add('val', dbescape($value));
							$q->Insert();
							$this->metadata[$key]=$value;
						}
					else
						unset($this->metadata[$key]);
					return $this;
				}

			protected function GetMetaDataAsInt(string $key): int
				{
					return intval($this->GetMetaData($key));
				}

			protected function GetMetaDataAsBool(string $key): bool
				{
					return intval($this->GetMetaData($key))>0;
				}

		}

