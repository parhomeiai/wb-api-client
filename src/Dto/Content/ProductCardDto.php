<?php

namespace Escorp\WbApiClient\Dto\Content;

use InvalidArgumentException;

/**
 * Карточка товара
 *
 * @author parhomey
 */
class ProductCardDto
{
    public array $data;

    /**
     * Артикул WB
     * @var int
     */
    public int $nmID;

    /**
     * ID объединённой карточки товара.
     * Един для всех артикулов WB одной объединённой карточки товара.
     * Есть у карточки товара, даже если она не объединена ни с одной другой карточкой
     * @var int
     */
    public int $imtID;

    /**
     * Внутренний технический ID карточки товара
     * @var string
     */
    public string $nmUUID;

    /**
     * ID предмета
     * @var int
     */
    public int $subjectID;

    /**
     * Название предмета
     * @var string
     */
    public string $subjectName;

    /**
     * Артикул продавца
     * @var string
     */
    public string $vendorCode;

    /**
     * Бренд
     * @var string
     */
    public string $brand;

    /**
     * Наименование товара
     * @var string
     */
    public string $title;

    /**
     * Описание товара
     * @var string
     */
    public string $description;

    /**
     * Требуется ли код маркировки для этого товара
     * @var bool
     */
    public bool $needKiz = false;

    /**
     * Массив фото
     * @var array|ProductPhoto[]
     */
    public array $photos = [];

    /**
     * URL видео
     * @var string
     */
    public string $video;

    /**
     * Оптовая продажа
     * @var ProductWholesale
     */
    public ProductWholesaleDto $whosale;

    /**
     * Габариты и вес товара c упаковкой, см и кг
     * @var ProductDimensions
     */
    public ProductDimensionsDto $dimensions;

    /**
     * Характеристики
     * @var array|ProductCharacteristic[]
     */
    public array $characteristics = [];

    /**
     * Размеры товара
     * @var array|ProductSize[]
     */
    public array $sizes = [];

    /**
     * Ярлыки
     * @var array|ProductTag[]
     */
    public array $tags = [];

    /**
     * Дата и время создания
     * @var string
     */
    public string $createdAt;

    /**
     * Дата и время изменения
     * @var string
     */
    public string $updatedAt;

    function __construct(int $nmID, int $imtID, string $nmUUID, int $subjectID, string $subjectName, string $vendorCode, string $brand, string $title, string $description, bool $needKiz, array $photos, string $video, ProductWholesaleDto $whosale, ProductDimensionsDto $dimensions, array $characteristics, array $sizes, array $tags, string $createdAt, string $updatedAt)
    {
        foreach ($photos as $p) {
            if (!$p instanceof ProductPhotoDto) {
                throw new InvalidArgumentException('photos must contain ProductPhotoDto');
            }
        }
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
        foreach ($tags as $t) {
            if (!$t instanceof ProductTagDto) {
                throw new InvalidArgumentException('tags must contain ProductTagDto');
            }
        }

        $this->nmID = $nmID;
        $this->imtID = $imtID;
        $this->nmUUID = $nmUUID;
        $this->subjectID = $subjectID;
        $this->subjectName = $subjectName;
        $this->vendorCode = $vendorCode;
        $this->brand = $brand;
        $this->title = $title;
        $this->description = $description;
        $this->needKiz = $needKiz;
        $this->photos = $photos;
        $this->video = $video;
        $this->whosale = $whosale;
        $this->dimensions = $dimensions;
        $this->characteristics = $characteristics;
        $this->sizes = $sizes;
        $this->tags = $tags;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $photos = [];
        foreach($data['photos'] ?? [] as $photo){
            $photos[] = ProductPhotoDto::fromArray($photo);
        }

        $characteristics = [];
        foreach($data['characteristics'] ?? [] as $characteristic){
            $characteristics[] = ProductCharacteristicDto::fromArray($characteristic);
        }

        $sizes = [];
        foreach($data['sizes'] ?? [] as $size){
            $sizes[] = ProductSizeDto::fromArray($size);
        }

        $tags = [];
        foreach($data['tags'] ?? [] as $tag){
            $tags[] = ProductTagDto::fromArray($tag);
        }

        $product = new self(
            (int)($data['nmID'] ?? 0),
            (int)($data['imtID'] ?? 0),
            (string)($data['nmUUID'] ?? ''),
            (int)($data['subjectID'] ?? 0),
            (string)($data['subjectName'] ?? ''),
            (string)($data['vendorCode'] ?? ''),
            (string)($data['brand'] ?? ''),
            (string)($data['title'] ?? ''),
            (string)($data['description'] ?? ''),
            (bool)($data['needKiz'] ?? false),
            $photos,
            (string)($data['video'] ?? ''),
            (isset($data['whosale']) ? ProductWholesaleDto::fromArray($data['whosale']) : new ProductWholesaleDto()),
            (isset($data['dimensions']) ? ProductDimensionsDto::fromArray($data['dimensions']) : new ProductDimensionsDto()),
            $characteristics,
            $sizes,
            $tags,
            (string)($data['createdAt'] ?? ''),
            (string)($data['updatedAt'] ?? ''),
        );

        $product->data = $data;

        return $product;
    }
}
