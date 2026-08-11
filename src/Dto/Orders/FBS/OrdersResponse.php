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

    /**
     * Параметр пагинации
     * @var int
     */
    public int $next = 0;

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['orders'] ?? [];

        foreach($items as $item){
            $dto->orders[] = OrderDto::fromArray($item);
        }

        $dto->next = $response['next'] ?? 0;

        return $dto;
    }

    /**
     * Возвращает заказы
     * @return OrderDto[]
     */
    public function orders(): array
    {
        return $this->orders;
    }
}
