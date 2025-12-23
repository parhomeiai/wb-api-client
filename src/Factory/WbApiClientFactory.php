<?php

declare(strict_types=1);

namespace Escorp\WbApiClient\Factory;

use GuzzleHttp\Client as GuzzleClient;
use Escorp\WbApiClientt\Api\Prices\PricesApi;
use Escorp\WbApiClient\Auth\StaticTokenProvider;
use Escorp\WbApiClient\Http\GuzzleHttpClient;
use Escorp\WbApiClient\WbApiClient;

final class WbApiClientFactory
{
    /**
     * Создание клиента
     *
     * @param string $token WB API token
     * @param array{
     *   timeout?: int,
     *   retry_times?: int,
     *   retry_sleep_ms?: int
     * } $options
     */
    public static function make(string $token, array $options = []): WbApiClient
    {
        $timeout = $options['timeout'] ?? 10;
        $retryTimes = $options['retry_times'] ?? 3;
        $retrySleepMs = $options['retry_sleep_ms'] ?? 300;

        // 1. HTTP engine
        $guzzle = new GuzzleClient([
            'timeout' => $timeout,
        ]);

        // 2. HTTP client with retry
        $httpClient = new GuzzleHttpClient(
            $guzzle,
            $retryTimes,
            $retrySleepMs
        );

        // 3. Token provider
        $tokenProvider = new StaticTokenProvider($token);

        // 4. Domain API
        $pricesApi = new PricesApi($httpClient, $tokenProvider);

        // 5. Root client
        return new WbApiClient($pricesApi);
    }
}

