<?php

namespace Escorp\WbApiClient\Api\Prices;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Prices\PricesResponseDto;
use Escorp\WbApiClient\Dto\Prices\PriceSizesResponseDto;
use Escorp\WbApiClient\Dto\Prices\QuarantineGoodsResponseDto;
use Escorp\WbApiClient\Dto\Prices\PricesBatchResponseDto;
use Escorp\WbApiClient\Dto\Prices\UploadPriceDto;
use Escorp\WbApiClient\Dto\Prices\UploadPriceSizeDto;
use Escorp\WbApiClient\Dto\Prices\UploadPricesResponseDto;
use Escorp\WbApiClient\Dto\Prices\UploadPricesBatchResponseDto;
use Escorp\WbApiClient\Dto\Prices\HistoryTaskResponseDto;
use Escorp\WbApiClient\Dto\ResponseErrorDto;
use Escorp\WbApiClient\Dto\WbApiResponseDto;
use InvalidArgumentException;

final class PricesApi extends AbstractWbApi
{
    /**
     * Возвращает домен
     *
     * @return string
     */
    private function getBaseUri(): string
    {
        return $this->hosts->get('prices');
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
     * Установить цены и скидки. Максимум 1000 товаров
     *
     * @param UploadPriceDto[] $uploadPrices
     * @return UploadPricesResponseDto
     *
     * @throws InvalidArgumentException
     */
    public function uploadPrice(array $uploadPrices): UploadPricesResponseDto
    {
        if(count($uploadPrices) > 1000){
            throw new InvalidArgumentException('uploadPrices must be an array of no more than 1000 elements');
        }

        foreach ($uploadPrices as $u) {
            if (!$u instanceof UploadPriceDto) {
                throw new InvalidArgumentException('uploadPrices must contain UploadPriceDto');
            }
        }

        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/api/v2/upload/task',
            [
                'json' => [
                    'data' => array_map(function(UploadPriceDto $uploadPrice){return $uploadPrice->toArray();}, $uploadPrices)
                ]
            ]
        );

        return UploadPricesResponseDto::fromArray($response);
    }

    /**
     * Установить цены и скидки
     * @param UploadPriceDto[] $uploadPrices
     * @param int $chunk
     * @return UploadPricesBatchResponseDto
     */
    public function uploadPriceBatch(array $uploadPrices, int $chunk = 1000): UploadPricesBatchResponseDto
    {
        $uploadPricesBatchResponseDto = new UploadPricesBatchResponseDto();

        foreach (array_chunk($uploadPrices, $chunk) as $part) {
            $uploadPricesResponseDto = $this->uploadPrice($part);

            if ($uploadPricesResponseDto->hasError()) {
                $uploadPricesBatchResponseDto->errors[] = new ResponseErrorDto(
                    $part,
                    $uploadPricesResponseDto->errorText,
                    $uploadPricesResponseDto->data
                );
                continue;
            }

            $uploadPricesBatchResponseDto->items[] = $uploadPricesResponseDto->load;

            usleep(600_000);
        }

        return $uploadPricesBatchResponseDto;
    }

    /**
     * Установить цены для размера. Максимум 1000 товаров
     *
     * @param UploadPriceSizeDto[] $uploadPriceSizes
     * @return UploadPricesResponseDto
     *
     * @throws InvalidArgumentException
     */
    public function uploadPriceSize(array $uploadPriceSizes): UploadPricesResponseDto
    {
        if(count($uploadPriceSizes) > 1000){
            throw new InvalidArgumentException('uploadPriceSizes must be an array of no more than 1000 elements');
        }

        foreach ($uploadPriceSizes as $u) {
            if (!$u instanceof UploadPriceSizeDto) {
                throw new InvalidArgumentException('uploadPriceSizes must contain UploadPriceSizeDto');
            }
        }

        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/api/v2/upload/task/size',
            [
                'json' => [
                    'data' => array_map(function(UploadPriceSizeDto $uploadPriceSize){return $uploadPriceSize->toArray();}, $uploadPriceSizes)
                ]
            ]
        );

        return UploadPricesResponseDto::fromArray($response);
    }

    /**
     * Установить цены для размеров
     *
     * @param UploadPriceSizeDto[] $uploadPriceSizes
     * @param int $chunk
     * @return UploadPricesBatchResponseDto
     */
    public function uploadPriceSizeBatch(array $uploadPriceSizes, int $chunk = 1000): UploadPricesBatchResponseDto
    {
        $uploadPricesBatchResponseDto = new UploadPricesBatchResponseDto();

        foreach (array_chunk($uploadPriceSizes, $chunk) as $part) {
            $uploadPricesResponseDto = $this->uploadPriceSize($part);

            if ($uploadPricesResponseDto->hasError()) {
                $uploadPricesBatchResponseDto->errors[] = new ResponseErrorDto(
                    $part,
                    $uploadPricesResponseDto->errorText,
                    $uploadPricesResponseDto->data
                );
                continue;
            }

            $uploadPricesBatchResponseDto->items[] = $uploadPricesResponseDto->load;

            usleep(600_000);
        }

        return $uploadPricesBatchResponseDto;
    }

    /**
     * Установить скидки WB Клуба. Не больше 1000 товаров за один запрос
     * Устанавливает скидки для товаров в рамках подписки WB Клуб.
     *
     * @param UploadClubDiscountDto[] $uploadClubDiscounts
     * @return UploadPricesResponseDto
     *
     * @throws InvalidArgumentException
     */
    public function uploadClubDiscount(array $uploadClubDiscounts): UploadPricesResponseDto
    {
        if(count($uploadClubDiscounts) > 1000){
            throw new InvalidArgumentException('uploadClubDiscounts must be an array of no more than 1000 elements');
        }

        foreach ($uploadClubDiscounts as $u) {
            if (!$u instanceof UploadClubDiscountDto) {
                throw new InvalidArgumentException('uploadClubDiscounts must contain UploadClubDiscountDto');
            }
        }

        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/api/v2/upload/task/club-discount',
            [
                'json' => [
                    'data' => array_map(function(UploadClubDiscountDto $uploadClubDiscount){return $uploadClubDiscount->toArray();}, $uploadClubDiscounts)
                ]
            ]
        );

        return UploadPricesResponseDto::fromArray($response);
    }

    /**
     * Установить скидки WB Клуба. Устанавливает скидки для товаров в рамках подписки WB Клуб.
     *
     * @param UploadClubDiscountDto[] $uploadClubDiscounts
     * @param int $chunk
     * @return UploadPricesBatchResponseDto
     */
    public function uploadClubDiscountBatch(array $uploadClubDiscounts, int $chunk = 1000): UploadPricesBatchResponseDto
    {
        $uploadPricesBatchResponseDto = new UploadPricesBatchResponseDto();

        foreach (array_chunk($uploadClubDiscounts, $chunk) as $part) {
            $uploadPricesResponseDto = $this->uploadClubDiscount($part);

            if ($uploadPricesResponseDto->hasError()) {
                $uploadPricesBatchResponseDto->errors[] = new ResponseErrorDto(
                    $part,
                    $uploadPricesResponseDto->errorText,
                    $uploadPricesResponseDto->data
                );
                continue;
            }

            $uploadPricesBatchResponseDto->items[] = $uploadPricesResponseDto->load;

            usleep(600_000);
        }

        return $uploadPricesBatchResponseDto;
    }

    /**
     * Возвращает информацию об обработанной загрузке цен и скидок.
     *
     * @param int $uploadID
     * @return HistoryTaskResponseDto
     */
    public function getHistoryTasks(int $uploadID): HistoryTaskResponseDto
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v2/history/tasks',
            [
                'query' => [
                    'uploadID' => $uploadID
                ]
            ]
        );

        return HistoryTaskResponseDto::fromArray($response);
    }

    /**
     * Возвращает информацию о товарах и об ошибках в товарах в обработанной загрузке
     *
     * @param int $uploadID
     * @param int $limit
     * @param int $offset
     * @return HistoryTaskResponseDto
     */
    public function getHistoryGoodsTask(int $uploadID, int $limit = 1000, int $offset = 0): HistoryTaskResponseDto
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v2/history/goods/task',
            [
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset,
                    'uploadID' => $uploadID
                ]
            ]
        );

        return HistoryTaskResponseDto::fromArray($response);
    }

    /**
     * Возвращает информацию про загрузку скидок в обработке.
     *
     * @param int $uploadID
     * @return HistoryTaskResponseDto
     */
    public function getBufferTasks(int $uploadID): HistoryTaskResponseDto
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v2/buffer/tasks',
            [
                'guery' => [
                    'uploadID' => $uploadID
                ]
            ]
        );

        return HistoryTaskResponseDto::fromArray($response);
    }

    /**
     * Возвращает информацию о товарах и ошибках в товарах из загрузки в обработке
     *
     * @param int $uploadID
     * @param int $limit
     * @param int $offset
     * @return HistoryTaskResponseDto
     */
    public function getBufferGoodsTask(int $uploadID, int $limit = 1000, int $offset = 0): HistoryTaskResponseDto
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v2/buffer/goods/task',
            [
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset,
                    'uploadID' => $uploadID
                ]
            ]
        );

        return HistoryTaskResponseDto::fromArray($response);
    }

    /**
     * Возвращает информацию о товарах: цены, валюту, общие скидки и скидки WB Клуба.
     *
     * @param int $limit
     * @param int $offset
     * @param int|null $nmID
     * @return type
     */
    public function getPrices(int $limit = 1000, int $offset = 0, ?int $nmID = null)
    {
        $params = [
            'limit' => $limit,
            'offset' => $offset
        ];

        if ($nmID) {
            $params['filterNmID'] = $nmID;
        }

        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v2/list/goods/filter',
            [
                'query' => $params
            ]
        );

        return PricesResponseDto::fromArray($response);
    }

    /**
     * Возвращает информацию обо всех товарах продавца
     * @return array
     */
    public function getPricesBatch(): array
    {
        $limit = 1000;
        $offset = 0;

        $result = [];

        do{
            $response = $this->getPrices($limit, $offset);

            if(empty($response->prices)){
                break;
            }

            foreach ($response->prices as $price) {
                $result[] = $price;
            }

            $offset += $limit;
            usleep(600_000);
        }while(true);

        return $result;
    }

    /**
     * Возвращает информацию о ценах
     *
     * @param array $nmIds
     * @return PricesResponseDto
     */
    public function getPricesByNmids(array $nmIds): PricesResponseDto
    {
        $nmIdsValidate = $this->normalizeNmIds($nmIds);

        $url = $this->getBaseUri() . '/api/v2/list/goods/filter';

        $response = $this->request('POST', $url, [
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
    public function getPricesByNmidsBatch(array $nmIds, int $chunk = 1000): PricesBatchResponseDto
    {
        $pricesBatchResponseDto = new PricesBatchResponseDto();

        foreach (array_chunk($nmIds, $chunk) as $part) {
            $response = $this->getPricesByNmids($part);

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

    /**
     * Метод возвращает информацию обо всех размерах одного товара: цены, валюту, общие скидки и скидки для WB Клуба. Работает только для товаров из категорий, где можно устанавливать цены отдельно для разных размеров
     * @param int $nmId
     * @param int $limit
     * @param int $offset
     * @return type
     */
    public function getPriceSizesByNmid(int $nmId, int $limit = 1000, int $offset = 0)
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v2/list/goods/size/nm',
            [
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset,
                    'nmID' => $nmId
                ]
            ]
        );

        return PriceSizesResponseDto::fromArray($response);
    }

    /**
     * Возвращает информацию о товарах в карантине
     * 
     * @param int $limit
     * @param int $offset
     * @return QuarantineGoodsResponseDto
     */
    public function getQuarantineGoods(int $limit = 1000, int $offset = 0): QuarantineGoodsResponseDto
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v2/quarantine/goods',
            [
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset
                ]
            ]
        );

        return QuarantineGoodsResponseDto::fromArray($response);
    }
}

