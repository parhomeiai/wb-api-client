<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Получить все сборочные задания для повторной отгрузки
 *
 * Используется в endpoint:
 * GET https://marketplace-api.wildberries.ru/api/v3/supplies/orders/reshipment
 */
class OrdersReshipmentResponse extends WbApiResponseDto
{
    /**
     *
     * @var OrderReshipmentDto[]
     */
    public array $ordersReshipments = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['orders'] ?? [];

        foreach($items as $item){
            $dto->ordersReshipments[] = OrderReshipmentDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает сборочные задания для повторной отгрузки
     * @return OrderReshipmentDto[]
     */
    public function ordersReshipments(): array
    {
        return $this->ordersReshipments;
    }
}
