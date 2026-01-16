<?php

namespace Escorp\WbApiClient\Dto\Content;

use InvalidArgumentException;

/**
 * Карточка товара для создания
 *
 * @author parhomey
 */
class ProductCardUploadDto extends ProductCardDto
{
    public array $data;


    function __construct(string $vendorCode, ?string $brand = null, ?string $title = null, ?string $description = null, ?ProductWholesaleDto $wholesale = null, ?ProductDimensionsDto $dimensions = null, array $sizes = [], array $characteristics = [])
    {
        foreach ($characteristics as $c) {
            if (!$c instanceof ProductCharacteristicDto) {
                throw new InvalidArgumentException('characteristics must contain ProductCharacteristicDto');
            }
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

        if(mb_strlen($vendorCode) > 7){
            throw new InvalidArgumentException('vendorCode must be string a string of no more than 72 characters');
        }

        $this->vendorCode = $vendorCode;
        $this->brand = $brand;
        $this->title = $title;
        $this->description = $description;
        $this->wholesale = $wholesale;
        $this->dimensions = $dimensions;
        $this->characteristics = $characteristics;
        $this->sizes = $sizes;
    }

    public function toArray(): array
    {
        return array_filter([
            'brand' => $this->brand,
            'title' => $this->title,
            'description' => $this->description,
            'vendorCode' => $this->vendorCode,
            'wholesale' => ($this->wholesale) ? ($this->wholesale->toArray()) : (null),
            'dimensions' => ($this->dimensions) ? ($this->dimensions->toArray()) : (null),
            'sizes' => (!empty($this->sizes)) ? array_map(function(ProductSizeDto $size){return $size->toArray();}, $this->sizes) : null,
            'characteristics' => (!empty($this->characteristics)) ? array_map(function(ProductCharacteristicDto $characteristic){return $characteristic->toArray();}, $this->characteristics) : null,
        ], fn($v) => $v !== null);
    }
}
