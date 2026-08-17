<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

/**
 * Поставка
 *
 */
class SupplyDto
{
    public array $data;

    /**
     * ID поставки
     * @var string
     */
    public string $id;

    /**
     * Признак B2B-продажи: true — B2B-продажа, false — не B2B-продажа, null — признак отсутствует, сборочные задания не добавлены к поставке
     * @var bool|null
     */
    public ?bool $isB2b;

    /**
     * Можно ли отгрузить заказ на ПВЗ: false — нет, true — да
     * @var bool|null
     */
    public bool $isPickupPointShipmentAllowed;

    /**
     * Флаг закрытия поставки:true — закрыта, false — открыта
     * @var bool
     */
    public bool $done;

    /**
     * Дата создания поставки (RFC3339)
     * @var string
     */
    public string $createdAt;

    /**
     * Дата закрытия поставки (RFC3339)
     * @var string|null
     */
    public ?string $closedAt;

    /**
     * Дата сканирования поставки или первого заказа (RFC3339)
     * @var string|null
     */
    public ?string $scanDt;

    /**
     * Наименование поставки
     * @var string
     */
    public string $name;

    /**
     * Тип товара:1 — малогабаритный товар (МГТ), 2 — сверхгабаритный товар (СГТ), 3 — крупногабаритный товар (КГТ+)
     * @var int
     */
    public int $cargoType;

    /**
     * ID склада назначения поставки. Если null, склад назначения не указан
     * @var int|null
     */
    public ?int $destinationOfficeId;

    /**
     * ID рекомендуемого склада для приёмки поставки для Москвы и МО.
     * @var int
     */
    public int $recommendedWhId;

    function __construct(string $id, ?bool $isB2b, bool $isPickupPointShipmentAllowed, bool $done, string $createdAt, ?string $closedAt, ?string $scanDt, string $name, int $cargoType, ?int $destinationOfficeId, int $recommendedWhId, array $data)
    {
        $this->data = $data;
        $this->id = $id;
        $this->isB2b = $isB2b;
        $this->isPickupPointShipmentAllowed = $isPickupPointShipmentAllowed;
        $this->done = $done;
        $this->createdAt = $createdAt;
        $this->closedAt = $closedAt;
        $this->scanDt = $scanDt;
        $this->name = $name;
        $this->cargoType = $cargoType;
        $this->destinationOfficeId = $destinationOfficeId;
        $this->recommendedWhId = $recommendedWhId;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['id'] ?? ''),
            $data['isB2b'] ?? null,
            (bool)($data['isPickupPointShipmentAllowed'] ?? false),
            (bool)($data['done'] ?? false),
            (string)($data['createdAt'] ?? ''),
            (string)($data['closedAt'] ?? ''),
            $data['scanDt'] ?? null,
            (string)($data['name'] ?? ''),
            (int)($data['cargoType'] ?? 0),
            $data['destinationOfficeId'] ?? null,
            (int)($data['recommendedWhId'] ?? 0),
            $data
        );
    }
}
