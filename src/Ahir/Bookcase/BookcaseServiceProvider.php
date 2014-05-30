<?php namespace Ahir\Bookcase;

use Illuminate\Support\ServiceProvider;

class BookcaseServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('ahir/bookcase');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerBookcase();
		$this->registerSecurityInterface();
		$this->registerImageSecurity();
		$this->registerFileSecurity();
	}

	/**
	* Register Bookcase
	*
	* @return null
	*/
	private function registerBookcase()
	{
        $this->app['bookcase'] = $this->app->share(function($app)
        {
            return new Bookcase;
        });
	}

	/**
	* Register Security Interface
	*
	* @return null
	*/
	private function registerSecurityInterface()
	{
        $this->app['securityinterface'] = $this->app->share(function($app)
        {
            return new SecurityInterface;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('SecurityInterface', 'Ahir\Bookcase\Facades\SecurityInterface');
        });		
	}

	/**
	* Register Image Security
	*
	* @return null
	*/
	private function registerImageSecurity()
	{
        $this->app['imagesecurity'] = $this->app->share(function($app)
        {
            return new ImageSecurity;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('ImageSecurity', 'Ahir\Bookcase\Facades\ImageSecurity');
        });		
	}

	/**
	* Register File Security
	*
	* @return null
	*/
	private function registerFileSecurity()
	{
        $this->app['filecurity'] = $this->app->share(function($app)
        {
            return new FileSecurity;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('FileSecurity', 'Ahir\Bookcase\Facades\FileSecurity');
        });		
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
