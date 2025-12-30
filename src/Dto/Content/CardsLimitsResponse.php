<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Лимиты карточек товаров
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/cards/limits
 */
class CardsLimitsResponse extends WbApiResponseDto
{
    public CardsLimitsDto $cardsLimits;

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $dto->cardsLimits = (isset($response['data'])) ? (CardsLimitsDto::fromArray($response['data'])) : (new CardsLimitsDto(0, 0));

        return $dto;
    }

    /**
     * Возвращает Лимиты карточек товаров
     * @return array
     */
    public function cardsLimits(): CardsLimitsDto
    {
        return $this->cardsLimits;
    }
}
