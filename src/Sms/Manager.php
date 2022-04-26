<?php
	
	namespace Alkoumi\Laravel4jawalySms\Sms;
	
	use Alkoumi\Laravel4jawalySms\Notifications\Admin;
	use Alkoumi\Laravel4jawalySms\Traits\Configrable;
	use Alkoumi\Laravel4jawalySms\Traits\ExtractMobileNumbers;
	use Alkoumi\Laravel4jawalySms\Traits\HasBalance;
	use Alkoumi\Laravel4jawalySms\Traits\HasClientEndPoint;
	use Alkoumi\Laravel4jawalySms\Traits\ResponseDecoder;
	use JetBrains\PhpStorm\ArrayShape;
	
	class Manager
	{
		use Configrable , ExtractMobileNumbers , ResponseDecoder , HasBalance , HasClientEndPoint;
		
		public function __construct()
		{
			$this->fetchConfig();
		}
		
		public function getBalance(): int
		{
			$this->setBalance();
			return (int) $this->availableBalance;
		}
		
		protected function sendTheMessage(): string
		{
			return $this->getResponseMessage($this->client()->post($this->sendEndpoient , ['form_params' => array_merge($this->baseParams() , $this->sendParams())]));
		}
		
		#[ArrayShape(['username' => "string" , 'password' => "string" , 'return' => "string"])]
		private function baseParams(): array
		{
			return [
				'username' => $this->username ,
				'password' => $this->password ,
				'return' => 'json' ,
			];
		}
		
		#[ArrayShape(['sender' => "string" , 'message' => "mixed" , 'numbers' => "string"])]
		private function sendParams(): array
		{
			return [
				'sender' => $this->sender ,
				'message' => $this->msg ,
				'numbers' => $this->parseNumbers($this->numbers)
			];
		}
		
		private function getResponseMessage($response): string
		{
			$status = $this->decode($response);
			
			Admin::Notifi(null , $status);
			
			if (isset($status->Code) && (int) $status->Code !== 100) {
				abort(403 , $status->MessageIs.' -> كود الخطأ : '.$status->Code);
			}
			
			return $status->MessageIs;
		}
	}
