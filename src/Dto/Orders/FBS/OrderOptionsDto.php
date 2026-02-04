<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

/**
 * Опции заказа
 *
 */
class OrderOptionsDto
{
    public array $data;

    /**
     * Признак B2B-продажи:
     * false — не B2B-продажа
     * true — B2B-продажа
     * @var bool
     */
    public bool $isB2b;

    /**
     *
     * @param bool $isB2b
     */
    function __construct(bool $isB2b, array $data = [])
    {
        $this->isB2b = $isB2b;
        $this->data = $data;
    }

            /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (bool)($data['isB2b'] ?? false),
            $data
        );
    }
}
