<?php
	return [
		/*
		|--------------------------------------------------------------------------
		| Account Details
		|--------------------------------------------------------------------------
		|
		| Set your Username and Password used to log in to
		| https://www.4jawaly.net/api/
		|
		*/
		
		'username' => env('4JAWALY_SMS_USERNAME') ,
		'password' => env('4JAWALY_SMS_PASSWORD') ,
		
		// Name of Formal Sender & Ads Sender must be apporved by https://www.4jawaly.net for GCC
		'formal_sender' => env('4JAWALY_SMS_FORMALSENDER') ,
		'ads_sender' => env('4JAWALY_SMS_ADSSENDER') ,
		
		// Admin Mobile to notify & Balance to Notify Admin when get this Number
		'admin_email' => env('4JAWALY_SMS_ADMINEMAIL' , 'admin@example.com') ,
		
		/*
		|--------------------------------------------------------------------------
		| Universal Settings Required by https://www.4jawaly.net
		|--------------------------------------------------------------------------
		|
		| You do not need to change any of these settings.
		|
		|
		*/
		
		// The Base Uri of the Api. Don't Change this Value.
		'base_uri' => 'https://www.4jawaly.net/api/' ,
		
		// The Send Uri of the Api. Don't Change this Value.
		'sendEndpoient' => 'sendsms.php?' ,
		
		// The Balance Uri of the Api. Don't Change this Value.
		'balanceEndpoient' => 'getbalance.php?' ,
	];
