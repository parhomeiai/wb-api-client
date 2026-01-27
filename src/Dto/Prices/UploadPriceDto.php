<?php

namespace Escorp\WbApiClient\Dto\Prices;

/**
 * Товар, цена и скидки для него
 */
final class UploadPriceDto
{
    /**
     * Артикул WB
     * @var int
     */
    private int $nmId;

    /**
     * Цена
     * @var int
     */
    private int $price;

    /**
     * Скидка, %
     * @var int
     */
    private int $discount;

    /**
     *
     * @param int $nmId
     * @param int $price
     * @param int $discount
     */
    function __construct(int $nmId, int $price, int $discount) {
        $this->nmId = $nmId;
        $this->price = $price;
        $this->discount = $discount;
    }

    function setNmId(int $nmId): void {
        $this->nmId = $nmId;
    }

    function setPrice(int $price): void {
        $this->price = $price;
    }

    function setDiscount(int $discount): void {
        $this->discount = $discount;
    }

    function getNmId(): int {
        return $this->nmId;
    }

    function getPrice(): int {
        return $this->price;
    }

    function getDiscount(): int {
        return $this->discount;
    }

    public function toArray(): array
    {
        return array_filter([
            'nmID' => $this->nmId,
            'price' => $this->price,
            'discount' => $this->discount
        ], fn($v) => $v !== null);
    }
}

