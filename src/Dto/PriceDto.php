<?php

namespace Escorp\WbApiClient\Dto;

use Escorp\WbApiClient\Exceptions\DtoMappingException;

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
     * Артикул продавца
     * @var string
     */
    public string $vendorCode;
    public ?string $currency;
    public ?int $discount;
    public ?int $clubDiscount;
    public ?bool $editableSizePrice;
    public ?bool $isBadTurnover;
    public array $sizes;


    /**
     *
     * @param int $nmId
     * @param string $vendorCode
     * @param array $sizes
     * @param string|null $currency
     * @param int|null $discount
     * @param int|null $clubDiscount
     * @param bool|null $editableSizePrice
     * @param bool|null $isBadTurnover
     */
    public function __construct(int $nmId, string $vendorCode, array $sizes = [], ?string $currency = null, ?int $discount = null, ?int $clubDiscount = null, ?bool $editableSizePrice = null, ?bool $isBadTurnover = null)
    {
        $this->nmId = $nmId;
        $this->vendorCode = $vendorCode;
        $this->currency = $currency;
        $this->discount = $discount;
        $this->clubDiscount = $clubDiscount;
        $this->editableSizePrice = $editableSizePrice;
        $this->isBadTurnover = $isBadTurnover;
        $this->sizes = $sizes;
    }

    /**
     *
     * @param array $data
     * @return self
     * @throws DtoMappingException
     */
    public static function fromArray(array $data): self
    {
        foreach (['nmID','vendorCode'] as $key) {
            if (!array_key_exists($key, $data)) {
                throw new DtoMappingException("PriceDto: missing field '{$key}'");
            }
        }

        $sizes = [];
        foreach ($data['sizes'] ?? [] as $size) {
            $sizes[] = PriceSizeDto::fromArray($size);
        }

        return new self(
            (int) $data['nmID'],
            (string) $data['vendorCode'],
            $sizes,
            isset($data['currencyIsoCode4217']) ? (string)$data['currencyIsoCode4217'] : null,
            isset($data['discount']) ? (int)$data['discount'] : null,
            isset($data['clubDiscount']) ? (int)$data['clubDiscount'] : null,
            isset($data['editableSizePrice']) ? (bool)$data['editableSizePrice'] : null,
            isset($data['isBadTurnover']) ? (bool)$data['isBadTurnover'] : null,
        );
    }
}

