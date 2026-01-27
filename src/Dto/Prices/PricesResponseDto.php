<?php

declare(strict_types=1);

namespace Escorp\WbApiClient\Dto\Prices;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

final class PricesResponseDto extends WbApiResponseDto
{
    /** @var PriceDto[] */
    public array $prices = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText);

        $items = $response['data']['listGoods'] ?? [];

        foreach ($items as $item) {
            $dto->prices[] = PriceDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает товары с ценами
     * @return array
     */
    public function prices(): array
    {
        return $this->prices;
    }
}

