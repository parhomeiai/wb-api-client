<?php

namespace Escorp\WbApiClient\Dto\Prices;

use Escorp\WbApiClient\Exceptions\DtoMappingException;

/**
 * Информация о товарах в карантине
 */
final class QuarantineGoodDto
{
    /**
     * Артикул WB
     * @var int
     */
    public int $nmId;

    /**
     *
     * @var int|null
     */
    public ?int $sizeID;

    /**
     *
     * @var string
     */
    public string $techSizeName;

    /**
     * Валюта по стандарту ISO 4217
     * @var string
     */
    public string $currencyIsoCode4217;

    /**
     * Новая цена продавца до скидки
     * @var float
     */
    public float $newPrice;

    /**
     * Текущая цена продавца до скидки
     * @var float
     */
    public float $oldPrice;

    /**
     * Новая скидка продавца, %
     * @var int
     */
    public int $newDiscount;

    /**
     * Текущая скидка продавца, %
     * @var int
     */
    public int $oldDiscount;

    /**
     * Разница: newPrice * (1 - newDiscount / 100) - oldPrice * (1 - oldDiscount / 100)
     * @var float
     */
    public float $priceDiff;

    /**
     *
     * @param int $nmId
     * @param int|null $sizeID
     * @param string $techSizeName
     * @param string $currencyIsoCode4217
     * @param float $newPrice
     * @param float $oldPrice
     * @param int $newDiscount
     * @param int $oldDiscount
     * @param float $priceDiff
     */
    function __construct(int $nmId, ?int $sizeID, string $techSizeName, string $currencyIsoCode4217, float $newPrice, float $oldPrice, int $newDiscount, int $oldDiscount, float $priceDiff)
    {
        $this->nmId = $nmId;
        $this->sizeID = $sizeID;
        $this->techSizeName = $techSizeName;
        $this->currencyIsoCode4217 = $currencyIsoCode4217;
        $this->newPrice = $newPrice;
        $this->oldPrice = $oldPrice;
        $this->newDiscount = $newDiscount;
        $this->oldDiscount = $oldDiscount;
        $this->priceDiff = $priceDiff;
    }

        /**
     *
     * @param array $data
     * @return self
     * @throws DtoMappingException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['nmID'],
            isset($data['sizeID']) ? (int)$data['sizeID'] : null,
            (string) $data['techSizeName'],
            (string) $data['currencyIsoCode4217'],
            (float) $data['newPrice'],
            (float) $data['oldPrice'],
            (int) $data['newDiscount'],
            (int) $data['oldDiscount'],
            (float) $data['priceDiff'],
        );
    }
}

