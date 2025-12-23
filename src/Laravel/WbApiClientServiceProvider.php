<?php

namespace Escorp\WbApiClient\Laravel;

use Escorp\WbApiClient\WbApiClient;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use Escorp\WbApiClient\Api\Prices\PricesApi;
use Escorp\WbApiClient\Auth\StaticTokenProvider;
use Escorp\WbApiClient\Http\GuzzleHttpClient;

class WbApiClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/wb-api-client.php', 'wb-api-client'
        );

        $this->app->singleton(WbApiClient::class, function () {
            $http = new GuzzleHttpClient(
                new Client(['timeout' => config('wb-api-client.http.timeout')]),
                config('wb-api-client.http.retry.times'),
                config('wb-api-client.http.retry.sleep_ms')
            );

            $token = new StaticTokenProvider(config('wb-api-client.api_key'));

            return new WbApiClient(
                new PricesApi($http, $token)
            );
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