<?php

namespace Meritocracy\Providers;

use Illuminate\Support\ServiceProvider;
use Meritocracy\Validation\DoctrineValidator;

class DoctrineValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('doctrine.validator', function ($app) {
            $validator = new DoctrineValidator();
            return $validator;
        });

    }
}
