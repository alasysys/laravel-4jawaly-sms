<?php
	
	namespace Alkoumi\Laravel4jawalySms;
	
	use Illuminate\Support\ServiceProvider;
	
	class Laravel4jawalySmsServiceProvider extends ServiceProvider
	{
		/**
		 * Perform post-registration booting of services.
		 *
		 * @return void
		 */
		public function boot(): void
		{
			$this->loadTranslationsFrom(__DIR__.'/../lang' , 'alkoumi');
			// $this->loadViewsFrom(__DIR__.'/../resources/views', 'alkoumi');
			// $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
			// $this->loadRoutesFrom(__DIR__.'/routes.php');
			
			// Publishing is only necessary when using the CLI.
			if ($this->app->runningInConsole()) {
				$this->bootForConsole();
			}
		}
		
		/**
		 * Register any package services.
		 *
		 * @return void
		 */
		public function register(): void
		{
			$this->mergeConfigFrom(__DIR__.'/../config/4jawaly-sms.php' , '4jawaly-sms');
			
			// Register the service the package provides.
			$this->app->singleton('laravel-4jawaly-sms' , function ($app) {
				return new Laravel4jawalySms;
			});
		}
		
		/**
		 * Get the services provided by the provider.
		 *
		 * @return array
		 */
		public function provides()
		{
			return ['laravel-4jawaly-sms'];
		}
		
		/**
		 * Console-specific booting.
		 *
		 * @return void
		 */
		protected function bootForConsole(): void
		{
			// Publishing the configuration file.
			$this->publishes([
				__DIR__.'/../config/4jawaly-sms.php' => config_path('4jawaly-sms.php') ,
			] , '4jawaly-sms.config');
			
			// Publishing the views.
			/*$this->publishes([
				__DIR__.'/../resources/views' => base_path('resources/views/vendor/alkoumi'),
			], 'laravel-4jawaly-sms.views');*/
			
			// Publishing assets.
			/*$this->publishes([
				__DIR__.'/../resources/assets' => public_path('vendor/alkoumi'),
			], 'laravel-4jawaly-sms.views');*/
			
			// Publishing the translation files.
			/*$this->publishes([
				__DIR__.'/../resources/lang' => resource_path('lang/vendor/alkoumi'),
			], 'laravel-4jawaly-sms.views');*/
			
			// Registering package commands.
			// $this->commands([]);
		}
	}
