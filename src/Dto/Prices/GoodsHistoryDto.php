<?php


declare(strict_types=1);

namespace Escorp\WbApiClient\Dto\Prices;

use Escorp\WbApiClient\Exceptions\DtoMappingException;

/**
 * Размер
 */
final class GoodsHistoryDto
{
    /**
     * Артикул WB
     * @var int
     */
    public int $nmID;

    /**
     * Артикул продавца
     * @var string
     */
    public string $vendorCode;

    /**
     * ID размера. В методах Контента это поле chrtID
     * @var int
     */
    public int $sizeID;

    /**
     * Размер
     * @var string
     */
    public string $techSizeName;

    /**
     * Цена
     * @var int
     */
    public int $price;

    /**
     * Валюта, по стандарту ISO 4217
     * @var string
     */
    public string $currencyIsoCode4217;

    /**
     * Скидка, %
     * @var int
     */
    public int $discount;

    /**
     * Скидка WB Клуба, %
     * @var int|null
     */
    public ?int $clubDiscount;

    /**
     * Статус товара:2 — товар без ошибок, цена и/или скидка обновилась; 3 — есть ошибки, данные не обновились
     * @var int
     */
    public int $status;

    /**
     * Текст ошибки
     * @var string
     */
    public string $errorText;

    /**
     *
     * @param int $nmID
     * @param string $vendorCode
     * @param int $sizeID
     * @param string $techSizeName
     * @param int $price
     * @param string $currencyIsoCode4217
     * @param int $discount
     * @param int|null $clubDiscount
     * @param int $status
     * @param string $errorText
     */
    function __construct(int $nmID, string $vendorCode, int $sizeID, string $techSizeName, int $price, string $currencyIsoCode4217, int $discount, ?int $clubDiscount, int $status, string $errorText) {
        $this->nmID = $nmID;
        $this->vendorCode = $vendorCode;
        $this->sizeID = $sizeID;
        $this->techSizeName = $techSizeName;
        $this->price = $price;
        $this->currencyIsoCode4217 = $currencyIsoCode4217;
        $this->discount = $discount;
        $this->clubDiscount = $clubDiscount;
        $this->status = $status;
        $this->errorText = $errorText;
    }

    /**
     *
     * @param array $data
     * @return self
     * @throws DtoMappingException
     */
    public static function fromArray(array $data): self
    {
        foreach (['nmID', ] as $key) {
            if (!array_key_exists($key, $data)) {
                throw new DtoMappingException("GoodsHistoryDto: missing field '{$key}'");
            }
        }

        return new self(
            (int) $data['nmID'],
            (string) $data['vendorCode'],
            (int) $data['sizeID'],
            (string) $data['techSizeName'],
            (int) $data['price'],
            (string) $data['currencyIsoCode4217'],
            (int) $data['discount'],
            (isset($data['clubDiscount'])) ? ((int)$data['clubDiscount']) : (null),
            (int) $data['status'],
            (string) $data['errorText']
        );
    }
}

