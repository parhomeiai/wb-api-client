<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос ТНВЭД-код
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/directory/tnved
 */
class TnvedResponse extends WbApiResponseDto
{
    public array $tnved = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['data'] ?? [];

        foreach ($items as $item) {
            $dto->tnved[] = TnvedDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает ТНВЭД коды
     * @return array
     */
    public function tnved(): array
    {
        return $this->tnved;
    }
}
