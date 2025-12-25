<?php

namespace Escorp\WbApiClient\Api\Prices;

use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Escorp\WbApiClient\Contracts\TokenProviderInterface;
use Escorp\WbApiClient\Contracts\ApiHostRegistryInterface;
use Escorp\WbApiClient\Dto\PricesResponseDto;
use Escorp\WbApiClient\Dto\PricesBatchResponseDto;
use Escorp\WbApiClient\Dto\ResponseErrorDto;

final class PricesApi
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
        $nmIdsValidate = $this->normalizeNmIds($nmIds);

        $url = $this->hosts->get('prices') . '/api/v2/list/goods/filter';

        $response = $this->http->request('POST', $url, [
            'headers' => ['Authorization' => $this->token->getToken()],
            'json' => ['nmList' => array_values($nmIdsValidate)],
        ]);

        return PricesResponseDto::fromArray($response);
    }

    /**
     * Возвращает цены
     *
     * @param array $nmIds
     * @param int $chunk
     * @return PricesBatchResponseDto
     */
    public function getPricesBatch(array $nmIds, int $chunk = 1000): PricesBatchResponseDto
    {
        $pricesBatchResponseDto = new PricesBatchResponseDto();

        foreach (array_chunk($nmIds, $chunk) as $part) {
            $response = $this->getPrices($part);

            if ($response->hasError()) {
                $pricesBatchResponseDto->errors[] = new ResponseErrorDto(
                    $part,
                    $response->errorText,
                    $response->data
                );
                continue;
            }

            foreach ($response->prices as $priceDto) {
                $pricesBatchResponseDto->items[$priceDto->nmId][] = $priceDto;
                $pricesBatchResponseDto->prices[] = $priceDto;
            }
        }

        return $pricesBatchResponseDto;
    }
}

