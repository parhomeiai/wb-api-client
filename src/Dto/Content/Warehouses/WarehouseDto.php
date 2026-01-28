<?php

namespace Escorp\WbApiClient\Dto\Content\Warehouses;

/**
 * Склад продавца
 *
 */
class WarehouseDto
{
    /**
     * Название
     * @var string
     */
    public string $name;

    /**
     * ID склада WB
     * @var int
     */
    public int $officeId;

    /**
     * ID склада продавца
     * @var int
     */
    public int $id;

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
     * Склад удаляется:false — нет,true — да
     * @var bool
     */
    public bool $isDeleting;

    /**
     * Данные склада обновляются:false — нет,true — да, обновление и удаление остатков недоступно
     * @var bool
     */
    public bool $isProcessing;

    /**
     *
     * @param string $name
     * @param int $officeId
     * @param int $id
     * @param int $cargoType
     * @param int $deliveryType
     * @param bool $isDeleting
     * @param bool $isProcessing
     */
    function __construct(string $name, int $officeId, int $id, int $cargoType, int $deliveryType, bool $isDeleting, bool $isProcessing)
    {
        $this->name = $name;
        $this->officeId = $officeId;
        $this->id = $id;
        $this->cargoType = $cargoType;
        $this->deliveryType = $deliveryType;
        $this->isDeleting = $isDeleting;
        $this->isProcessing = $isProcessing;
    }

        /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['name'] ?? ''),
            (int)($data['officeId'] ?? 0),
            (int)($data['id'] ?? 0),
            (int)($data['cargoType'] ?? 0),
            (int)($data['deliveryType'] ?? 0),
            (bool)($data['isDeleting'] ?? false),
            (bool)($data['isProcessing'] ?? false),
        );
    }
}
