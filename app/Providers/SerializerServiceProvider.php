<?php

namespace Meritocracy\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
class SerializerServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->singleton('jms.serializer', function ($app) {
            $serializer = \JMS\Serializer\SerializerBuilder::create()->setCacheDir(storage_path())->build();
            return $serializer;
        });

    }
}
