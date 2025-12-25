<?php

namespace Escorp\WbApiClient\Api\Common;

use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Escorp\WbApiClient\Contracts\TokenProviderInterface;
use Escorp\WbApiClient\Contracts\ApiHostRegistryInterface;
use Escorp\WbApiClient\Dto\Common\SellerInfoResponseDto;

/**
 * Информация о продавце
 *
 * @author parhomey
 */
class SellerApi
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
     * Метод позволяет получать наименование продавца и ID его профиля.
     * @return SellerInfoResponseDto
     */
    public function sellerInfo(): SellerInfoResponseDto
    {
        $url = $this->hosts->get('common') . '/api/v1/seller-info';

        $response = $this->http->request('GET', $url, [
            'headers' => ['Authorization' => $this->token->getToken()]
        ]);

        return SellerInfoResponseDto::fromArray($response);
    }
}
