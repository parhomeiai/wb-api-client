<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Сезон
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/directory/seasons
 */
class SeasonsResponse extends WbApiResponseDto
{
    public array $seasons = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $dto->seasons = $response['data'] ?? [];

        return $dto;
    }

    /**
     * Возвращает значения характеристики Сезон
     * @return array
     */
    public function seasons(): array
    {
        return $this->seasons;
    }
}
