<?php


declare(strict_types=1);

namespace Escorp\WbApiClient\Dto;

use Escorp\WbApiClient\Exceptions\DtoMappingException;

/**
 * Размер
 */
final class PriceSizeDto
{
    public int $sizeId;
    public int $price;
    public float $discountedPrice;
    public float $clubDiscountedPrice;
    public string $techSizeName;

    /**
     *
     * @param int $sizeId
     * @param int $price
     * @param float $discountedPrice
     * @param float $clubDiscountedPrice
     * @param string $techSizeName
     */
    public function __construct(
        int $sizeId,
        int $price,
        float $discountedPrice,
        float $clubDiscountedPrice,
        string $techSizeName
    ) {
        $this->sizeId = $sizeId;
        $this->price = $price;
        $this->discountedPrice = $discountedPrice;
        $this->clubDiscountedPrice = $clubDiscountedPrice;
        $this->techSizeName = $techSizeName;
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
            (string) $data['techSizeName']
        );
    }
}

