<?php
	
	namespace Alkoumi\Laravel4jawalySms\Traits;
	
	use Alkoumi\Laravel4jawalySms\Notifications\Admin;
	use Illuminate\Database\Eloquent\Collection as ElquectCollection;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Query\Builder;
	use Illuminate\Support\Collection;
	
	trait ExtractMobileNumbers
	{
		protected function extractMobileNumbers(mixed $mobileNumbers): void
		{
			if (is_integer($mobileNumbers)) {
				$this->mobileCanNotBeInteger();
			}
			
			if (empty($mobileNumbers)) {
				$this->mobileCanNotBeEmpty();
			}
			
			if ($mobileNumbers instanceof ElquectCollection || $mobileNumbers instanceof Collection || $mobileNumbers instanceof Builder) {
				if (!$mobileNumbers->first()->mobile) {
					$this->mobileFieldNotExist();
				}
				$this->numbers = $mobileNumbers->pluck('mobile')->toArray();
				return;
			}
			
			if (is_object($mobileNumbers) || $mobileNumbers instanceof Model) {
				if (!$mobileNumbers->mobile) {
					$this->mobileFieldNotExist();
				}
				$this->numbers = [$mobileNumbers->mobile];
				return;
			}
			
			is_array($mobileNumbers) ? $this->numbers = $mobileNumbers : null;
			
			is_numeric($mobileNumbers) ? $this->numbers = [$mobileNumbers] : null;
		}
		
		protected function parseNumbers(array $numbers): string
		{
			return $this->parseToKsaNumbers($this->removeDuplicate($numbers));
		}
		
		protected function removeDuplicate(array $numbers): array
		{
			return array_values(array_unique($numbers));
		}
		
		protected function parseToKsaNumbers(array $numbers): string
		{
			$parsedNumbers = '';
			
			for ($i = 0; $i < count($numbers); $i++) {
				if ((!is_numeric($numbers[$i])) || (strlen($numbers[$i]) != 10) || (substr($numbers[$i] , 0 , 2) != '05')) {
					$notificationMessage = __('Opps! Mobile numbers must be KSA valid as "0500175200".');
					Admin::Notifi($notificationMessage , null);
					abort(403 , $notificationMessage);
				}
				$parsedNumbers .= '966'.substr($numbers[$i] , 1 , strlen($numbers[$i]) - 1).',';
			}
			
			return substr($parsedNumbers , 0 , strlen($parsedNumbers) - 1);
		}
		
		protected function mobileFieldNotExist(): void
		{
			$notificationMessage = __('Opps! Make Shure That you have mobile filed in your data');
			Admin::Notifi($notificationMessage , null);
			abort(403 , $notificationMessage);
		}
		
		protected function mobileCanNotBeInteger(): void
		{
			$notificationMessage = __('Opps! You can\'t add integer numbers only "0500175200" allowed.');
			Admin::Notifi($notificationMessage , null);
			abort(403 , $notificationMessage);
		}
		
		protected function mobileCanNotBeEmpty(): void
		{
			$notificationMessage = __('Opps! mobile numbers can\'t be empty as "0500175200".');
			Admin::Notifi($notificationMessage , null);
			abort(403 , $notificationMessage);
		}
	}
