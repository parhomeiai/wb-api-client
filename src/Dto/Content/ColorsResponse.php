<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Цвет
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/directory/colors
 */
class ColorsResponse extends WbApiResponseDto
{
    public array $colors = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['data'] ?? [];

        foreach ($items as $item) {
            $dto->colors[] = ColorDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает цвета
     * @return array
     */
    public function colors(): array
    {
        return $this->colors;
    }
}
