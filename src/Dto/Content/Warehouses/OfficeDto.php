<?php

namespace Escorp\WbApiClient\Dto\Content\Warehouses;

/**
 * Склад WB
 *
 */
class OfficeDto
{
    /**
     * Адрес
     * @var string
     */
    public string $address;

    /**
     * Название
     * @var string
     */
    public string $name;

    /**
     * Город
     * @var string
     */
    public string $city;

    /**
     * ID
     * @var int
     */
    public int $id;

    /**
     * Долгота
     * @var float
     */
    public float $longitude;

    /**
     * Широта
     * @var float
     */
    public float $latitude;

    /**
     * Тип товара, который принимает склад:1 — малогабаритный товар (МГТ), 2 — сверхгабаритный товар (СГТ), 3 — крупногабаритный товар (КГТ+)
     * @var int
     */
    public int $cargoType;

    /**
     * Тип доставки, который принимает склад:1 — доставка на склад WB (FBS),2 — доставка силами продавца (DBS),3 — доставка курьером WB (DBW),5 — самовывоз (C&C),6 — экспресс-доставка силами продавца (ЕDBS)
     * @var int
     */
    public int $deliveryType;

    /**
     * Федеральный округ склада WB. Если null, склад находится за пределами РФ или федеральный округ не указан
     * @var string|null
     */
    public ?string $federalDistrict;

    /**
     * Признак того, что склад уже выбран продавцом
     * @var bool
     */
    public bool $selected;

    function __construct(string $address, string $name, string $city, int $id, float $longitude, float $latitude, int $cargoType, int $deliveryType, ?string $federalDistrict, bool $selected)
    {
        $this->address = $address;
        $this->name = $name;
        $this->city = $city;
        $this->id = $id;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->cargoType = $cargoType;
        $this->deliveryType = $deliveryType;
        $this->federalDistrict = $federalDistrict;
        $this->selected = $selected;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['address'] ?? ''),
            (string)($data['name'] ?? ''),
            (string)($data['city'] ?? ''),
            (int)($data['id'] ?? 0),
            (float)($data['longitude'] ?? 0),
            (float)($data['latitude'] ?? 0),
            (int)($data['cargoType'] ?? 0),
            (int)($data['deliveryType'] ?? 0),
            isset($data['federalDistrict']) ? ((string)$data['federalDistrict']) : (null),
            (bool)($data['selected'] ?? 0),
        );
    }
}
