<?php

namespace Escorp\WbApiClient\Api\Prices;

use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Escorp\WbApiClient\Contracts\TokenProviderInterface;
use Escorp\WbApiClient\Dto\PricesResponseDto;

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
     * @return PricesResponseDto
     */
    public function getPrices(array $nmIds): PricesResponseDto
    {
        $response = $this->http->request('POST', self::URL, [
            'headers' => ['Authorization' => $this->token->getToken()],
            'json' => ['nmList' => array_values($nmIds)],
        ]);

        return PricesResponseDto::fromArray($response);
    }

    /**
     * Возвращает цены
     *
     * @param array $nmIds
     * @param int $chunk
     * @return PricesResponseDto
     */
    public function getPricesBatch(array $nmIds, int $chunk = 1000): PricesResponseDto
    {
        $pricesResponseDto = new PricesResponseDto(null, false, '');

        foreach (array_chunk($nmIds, $chunk) as $part) {
            $response = $this->getPrices($part);

            $pricesResponseDto->prices = array_merge($pricesResponseDto->prices, $response->prices);

            if ($response->hasError()) {
                $pricesResponseDto->error = true;
                $pricesResponseDto->errorText .= $response->errorText . '; ';
            }
        }

        return $pricesResponseDto;
    }
}

