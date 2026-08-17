<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Получить ID сборочных заданий поставки
 *
 * Используется в endpoint:
 * GET https://marketplace-api.wildberries.ru/api/marketplace/v3/supplies/{supplyId}/order-ids
 */
class SupplyOrdersIdsResponse extends WbApiResponseDto
{
    /**
     *
     * @var array
     */
    public array $orderIds;

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $dto->orderIds = $wbApiResponseDto->data['orderIds'] ?? [];

        return $dto;
    }

    /**
     * Возвращает ID сборочных заданий поставки
     * @return array
     */
    public function orderIds(): array
    {
        return $this->orderIds;
    }
}
