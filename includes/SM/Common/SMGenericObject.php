<?php

	namespace SM\Common;

	use TQuery;

	abstract class SMGenericObject
		{
			private $info;
			private $id_field;
			private $title_field;
			private $table_name;

			function __construct($id_or_cachedinfo, $table_name, $id_field, $title_field=NULL)
				{
					$this->id_field=$id_field;
					$this->table_name=$table_name;
					$this->title_field=$title_field;
					if ($id_or_cachedinfo===NULL)
						$this->info=[];
					elseif (is_array($id_or_cachedinfo))
						$this->info=$id_or_cachedinfo;
					else
						{
							if (!$this->isValidIDValueForConstuctor($id_or_cachedinfo))
								$this->info=[];
							else
								$this->LoadData($id_or_cachedinfo);
						}
				}

			protected function isValidIDValueForConstuctor($id_value)
				{
					if (intval($id_value)>0)
						return true;
					else
						return false;
				}

			protected function LoadData($id=NULL)
				{
					if ($id===NULL)
						$id=$this->ID();
					$this->info=TQuery::ForTable($this->table_name)->AddWhere($this->id_field, intval($id))->Get();
				}

			function GetRawData()
				{
					return $this->info;
				}

			private function FieldRawValue($field_name)
				{
					return $this->info[$field_name];
				}

			protected function FieldFloatValue($field_name)
				{
					return floatval($this->FieldRawValue($field_name));
				}

			protected function FieldIntValue($field_name)
				{
					return intval($this->FieldRawValue($field_name));
				}

			protected function FieldBoolValue($field_name)
				{
					return $this->FieldIntValue($field_name)>0;
				}

			protected function FieldStringValue($field_name)
				{
					return $this->FieldRawValue($field_name);
				}
			
			public static function UsingCache($id)
				{
					global $sm;
					$class_name=static::class;
					$class_name_str='class_'.str_replace('\\', '__', static::class);
					if (!isset($sm['cache']['objects'][$class_name_str][$id]) || !is_array($sm['cache'][$class_name_str][$id]))
						{
							$object=new $class_name($id);
							if ($object->Exists())
								$sm['cache']['objects'][$class_name_str][$id]=$object->GetRawData();
						}
					else
						$object=new $class_name($sm['cache']['objects'][$class_name_str][$id]);
					return $object;
				}

			function ID()
				{
					return $this->FieldIntValue($this->id_field);
				}

			function Title()
				{
					return $this->FieldStringValue($this->title_field);
				}

			function SetTitle($val)
				{
					$this->UpdateValues([$this->title_field=>$val]);
				}

			function Exists()
				{
					return !empty($this->info[$this->id_field]);
				}

			protected function UpdateValues($params_array)
				{
					unset($params_array['id']);
					if (empty($params_array) || !is_array($params_array))
						return;
					$q=new TQuery($this->table_name);
					foreach ($params_array as $key=>$val)
						{
							$this->info[$key]=$val;
							$q->AddString($key, $this->info[$key]);
						}
					$q->Update($this->id_field, intval($this->ID()));
					$this->OnUpdateCompleted();
				}

			protected function OnCreate()
				{
				}

			protected function OnUpdateCompleted()
				{
				}

			protected static function CreateObjectWithParams($tablename, $params_array)
				{
					$class_name=static::class;
					$sql=new TQuery($tablename);
					foreach ($params_array as $key=>$val)
						{
							$sql->Add($key, dbescape($val));
						}
					$object=new $class_name($sql->Insert());
					$object->OnCreate();
					return $object;
				}

			protected static function initWithParams($tablename, $params_array, array $order_fieldname_boolsort_array=[])
				{
					$class_name=static::class;
					$sql=new TQuery($tablename);
					foreach ($params_array as $key=>$val)
						{
							$sql->AddWhere($key, dbescape($val));
						}
					if (!empty($order_fieldname_boolsort_array))
						{
							$sql->OrderByFieldsArray($order_fieldname_boolsort_array);
						}
					$object=new $class_name($sql->Get());
					return $object;
				}

			static function initSingleton($id)
				{
					global $sm;
					$class_name=static::class;
					if (empty($sm['singleton'][$class_name][$id]))
						{
							$sm['singleton'][$class_name][$id]=new $class_name($id);
						}
					return $sm['singleton'][$class_name][$id];
				}

			static function initNotExistent()
				{
					$class_name=static::class;
					return new $class_name([]);
				}

			protected function OnRemoveBeforeStart()
				{
				}

			protected function OnRemoveAfterEnd()
				{
				}

			function Remove()
				{
					$this->OnRemoveBeforeStart();
					TQuery::ForTable($this->table_name)->AddWhere($this->id_field, intval($this->ID()))->Remove();
					$this->OnRemoveAfterEnd();
				}

			protected function Increment($field_name, $val=1)
				{
					$sql=dbescape($field_name)."=".dbescape($field_name).'+'.intval($val);
					$sql="UPDATE ".$this->table_name." SET ".$sql." WHERE ".$this->id_field."=".intval($this->ID());
					execsql($sql);
					$this->info[$field_name]=intval($this->info[$field_name])+intval($val);
				}
			protected function Decrement($field_name, $val=1)
				{
					$this->Increment($field_name, -$val);
				}
			protected function IncrementFloat($field_name, $val=1)
				{
					$sql=dbescape($field_name)."=".dbescape($field_name).'+'.floatval($val);
					$sql="UPDATE ".$this->table_name." SET ".$sql." WHERE ".$this->id_field."=".intval($this->ID());
					execsql($sql);
					$this->info[$field_name]=intval($this->info[$field_name])+floatval($val);
				}
			protected function DecrementFloat($field_name, $val=1)
				{
					$this->IncrementFloat($field_name, -$val);
				}


		}
