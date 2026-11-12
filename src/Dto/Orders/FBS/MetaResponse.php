<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Получить идентификаторы маркировки сборочных заданий
 *
 * Используется в endpoint:
 * POST https://marketplace-api.wildberries.ru/api/marketplace/v3/orders/meta
 */
class MetaResponse extends WbApiResponseDto
{
    /**
     *
     * @var MetaOrderDto[]
     */
     public array $orders = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['orders'] ?? [];

        foreach($items as $item){
            $dto->orders[] = MetaOrderDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает заказы
     * @return MetaOrderDto[]
     */
    public function orders(): array
    {
        return $this->orders;
    }
}
