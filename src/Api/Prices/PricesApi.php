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
     * Валидация Артикулов WB (должно быть положительное целое число)
     * @param array $nmIds
     * @return array
     * @throws \InvalidArgumentException
     */
    private function normalizeNmIds(array $nmIds): array
    {
        if (empty($nmIds)) {
            throw new \InvalidArgumentException('nmIds array is empty');
        }

        return array_map(function ($id) {
            if (!is_numeric($id)) {
                throw new \InvalidArgumentException(
                    'nmID must be integer, got: ' . gettype($id)
                );
            }

            $int = (int) $id;

            if ($int <= 0) {
                throw new \InvalidArgumentException(
                    'nmID must be positive integer, got: ' . $id
                );
            }

            return $int;
        }, array_values($nmIds));
    }

    /**
     * Возвращает информацию о ценах
     *
     * @param array $nmIds
     * @return PricesResponseDto
     */
    public function getPrices(array $nmIds): PricesResponseDto
    {
        $nmIds = $this->normalizeNmIds($nmIds);

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

        $pricesResponseDto->errorText = trim($pricesResponseDto->errorText, " \t\n\r\0\x0B;");

        return $pricesResponseDto;
    }
}

