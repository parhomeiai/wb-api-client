<?php

namespace Escorp\WbApiClient\Dto\Content\Stocks;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Получить остатки товаров
 *
 * Используется в endpoint:
 * POST https://marketplace-api.wildberries.ru/api/v3/stocks/{warehouseId}
 */
class StocksResponse extends WbApiResponseDto
{
    /**
     *
     * @var StockDto[]
     */
    public array $stocks = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['stocks'] ?? [];

        foreach($items as $item){
            $dto->stocks[] = StockDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает остатки
     * @return StockDto[]
     */
    public function stocks(): array
    {
        return $this->stocks;
    }
}
