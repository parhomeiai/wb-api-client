<?php

namespace Escorp\WbApiClient\Api\Common;

use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Escorp\WbApiClient\Contracts\TokenProviderInterface;
use Escorp\WbApiClient\Dto\Common\PingResponseDto;

/**
 * Проверка подключения
 *
 * @author parhomey
 */
class PingApi
{
    private const URL = 'https://common-api.wildberries.ru/ping';

    private HttpClientInterface $http;
    private TokenProviderInterface $token;

    public function __construct(HttpClientInterface $http, TokenProviderInterface $token)
    {
        $this->http = $http;
        $this->token = $token;
    }

    /**
     * Проверка подключения
     * @return PingResponseDto
     */
    public function ping(): PingResponseDto
    {
        $response = $this->http->request('GET', self::URL, [
            'headers' => ['Authorization' => $this->token->getToken()]
        ]);

        return PingResponseDto::fromArray($response);
    }
}
