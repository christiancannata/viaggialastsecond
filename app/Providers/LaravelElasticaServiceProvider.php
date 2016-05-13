<?php
namespace Meritocracy\Providers;

use Elastica\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Config;

/**
 * Laravel Elastica Service Provider
 *
 * @package laravel-elastica
 */
class LaravelElasticaServiceProvider extends ServiceProvider
{
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
        // $this->package('srtfisher/laravel-elastica');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('elastica', function ($app) {


            return new Client(['host' => '127.0.0.1',
                'port' => 9200]);
        });


    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['elastica'];
    }

}
