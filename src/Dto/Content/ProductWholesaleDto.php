<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Оптовая продажа
 *
 * @author parhomey
 */
class ProductWholesaleDto
{

    /**
     * Предназначена ли карточка товара для оптовой продажи
     * @var bool
     */
    public bool $enabled = false;

    /**
     * Количество единиц товара в упаковке
     * @var int
     */
    public int $quantum = 0;


    /**
     *
     * @param bool $enabled
     * @param int $quantum
     */
    function __construct(bool $enabled = false, int $quantum = 0)
    {
        $this->enabled = $enabled;
        $this->quantum = $quantum;
    }


    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (bool)($data['enabled'] ?? false),
            (int)($data['quantum'] ?? 0)
        );
    }

}
