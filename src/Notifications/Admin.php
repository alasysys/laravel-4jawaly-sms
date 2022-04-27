<?php
	
	namespace Alkoumi\Laravel4jawalySms\Notifications;
	
	use Illuminate\Support\Facades\Mail;
	
	class Admin
	{
		public static function Notifi($notificationMessage , $status): void
		{
			$msg = $status->MessageIs ?? null;
			$lastuserpoints = $status->lastuserpoints ?? null;
			$currentuserpoints = $status->currentuserpoints ?? null;
			$SMSNUmber = $status->SMSNUmber ?? null;
			$totalsentnumbers = $status->totalsentnumbers ?? null;
			
			Mail::send([] , [] , function ($message) use ($notificationMessage , $msg , $lastuserpoints , $currentuserpoints , $SMSNUmber , $totalsentnumbers) {
				$message->to(config('4jawaly-sms.admin_email'))
				        ->subject(__('Send status for your 4Jawaly SMS account - ').config('app.name'))
				        ->html(
					        '<h3>'.'الرسالة العامة : '.$notificationMessage.'</br>'.
					        'الحالة : '.$msg.'</br>'.
					        'الأرقام المرسل إليها  : '.$totalsentnumbers.'</br>'.
					        'الرسائل المرسلة  : '.$SMSNUmber.'</br>'.
					        'الرصيد المتبقي  : '.$currentuserpoints.'</br>'.
					        'الرصيد السابق  : '.$lastuserpoints.'
							</br>------------------------</br>'.
					        now().'</br>'.
					        config('app.name').'</h3>' , 'text/html');
			});
		}
	}
