<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

/**
 * заказ для повторной отгрузки
 *
 */
class OrderReshipmentDto
{
    public array $data;

    /**
     * ID поставки
     * @var type
     */
    public $supplyID;

    /**
     * ID сборочного задания
     * @var type
     */
    public $orderID;

    /**
     *
     * @param type $supplyID
     * @param type $orderID
     * @param array $data
     */
    function __construct($supplyID, $orderID, array $data) {
        $this->data = $data;
        $this->supplyID = $supplyID;
        $this->orderID = $orderID;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['supplyID'] ?? null,
            $data['orderID'] ?? null,
            $data
        );
    }
}
