<?php

declare(strict_types=1);

namespace Escorp\WbApiClient\Dto\Prices;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

final class QuarantineGoodsResponseDto extends WbApiResponseDto
{
    /** @var QuarantineGoodDto[] */
    public array $goods = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText);

        $items = $response['data']['quarantineGoods'] ?? [];

        foreach ($items as $item) {
            $dto->goods[] = QuarantineGoodDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает товары на карантине
     * @return QuarantineGoodDto[]
     */
    public function goods(): array
    {
        return $this->goods;
    }
}

