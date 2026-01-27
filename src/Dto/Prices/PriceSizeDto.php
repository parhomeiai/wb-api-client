<?php


declare(strict_types=1);

namespace Escorp\WbApiClient\Dto\Prices;

use Escorp\WbApiClient\Exceptions\DtoMappingException;

/**
 * Размер
 */
final class PriceSizeDto
{
    /**
     * ID размера
     * @var int
     */
    public int $sizeId;

    /**
     * Цена
     * @var int
     */
    public int $price;

    /**
     * Цена со скидкой
     * @var float
     */
    public float $discountedPrice;

    /**
     * Цена со скидкой, включая скидку WB Клуба
     * @var float
     */
    public float $clubDiscountedPrice;

    /**
     * Размер товара
     * @var string
     */
    public string $techSizeName;

    /**
     * Артикул WB
     * @var int|null
     */
    public ?int $nmID;

    /**
     * Артикул продавца
     * @var string|null
     */
    public ?string $vendorCode;

    /**
     * Валюта, по стандарту ISO 4217
     * @var string|null
     */
    public ?string $currencyIsoCode4217;

    /**
     * Скидка, %
     * @var int|null
     */
    public ?int $discount;

    /**
     * Можно ли устанавливать цены отдельно для разных размеров (зависит от категории товара)
     * @var bool|null
     */
    public ?bool $editableSizePrice;

    /**
     * Признак неликвидного товара
     * @var bool|null
     */
    public ?bool $isBadTurnover;

    /**
     *
     * @param int $sizeId
     * @param int $price
     * @param float $discountedPrice
     * @param float $clubDiscountedPrice
     * @param string $techSizeName
     * @param int|null $nmID
     * @param string|null $vendorCode
     * @param string|null $currencyIsoCode4217
     * @param int|null $discount
     * @param bool|null $editableSizePrice
     * @param bool|null $isBadTurnover
     */
    function __construct(int $sizeId, int $price, float $discountedPrice, float $clubDiscountedPrice, string $techSizeName, ?int $nmID = null, ?string $vendorCode = null, ?string $currencyIsoCode4217 = null, ?int $discount = null, ?bool $editableSizePrice = null, ?bool $isBadTurnover = null)
    {
        $this->sizeId = $sizeId;
        $this->price = $price;
        $this->discountedPrice = $discountedPrice;
        $this->clubDiscountedPrice = $clubDiscountedPrice;
        $this->techSizeName = $techSizeName;
        $this->nmID = $nmID;
        $this->vendorCode = $vendorCode;
        $this->currencyIsoCode4217 = $currencyIsoCode4217;
        $this->discount = $discount;
        $this->editableSizePrice = $editableSizePrice;
        $this->isBadTurnover = $isBadTurnover;
    }

    /**
     *
     * @param array $data
     * @return self
     * @throws DtoMappingException
     */
    public static function fromArray(array $data): self
    {
        foreach (['sizeID', 'price', 'discountedPrice', 'clubDiscountedPrice', 'techSizeName'] as $key) {
            if (!array_key_exists($key, $data)) {
                throw new DtoMappingException("PriceSizeDto: missing field '{$key}'");
            }
        }

        return new self(
            (int) $data['sizeID'],
            (int) $data['price'],
            (float) $data['discountedPrice'],
            (float) $data['clubDiscountedPrice'],
            (string) $data['techSizeName'],
            (isset($data['nmID'])) ? ((int)$data['nmID']) : (null),
            (isset($data['vendorCode'])) ? ((string)$data['vendorCode']) : (null),
            (isset($data['currencyIsoCode4217'])) ? ((string)$data['currencyIsoCode4217']) : (null),
            (isset($data['discount'])) ? ((int)$data['discount']) : (null),
            (isset($data['editableSizePrice'])) ? ((bool)$data['editableSizePrice']) : (null),
            (isset($data['isBadTurnover'])) ? ((bool)$data['isBadTurnover']) : (null),
        );
    }
}

