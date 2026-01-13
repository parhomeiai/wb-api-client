<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Список карточек товаров
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/get/cards/list
 */
class CardsListResponse extends WbApiResponseDto
{
    public array $cards = [];
    public CardsCursor $cursor;

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        foreach($response['cards'] ?? [] as $card){
            $dto->cards[] = ProductCardDto::fromArray($card);
        }
//        $dto->cards = $response['cards'];

        $dto->cursor = CardsCursor::fromArray($response['cursor'] ?? []);

        return $dto;
    }

    /**
     * Возвращает карточки товаров
     * @return array string[]
     */
    public function cards(): array
    {
        return $this->cards;
    }
}
