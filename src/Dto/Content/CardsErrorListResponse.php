<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Список несозданных карточек товаров с ошибками
 *
 * Используется в endpoint:
 * POST https://content-api.wildberries.ru/content/v2/cards/error/list
 */
class CardsErrorListResponse extends WbApiResponseDto
{
    public array $items = [];
    public CardsErrorCursor $cursor;

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        foreach($response['data']['items'] ?? [] as $item){
            $dto->items[] = ErrorItemDto::fromArray($item);
        }

        $dto->cursor = CardsErrorCursor::fromArray($response['data']['cursor'] ?? []);

        return $dto;
    }

    /**
     * Возвращает Пакеты данных
     * @return array string[]
     */
    public function items(): array
    {
        return $this->items;
    }
}
