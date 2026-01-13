<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Создание карточек товаров
 *
 * Используется в endpoint:
 * POST https://content-api.wildberries.ru/content/v2/cards/upload
 */
class ProductCardsUploadResponse extends WbApiResponseDto
{
    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        return $dto;
    }
}
