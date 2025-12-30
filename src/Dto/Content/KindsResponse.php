<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Пол
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/directory/kinds
 */
class KindsResponse extends WbApiResponseDto
{
    public array $kinds = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $dto->kinds = $response['data'] ?? [];

        return $dto;
    }

    /**
     * Возвращает пол
     * @return array
     */
    public function kinds(): array
    {
        return $this->kinds;
    }
}
