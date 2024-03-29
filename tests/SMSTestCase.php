<?php
	
	namespace Tests;
	
	use Alkoumi\Laravel4jawalySms\Laravel4jawalySms;
	use Alkoumi\Laravel4jawalySms\Laravel4jawalySmsServiceProvider;
	use Illuminate\Foundation\Auth\User;
	use Illuminate\Support\Facades\DB;
	use Orchestra\Testbench\TestCase;
	use Symfony\Component\HttpKernel\Exception\HttpException;
	
	class SMSTestCase extends TestCase
	{
		protected $sms;
		
		protected function setUp(): void
		{
			parent::setUp(); // TODO: Change the autogenerated stub
			$this->sms = new Laravel4jawalySms();
		}
		
		protected function getPackageProviders($app)
		{
			return [
				Laravel4jawalySmsServiceProvider::class
			];
		}
		
		protected function defineEnvironment($app)
		{
			$app['config']->set('app.name' , 'My Pakages Developing Application');
			
			$app['config']->set('4jawaly-sms.username' , 'username');
			$app['config']->set('4jawaly-sms.password' , 'password');
			$app['config']->set('4jawaly-sms.formal_sender' , 'formal_sender');
			$app['config']->set('4jawaly-sms.ads_sender' , 'ads_sender');
			$app['config']->set('4jawaly-sms.admin_email' , 'admin_email@gmail.com');
			$app['config']->set('4jawaly-sms.base_uri' , 'https://www.4jawaly.net/api/');
			$app['config']->set('4jawaly-sms.sendEndpoient' , 'sendsms.php?');
			$app['config']->set('4jawaly-sms.balanceEndpoient' , 'getbalance.php?');
			
			$app['config']->set('mail.default' , 'smtp');
			$app['config']->set('mail.mailers.smtp' , [
				'transport' => 'smtp' ,
				'host' => 'smtp.email.com' ,
				'port' => 465 ,
				'encryption' => 'ssl' ,
				'username' => 'admin_email@gmail.com' ,
				'password' => 'app-password' ,
				'timeout' => null ,
			]);
			
			$app['config']->set('mail.from' , [
				'address' => 'hello@example.com' ,
				'name' => '4Jawaly SMS Status' ,
			]);
			
			$app['config']->set('database.default' , 'mysql');
			$app['config']->set('database.connections.mysql' , [
				'driver' => 'mysql' ,
				'url' => '' ,
				'host' => '127.0.0.1' ,
				'port' => '3306' ,
				'database' => 'you-data-base-name' ,
				'username' => 'your-user-name' ,
				'password' => 'your-password' ,
				'unix_socket' => '' ,
				'charset' => 'utf8mb4' ,
				'collation' => 'utf8mb4_unicode_ci' ,
				'prefix' => '' ,
				'prefix_indexes' => true ,
				'strict' => true ,
				'engine' => null ,
				'options' => extension_loaded('pdo_mysql') ? array_filter([
					\PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA') ,
				]) : [] ,
			]);
		}
		
		/** @test */
		public function ✅_it_return_the_balance_as_integer()
		{
			$balance = $this->sms->getBalance();
			$this->assertIsInt($balance);
		}
		
		/** @test You Must Make Your userName Wrong first */
		# You Must Make Your userName Wrong first in ->defineEnvironment($app)
		public function ✅_it_abort_when_username_is_wrong()
		{
			try {
				$this->sms->message('تجربة الارسال من TEST UNIT TO ONE NUMBER 🥳 🔥')
				          ->to('0500175200')
				          ->asFormal()
				          ->send();
			} catch (\Throwable $e) {
			}
			
			$this->assertEquals(new HttpException(403 , 'اسم المستخدم غير صحيح -> كود الخطأ : 102') , $e);
		}
		
		/** @test */
		public function ✅_it_abort_when_send_sms_to_one_integer_number()
		{
			try {
				$this->sms->message('تجربة الارسال من TEST UNIT TO ONE NUMBER 🥳 🔥')
				          ->to(0500175200)
				          ->asFormal()
				          ->send();
			} catch (\Throwable $e) {
			}
			$this->assertEquals(new HttpException(403 , 'Opps! You can\'t add integer numbers only "0500175200" allowed.') , $e);
		}
		
		/** @test */
		public function ✅_it_abort_when_send_sms_to_wrong_number()
		{
			try {
				$this->sms->message('تجربة الارسال من TEST UNIT TO ONE NUMBER 🥳 🔥')
				          ->to('0500')
				          ->asFormal()
				          ->send();
			} catch (\Throwable $e) {
			}
			
			$this->assertEquals(new HttpException(403 , 'Opps! Mobile numbers must be KSA valid as "0500175200".') , $e);
		}
		
		/** @test */
		public function ✅_it_abort_when_send_sms_to_Empty_numbers()
		{
			try {
				$this->sms->message('تجربة الارسال من TEST UNIT to_Empty_numbers 🥳 🔥')
				          ->to()
				          ->asFormal()
				          ->send();
			} catch (\Throwable $e) {
			}
			$this->assertInstanceOf(\ArgumentCountError::class , $e);
		}
		
		/** @test */
		public function ✅_it_send_sms_to_one_string_number_with_AD_sender()
		{
			$response = $this->sms->message('تجربة الارسال من TEST UNIT TO ONE NUMBER 🥳 🔥')
			                      ->to('0500175200')
			                      ->send();
			
			$this->assertEquals('تم استلام الارقام بنجاح' , $response);
		}
		
		/** @test */
		public function ✅itSendsSmsToOneStringNumberWithFormal()
		{
			$response = $this->sms->message('تجربة الارسال من TEST UNIT TO ONE NUMBER 🥳 🔥')
			                      ->to('0500175200')
			                      ->asFormal()
			                      ->send();
			
			$this->assertEquals('تم استلام الارقام بنجاح' , $response);
		}
		
		/** @test */
		public function ✅_it_send_sms_to_array_of_numbers()
		{
			$response = $this->sms->message('تجربة الارسال من TEST UNIT TO array 🥳 🔥')
			                      ->to(['0500175200' , '0550980749'])
			                      ->asFormal()
			                      ->send();
			
			$this->assertEquals($response , 'تم استلام الارقام بنجاح');
		}
		
		/** @test */
		# You must configure your Database credentials in the function 👆🏻 defineEnvironment($app)
		# with some data in User::Model();
		public function ✅_it_send_sms_to_collection_of_users()
		{
			$allUsersFromElquent = User::all();
			
			$response = $this->sms->message('تجربة الارسال من TEST UNIT TO Collection User::all() 🥳 🔥')
			                      ->to($allUsersFromElquent)
			                      ->asFormal()
			                      ->send();
			
			$this->assertEquals('تم استلام الارقام بنجاح' , $response);
		}
		
		/** @test */
		# You must configure your Database credentials in the function 👆🏻 defineEnvironment($app)
		# with some data in User::Model();
		public function ✅_it_send_sms_to_Builder_collection_of_users()
		{
			$allUsersFromBuilder = DB::table('users')->get();
			
			$response = $this->sms->message('تجربة الارسال من TEST UNIT TO Collection 🥳 🔥')
			                      ->to($allUsersFromBuilder)
			                      ->asFormal()
			                      ->send();
			
			$this->assertEquals('تم استلام الارقام بنجاح' , $response);
		}
		
		/** @test */
		# You must configure your Database credentials in the function 👆🏻 defineEnvironment($app)
		# with some data in User::Model();
		public function ✅_it_send_sms_to_object_form_clollection_of_users()
		{
			$oneUsersFromElquent = User::first();
			
			$response = $this->sms->message('تجربة الارسال من TEST UNIT TO object_form_clollection 🥳 🔥')
			                      ->to($oneUsersFromElquent)
			                      ->asFormal()
			                      ->send();
			
			$this->assertEquals('تم استلام الارقام بنجاح' , $response);
		}
		
		/** @test */
		# You must configure your Database credentials in the function 👆🏻 defineEnvironment($app)
		# with some data in User::Model();
		public function ✅_it_send_sms_to_object_form_Builder_of_users()
		{
			$oneUsersFromBuilder = DB::table('users')->first();
			
			$response = $this->sms->message('تجربة الارسال من TEST UNIT TO object_form_Builder 🥳 🔥')
			                      ->to($oneUsersFromBuilder)
			                      ->asFormal()
			                      ->send();
			
			$this->assertEquals('تم استلام الارقام بنجاح' , $response);
		}
	}
