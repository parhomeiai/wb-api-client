<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Список ярлыков
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/tags
 */
class TagsResponse extends WbApiResponseDto
{
    public array $tags = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['data'] ?? [];

        foreach ($items as $item) {
            $dto->tags[] = TagDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает ярлыки
     * @return array
     */
    public function tags(): array
    {
        return $this->tags;
    }
}
