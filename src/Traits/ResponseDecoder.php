<?php
	
	namespace Alkoumi\Laravel4jawalySms\Traits;
	
	trait ResponseDecoder
	{
		/**
		 * @param $response
		 * @return mixed
		 */
		private function decode($response)
		{
			return json_decode($response->getBody());
		}
	}
