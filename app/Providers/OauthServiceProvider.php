<?php

namespace Meritocracy\Providers;

use Illuminate\Support\ServiceProvider;

use Meritocracy\User;
use Meritocracy\Auth\CustomUserProvider;

class OauthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->extend('api_oauth', function ($app) {
            return new CustomUserProvider(new User, $app);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
