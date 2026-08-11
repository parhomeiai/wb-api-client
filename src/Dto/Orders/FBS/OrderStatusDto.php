<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

/**
 * Статусы заказа FBS
 *
 */
class OrderStatusDto
{
    public array $data;

    /**
     * ID сборочного задания
     * @var int
     */
    public int $id;

    /**
     * Статус сборочного задания, установленный продавцом
     * Enum: "new" "confirm" "complete" "cancel"
     * @var string
     */
    public string $supplierStatus;

    /**
     * Статус сборочного задания в системе Wildberries
     * Enum: "waiting" "sorted" "sold" "canceled" "canceled_by_client" "declined_by_client" "defect" "ready_for_pickup" "postponed_delivery" "accepted_by_carrier" "sent_to_carrier"
     * @var string
     */
    public string $wbStatus;

    /**
     *
     * @param int $id
     * @param string $supplierStatus
     * @param string $wbStatus
     * @param array $data
     */
    function __construct(int $id, string $supplierStatus, string $wbStatus, array $data = [])
    {
        $this->data = $data;
        $this->id = $id;
        $this->supplierStatus = $supplierStatus;
        $this->wbStatus = $wbStatus;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['id'] ?? 0),
            (string)($data['supplierStatus'] ?? ''),
            (string)($data['wbStatus'] ?? ''),
            $data
        );
    }
}
