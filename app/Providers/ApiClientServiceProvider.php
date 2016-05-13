<?php

namespace Meritocracy\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
class ApiClientServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->singleton('client.api', function ($app) {
            return new Client(["base_uri"=>env('API_MERITOCRACY_ENDPOINT'),'headers' => ['Accept-Language' => $this->app->getLocale()]]);
        });

    }
}
