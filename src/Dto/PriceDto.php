<?php

namespace Escorp\WbApiClient\Dto;

/**
 * Информация о цене товара
 */
final class PriceDto
{
    /**
     * Артикул WB
     * @var int
     */
    public int $nmId;

    /**
     * Цена
     * @var int
     */
    public int $price;

    /**
     * Скидка, %
     * @var int
     */
    public int $discount;

    public function __construct(int $nmId, int $price, int $discount)
    {
        $this->nmId = $nmId;
        $this->price = $price;
        $this->discount = $discount;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['nmId'],
            $data['price'],
            $data['discount'] ?? 0
        );
    }
}

