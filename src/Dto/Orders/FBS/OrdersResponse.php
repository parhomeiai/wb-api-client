<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Получить список новых сборочных заданий
 *
 * Используется в endpoint:
 * GET https://marketplace-api.wildberries.ru/api/v3/orders/new
 */
class OrdersResponse extends WbApiResponseDto
{
    /**
     *
     * @var OrderDto[]
     */
    public array $orders = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['orders'] ?? [];

        foreach($items as $item){
            $dto->orders[] = OrderDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает остатки
     * @return OrderDto[]
     */
    public function orders(): array
    {
        return $this->orders;
    }
}
