<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Получить статусы сборочных заданий
 *
 * Используется в endpoint:
 * POST https://marketplace-api.wildberries.ru/api/v3/orders/status
 */
class OrdersStatusResponse extends WbApiResponseDto
{
    /**
     *
     * @var OrderStatusDto[]
     */
    public array $ordersStatuses = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['orders'] ?? [];

        foreach($items as $item){
            $dto->ordersStatuses[] = OrderStatusDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает статусы сборочных заданий
     * @return OrderStatusDto[]
     */
    public function ordersStatuses(): array
    {
        return $this->ordersStatuses;
    }
}
