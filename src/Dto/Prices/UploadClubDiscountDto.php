<?php

namespace Escorp\WbApiClient\Dto\Prices;

/**
 * Скидка wb-клуба
 */
final class UploadClubDiscountDto
{
    /**
     * Артикул WB
     * @var int
     */
    private int $nmId;

    /**
     * Скидка WB Клуба, %
     * @var int
     */
    private int $clubDiscount;

    /**
     *
     * @param int $nmId
     * @param int $clubDiscount
     */
    function __construct(int $nmId, int $clubDiscount)
    {
        $this->nmId = $nmId;
        $this->clubDiscount = $clubDiscount;
    }

    function getNmId(): int
    {
        return $this->nmId;
    }

    function getClubDiscount(): int
    {
        return $this->clubDiscount;
    }

    function setNmId(int $nmId): void
    {
        $this->nmId = $nmId;
    }

    function setClubDiscount(int $clubDiscount): void 
    {
        $this->clubDiscount = $clubDiscount;
    }

    public function toArray(): array
    {
        return array_filter([
            'nmID' => $this->nmID,
            'clubDiscount' => $this->clubDiscount,
        ], fn($v) => $v !== null);
    }
}

