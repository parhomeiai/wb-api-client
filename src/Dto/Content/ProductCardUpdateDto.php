<?php

namespace Escorp\WbApiClient\Dto\Content;

use InvalidArgumentException;

/**
 * Карточка товара для редактирования
 *
 * @author parhomey
 */
class ProductCardUpdateDto
{
    /**
     * Артикул WB
     * @var int
     */
    private int $nmID;

    /**
     * Артикул продавца
     * @var string
     */
    private string $vendorCode;

    /**
     * Бренд
     * @var string|null
     */
    private ?string $brand;

    /**
     * Наименование товара
     * @var string|null
     */
    private ?string $title;

    /**
     * Описание товара
     * @var string|null
     */
    private ?string $description;

    /**
     * Габариты и вес товара c упаковкой. Укажите в сантиметрах и килограммах для любого товара.
     * @var ProductDimensionsDto|null
     */
    private ?ProductDimensionsDto $dimensions;

    /**
     * Характеристики товара.
     * @var array ProductCharacteristicDto[]|null
     */
    private ?array $characteristics;

    /**
     * Массив размеров. Для безразмерного товара всё равно нужно передавать данный массив без параметров (wbSize и techSize), но с баркодом
     * @var array ProductSizeDto[]
     */
    private array $sizes;


    function __construct(int $nmID, string $vendorCode, array $sizes, ?string $brand = null, ?string $title = null, ?string $description = null, ?ProductDimensionsDto $dimensions = null, ?array $characteristics = []) {
        foreach ($characteristics as $c) {
            if (!$c instanceof ProductCharacteristicDto) {
                throw new InvalidArgumentException('characteristics must contain ProductCharacteristicDto');
            }
        }
        if (empty($sizes)) {
            throw new InvalidArgumentException('sizes cannot be an empty array');
        }
        foreach ($sizes as $s) {
            if (!$s instanceof ProductSizeDto) {
                throw new InvalidArgumentException('sizes must contain ProductSizeDto');
            }
        }
        if($title && mb_strlen($title) > 60){
            throw new InvalidArgumentException('title must be string a string of no more than 60 characters');
        }

        if($description && mb_strlen($description) > 5000){
            throw new InvalidArgumentException('description must be string a string of no more than 5000 characters');
        }

        $this->nmID = $nmID;
        $this->vendorCode = $vendorCode;
        $this->brand = $brand;
        $this->title = $title;
        $this->description = $description;
        $this->dimensions = $dimensions;
        $this->characteristics = $characteristics;
        $this->sizes = $sizes;
    }

    function setNmID(int $nmID): void {
        $this->nmID = $nmID;
    }

    function setVendorCode(string $vendorCode): void {
        $this->vendorCode = $vendorCode;
    }

    function setBrand(?string $brand): void {
        $this->brand = $brand;
    }

    function setTitle(?string $title): void {
        if($title && mb_strlen($title) > 60){
            throw new InvalidArgumentException('title must be string a string of no more than 60 characters');
        }

        $this->title = $title;
    }

    function setDescription(?string $description): void {
        if($description && mb_strlen($description) > 5000){
            throw new InvalidArgumentException('description must be string a string of no more than 5000 characters');
        }

        $this->description = $description;
    }

    function setDimensions(?ProductDimensionsDto $dimensions): void {
        $this->dimensions = $dimensions;
    }

    function setCharacteristics(?array $characteristics): void {
        if($characteristics){
            foreach ($characteristics as $c) {
                if (!$c instanceof ProductCharacteristicDto) {
                    throw new InvalidArgumentException('characteristics must contain ProductCharacteristicDto');
                }
            }
        }
        $this->characteristics = $characteristics;
    }

    function setSizes(array $sizes): void {
        if (empty($sizes)) {
            throw new InvalidArgumentException('sizes cannot be an empty array');
        }
        foreach ($sizes as $s) {
            if (!$s instanceof ProductSizeDto) {
                throw new InvalidArgumentException('sizes must contain ProductSizeDto');
            }
        }
        $this->sizes = $sizes;
    }

    function getNmID(): int {
        return $this->nmID;
    }

    function getVendorCode(): string {
        return $this->vendorCode;
    }

    function getBrand(): ?string {
        return $this->brand;
    }

    function getTitle(): ?string {
        return $this->title;
    }

    function getDescription(): ?string {
        return $this->description;
    }

    function getDimensions(): ?ProductDimensionsDto {
        return $this->dimensions;
    }

    function getCharacteristics(): ?array {
        return $this->characteristics;
    }

    function getSizes(): array {
        return $this->sizes;
    }

    public function toArray(): array
    {
        return array_filter([
            'nmID' => $this->nmID,
            'vendorCode' => $this->vendorCode,
            'brand' => $this->brand,
            'title' => $this->title,
            'description' => $this->description,
            'dimensions' => ($this->dimensions) ? ($this->dimensions->toArray()) : (null),
            'characteristics' => (!empty($this->characteristics)) ? array_map(function(ProductCharacteristicDto $characteristic){return $characteristic->toArray();}, $this->characteristics) : null,
            'sizes' => (!empty($this->sizes)) ? array_map(function(ProductSizeDto $size){return $size->toArray();}, $this->sizes) : null,
        ], fn($v) => $v !== null);
    }
}
