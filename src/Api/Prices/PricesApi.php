<?php

namespace Escorp\WbApiClient\Api\Prices;

use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Escorp\WbApiClient\Contracts\TokenProviderInterface;
use Escorp\WbApiClient\Dto\PriceDto;

final class PricesApi
{
    private const URL = 'https://discounts-prices-api.wildberries.ru/api/v2/list/goods/filter';

    private HttpClientInterface $http;
    private TokenProviderInterface $token;

    public function __construct(HttpClientInterface $http, TokenProviderInterface $token)
    {
        $this->http = $http;
        $this->token = $token;
    }

    /**
     * Возвращает информацию о ценах
     * 
     * @param array $nmIds
     * @return array | PriceDto[]
     */
    public function getPrices(array $nmIds): array
    {
        $response = $this->http->request('POST', self::URL, [
            'headers' => ['Authorization' => $this->token->getToken()],
            'json' => ['nmList' => array_values($nmIds)],
        ]);

        return array_map(
            static fn($item) => PriceDto::fromArray($item),
            $response['data']['listGoods'] ?? []
        );
    }

    /**
     * Возвращает цены
     *
     * @param array $nmIds
     * @param int $chunk
     * @return array | PriceDto[]
     */
    public function getPricesBatch(array $nmIds, int $chunk = 1000): array
    {
        $result = [];
        foreach (array_chunk($nmIds, $chunk) as $part) {
            $result = array_merge($result, $this->getPrices($part));
        }
        return $result;
    }
}

