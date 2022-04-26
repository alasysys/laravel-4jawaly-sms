<?php
	
	namespace Alkoumi\Laravel4jawalySms\Facades;
	
	use Illuminate\Support\Facades\Facade;
	
	class JawalySms extends Facade
	{
		/**
		 * Get the registered name of the component.
		 *
		 * @return string
		 */
		protected static function getFacadeAccessor(): string
		{
			return 'laravel-4jawaly-sms';
		}
	}
