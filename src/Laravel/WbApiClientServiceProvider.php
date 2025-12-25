<?php

namespace Escorp\WbApiClient\Laravel;

use Escorp\WbApiClient\WbApiClient;
use Escorp\WbApiClient\Factory\WbApiClientFactory;
use Illuminate\Support\ServiceProvider;

class WbApiClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/wb-api-client.php', 'wb-api-client'
        );

        $this->app->singleton(WbApiClient::class, function () {
            return WbApiClientFactory::make(
                config('wb-api-client.api_key'),
                [
                    'timeout'        => config('wb-api-client.http.timeout'),
                    'retry_times'    => config('wb-api-client.http.retry.times'),
                    'retry_sleep_ms' => config('wb-api-client.http.retry.sleep_ms'),
                ]
            );

            /*
            $psr18 = new Psr18HttpClient(
                new GuzzleClient(['timeout' => config('wb-api-client.http.timeout')]),
                new HttpFactory(),
                new HttpFactory()
            );


            $http = new GuzzleHttpClient(
                $psr18,
                config('wb-api-client.http.retry.times'),
                config('wb-api-client.http.retry.sleep_ms')
            );

            $token = new StaticTokenProvider(config('wb-api-client.api_key'));

            return new WbApiClient(
                new PricesApi($http, $token)
            );*/
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/wb-api-client.php' =>
                config_path('wb-api-client.php'),
        ], 'wb-api-client-config');
    }
}