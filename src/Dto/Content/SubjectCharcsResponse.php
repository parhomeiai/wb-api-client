<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Характеристики предмета
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/object/charcs/{subjectId}
 */
class SubjectCharcsResponse extends WbApiResponseDto
{
    public array $charcs = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['data'] ?? [];

        foreach ($items as $item) {
            $dto->charcs[] = CharcDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает характеристики
     * @return array
     */
    public function charcs(): array
    {
        return $this->charcs;
    }
}
