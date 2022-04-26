<?php
	
	namespace Alkoumi\Laravel4jawalySms\Traits;
	
	use GuzzleHttp\Client;
	
	trait HasClientEndPoint
	{
		protected function Client(): Client
		{
			return new Client([
				'base_uri' => $this->base_uri ,
			]);
		}
	}
