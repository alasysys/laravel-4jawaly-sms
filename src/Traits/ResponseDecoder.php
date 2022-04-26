<?php
	
	namespace Alkoumi\Laravel4jawalySms\Traits;
	
	trait ResponseDecoder
	{
		private function decode($response): mixed
		{
			return json_decode($response->getBody());
		}
	}
