<?php

namespace Escorp\WbApiClient\Api\Common;

use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Escorp\WbApiClient\Contracts\TokenProviderInterface;
use Escorp\WbApiClient\Contracts\ApiHostRegistryInterface;
use Escorp\WbApiClient\Dto\Common\PingResponseDto;

/**
 * Проверка подключения
 *
 * @author parhomey
 */
class PingApi
{
    private HttpClientInterface $http;
    private TokenProviderInterface $token;
    private ApiHostRegistryInterface $hosts;

    public function __construct(HttpClientInterface $http, TokenProviderInterface $token, ApiHostRegistryInterface $hosts)
    {
        $this->http = $http;
        $this->token = $token;
        $this->hosts = $hosts;
    }

    /**
     * Проверка подключения
     * @return PingResponseDto
     */
    public function ping(): PingResponseDto
    {
        $url = $this->hosts->get('common') . '/ping';

        $response = $this->http->request('GET', $url, [
            'headers' => ['Authorization' => $this->token->getToken()]
        ]);

        return PingResponseDto::fromArray($response);
    }
}
