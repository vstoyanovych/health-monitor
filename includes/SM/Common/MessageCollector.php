<?php

	namespace SM\Common;

	use SM\UI\UI;

	class MessageCollector
		{

			private $messages=[];
			private $errors=false;
			private $switch_action_on_error;

			const ERROR='error';

			public function Count(): int
				{
					return count($this->messages);
				}

			public function AddError(string $message): void
				{
					$this->messages[]=[
						'message'=>(string)$message,
						'type'=>self::ERROR,
					];
					$this->errors=true;
					if (!empty($this->switch_action_on_error))
						sm_set_action($this->switch_action_on_error);
				}

			public function HasErrors(): bool
				{
					return $this->errors;
				}

			public function GetErrorsAsString(string $concatenation_separator='. '): string
				{
					$errors=[];
					foreach ($this->messages as $msg_arr)
						{
							if ($msg_arr['type']===self::ERROR)
								$errors[]=$msg_arr['message'];
						}
					return implode($concatenation_separator, $errors);
				}

		/**
		 * @param UI $ui
		 * @return void
		 */
			public function DisplayUIErrors(UI $ui): void
				{
					$errors=[];
					foreach ($this->messages as $msg_arr)
						{
							if ($msg_arr['type']===self::ERROR)
								$errors[]=$msg_arr['message'];
						}
					if (count($errors)>0)
						{
							$ui->NotificationError(implode('. ', $errors));
						}
				}

			public function SwitchActionOnError(string $new_action): void
				{
					$this->switch_action_on_error=$new_action;
					if ($this->HasErrors())
						sm_set_action($this->switch_action_on_error);
				}

		}
