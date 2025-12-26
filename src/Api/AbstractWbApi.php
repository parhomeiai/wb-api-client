<?php

namespace Escorp\WbApiClient\Api;

use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Escorp\WbApiClient\Contracts\TokenProviderInterface;
use Escorp\WbApiClient\Contracts\ApiHostRegistryInterface;

/**
 * Базовый класс для всех Domain API
 *
 * @author parhomey
 */
abstract class AbstractWbApi
{
    protected HttpClientInterface $http;
    protected TokenProviderInterface $token;
    protected ApiHostRegistryInterface $hosts;

    public function __construct(
        HttpClientInterface $http,
        TokenProviderInterface $token,
        ApiHostRegistryInterface $hosts)
    {
        $this->http = $http;
        $this->token = $token;
        $this->hosts = $hosts;
    }

    /**
     * Выполняет запрос, подставляет токен
     *
     * @param string $method
     * @param string $url
     * @param array $options
     * @return array
     */
    protected function request(string $method, string $url, array $options = []): array
    {
        if(!isset($options['headers']['Authorization'])){
            $options['headers']['Authorization'] = $this->token->getToken();
        }

        $response = $this->http->request($method, $url, $options);

//        if (isset($response['error']) && $response['error'] === true) {
//            $msg = $response['errorText'] ?? 'Unknown WB API error';
//            throw new WbApiClientException($msg);
//        }

        return $response;
    }
}
