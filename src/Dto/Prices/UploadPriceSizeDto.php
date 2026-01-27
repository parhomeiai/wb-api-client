<?php

namespace Escorp\WbApiClient\Dto\Prices;

/**
 * Размер Товара и его цена
 */
final class UploadPriceSizeDto
{
    /**
     * Артикул WB
     * @var int
     */
    private int $nmId;

    /**
     * ID размера.
     * @var int
     */
    private int $sizeID;

    /**
     * Цена
     * @var int
     */
    private int $price;

    /**
     *
     * @param int $nmId
     * @param int $sizeID
     * @param int $price
     */
    function __construct(int $nmId, int $sizeID, int $price) {
        $this->nmId = $nmId;
        $this->sizeID = $sizeID;
        $this->price = $price;
    }

    function getNmId(): int
    {
        return $this->nmId;
    }

    function getSizeID(): int
    {
        return $this->sizeID;
    }

    function getPrice(): int
    {
        return $this->price;
    }

    function setNmId(int $nmId): void
    {
        $this->nmId = $nmId;
    }

    function setSizeID(int $sizeID): void
    {
        $this->sizeID = $sizeID;
    }

    function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function toArray(): array
    {
        return array_filter([
            'nmID' => $this->nmId,
            'sizeID' => $this->sizeID,
            'price' => $this->price,
        ], fn($v) => $v !== null);
    }
}

