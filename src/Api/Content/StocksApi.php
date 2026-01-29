<?php

namespace Escorp\WbApiClient\Api\Content;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Content\Stocks\StocksResponse;
use Escorp\WbApiClient\Dto\Content\Stocks\StocksBatchResponse;
use Escorp\WbApiClient\Dto\Content\Stocks\StockDto;
use Escorp\WbApiClient\Dto\ResponseErrorDto;

use InvalidArgumentException;
use Escorp\WbApiClient\Exceptions\WbApiClientException;

/**
 * остатки на складах продавца
 *
 */
class StocksApi extends AbstractWbApi
{
    /**
     * Возвращает домен
     *
     * @return string
     */
    private function getBaseUri(): string
    {
        return $this->hosts->get('marketplace');
    }

    /**
     * Возвращает остатки товаров на складе продавца
     * @param int $warehouseId
     * @param array $chrtIds
     * @return StocksResponse
     */
    public function getStocks(int $warehouseId, array $chrtIds): StocksResponse
    {
        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/api/v3/stocks/' . $warehouseId,
            [
                'json' => [
                    'chrtIds' => $chrtIds,
                ],
            ]
        );

        return StocksResponse::fromArray($response);
    }


    /**
     * Метод обновляет количество остатков товаров продавца
     *
     * @param int $warehouseId
     * @param array $stocks
     * @return type
     * @throws InvalidArgumentException
     */
    public function updateStocks(int $warehouseId, array $stocks)
    {
        if(count($stocks) > 1000){
            throw new InvalidArgumentException('stocks must be an array of no more than 1000 elements');
        }

        foreach ($stocks as $s) {
            if (!$s instanceof StockDto) {
                throw new InvalidArgumentException('stocks must contain StockDto');
            }
        }

        $response = $this->request(
            'PUT',
            $this->getBaseUri(). '/api/v3/stocks/' . $warehouseId,
            [
                'json' => [
                    'stocks' => array_map(function(StockDto $stock){return $stock->toArray();}, $stocks),
                ],
            ]
        );

        return $response;
    }

    /**
     * Метод обновляет количество остатков товаров продавца
     * @param int $warehouseId
     * @param array $stocks
     * @param int $chunk
     * @return StocksBatchResponse
     */
    public function updateStocksBatch(int $warehouseId, array $stocks, int $chunk = 1000)
    {
        $stocksBatchResponse = new StocksBatchResponse();

        foreach (array_chunk($stocks, $chunk) as $part) {
            try{
                $this->updateStocks($warehouseId, $part);
            }catch(WbApiClientException $e){
                $stocksBatchResponse->errors[] = new ResponseErrorDto(
                    $part,
                    $e->getMessage(),
                    $e
                );
            }
        }

        return $stocksBatchResponse;
    }

    /**
     * Удалить остатки товаров
     * @param int $warehouseId
     * @param array $chrtIds
     * @return type
     */
    public function deleteStocks(int $warehouseId, array $chrtIds)
    {
        $response = $this->request(
            'DELETE',
            $this->getBaseUri(). '/api/v3/stocks/' . $warehouseId,
            [
                'json' => [
                    'chrtIds' => $chrtIds,
                ],
            ]
        );

        return $response;
    }
}
