<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Бренды
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/api/content/v1/brands
 */
class BrandsResponse extends WbApiResponseDto
{
    public array $brands = [];

    public int $next = 0;

    public int $total = 0;

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['brands'] ?? [];

        foreach ($items as $item) {
            $dto->brands[] = BrandDto::fromArray($item);
        }

        $dto->next = $response['next'] ?? 0;
        $dto->total = $response['total'] ?? 0;

        return $dto;
    }

    /**
     * Возвращает бренды
     * @return array
     */
    public function brands(): array
    {
        return $this->brands;
    }
}
