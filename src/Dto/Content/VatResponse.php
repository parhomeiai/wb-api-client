<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Ставка НДС
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/directory/vat
 */
class VatResponse extends WbApiResponseDto
{
    public array $vat = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $dto->vat = $response['data'] ?? [];

        return $dto;
    }

    /**
     * Возвращает значения характеристики Ставка НДС
     * @return array
     */
    public function vat(): array
    {
        return $this->vat;
    }
}
