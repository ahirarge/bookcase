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
        $this->app['bookcase'] = $this->app->share(function($app)
        {
            return new Bookcase(
                    new Security\FileSecurity,
                    new Security\ImageSecurity
                );
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
