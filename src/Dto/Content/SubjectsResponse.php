<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Список предметов
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/object/all
 */
class SubjectsResponse extends WbApiResponseDto
{
    public array $subjects = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['data'] ?? [];

        foreach ($items as $item) {
            $dto->subjects[] = SubjectDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает предметы
     * @return array
     */
    public function subjects(): array
    {
        return $this->subjects;
    }
}
