<?php

namespace Escorp\WbApiClient;

use Illuminate\Support\ServiceProvider;

class WbApiClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/wb-api-client.php',
            'wb-api-client'
        );

        $this->app->singleton(WbApiClient::class, function () {
            return new WbApiClient(
                config('wb-api-client.api_key')
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/wb-api-client.php' =>
                config_path('wb-api-client.php'),
        ], 'wb-api-client-config');
    }
}