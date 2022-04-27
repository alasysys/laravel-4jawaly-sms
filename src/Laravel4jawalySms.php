<?php
	
	namespace Alkoumi\Laravel4jawalySms;
	
	use Alkoumi\Laravel4jawalySms\Notifications\Admin;
	use Alkoumi\Laravel4jawalySms\Sms\Sender;
	
	class Laravel4jawalySms extends Sender
	{
		protected $numbers;
		protected $msg = "";
		
		public function message(string $messageText): self
		{
			if (empty($messageText)) {
				$notificationMessage = __('Opps! You can\'t use empty message to send.');
				Admin::Notifi($notificationMessage , null);
				abort(403 , $notificationMessage);
			}
			
			$this->msg = $messageText;
			return $this;
		}
		
		/**
		 * @param  mixed  $mobileNumbers
		 * @return self
		 */
		public function to($mobileNumbers): self
		{
			$this->extractMobileNumbers($mobileNumbers);
			return $this;
		}
		
		public function asFormal(): self
		{
			$this->sender = $this->formal_sender;
			return $this;
		}
		
		public function send(): string
		{
			return $this->sendTheMessage();
		}
	}
