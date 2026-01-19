<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Размеры товара
 *
 * @author parhomey
 */
class ProductSizeDto
{
    /**
     * Числовой ID размера для данного артикула WB
     * @var int
     */
    public int $chrtID;

    /**
     * Размер товара (А, XXL, 57 и др.)
     * @var string
     */
    public string $techSize;

    /**
     * Российский размер товара
     * @var string
     */
    public string $wbSize;

    /**
     * Цена товара
     * @var int|null
     */
    public ?int $price;

    /**
     * Баркод товара
     * @var array|string[]
     */
    public array $skus = [];

    /**
     *
     * @param int $chrtID
     * @param string $techSize
     * @param string $wbSize
     * @param int $price
     * @param array $skus
     */
    function __construct(int $chrtID, string $techSize, string $wbSize, ?int $price, array $skus = [])
    {
        $this->chrtID = $chrtID;
        $this->techSize = $techSize;
        $this->wbSize = $wbSize;
        $this->price = $price;
        $this->skus = $skus;
    }


    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $skus = isset($data['skus']) && is_array($data['skus'])
            ? array_map('strval', $data['skus'])
            : [];

        return new self(
            (int)($data['chrtID'] ?? 0),
            (string)($data['techSize'] ?? ''),
            (string)($data['wbSize'] ?? ''),
            isset($data['price']) ? ((int)$data['price']) : null,
            $skus
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'chrtID' => $this->chrtID,
            'techSize' => $this->techSize,
            'wbSize' => $this->wbSize,
            'price' => $this->price,
            'skus' => $this->skus,
        ], fn($v) => $v !== null);
    }
}
