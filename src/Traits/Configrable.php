<?php
	
	namespace Alkoumi\Laravel4jawalySms\Traits;
	
	trait Configrable
	{
		protected $username;
		protected $password;
		protected $sender;
		protected $ads_sender;
		protected $formal_sender;
		protected $balanceEndpoient;
		protected $base_uri;
		protected $sendEndpoient;
		
		private function fetchConfig(): void
		{
			$config = config('4jawaly-sms');
			
			if (isset($config)) {
				foreach ($config as $key => $value) {
					$this->{$key} = $value;
				}
				$this->sender = $this->ads_sender;
			}
		}
	}
