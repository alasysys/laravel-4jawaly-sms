<?php
	
	namespace Alkoumi\Laravel4jawalySms\Traits;
	
	use Alkoumi\Laravel4jawalySms\Notifications\Admin;
	
	trait HasBalance
	{
		use ResponseDecoder , HasClientEndPoint;
		
		protected int $availableBalance;
		
		public function getBalance(): int
		{
			$this->setBalance();
			return (int) $this->availableBalance;
		}
		
		private function setBalance(): void
		{
			$status = $this->decode($this->client()->post($this->balanceEndpoient , ['form_params' => $this->baseParams()]));
			
			if ((int) $status->Code !== 117) {
				Admin::Notifi(null , $status);
				abort(403 , $status->MessageIs.' 🚫 🔥 ');
			}
			
			$this->availableBalance = (int) $status->currentuserpoints;
		}
	}
