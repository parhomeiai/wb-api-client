<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Генерация баркодов
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/barcodes
 */
class BarcodesResponse extends WbApiResponseDto
{
    /**
     *
     * @var array string[]
     */
    public array $barcodes = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $dto->barcodes = isset($response['data']) && is_array($response['data'])
            ? array_map('strval', $response['data'])
            : [];

        return $dto;
    }

    /**
     * Возвращает баркоды
     * @return array string[]
     */
    public function barcodes(): array
    {
        return $this->barcodes;
    }
}
