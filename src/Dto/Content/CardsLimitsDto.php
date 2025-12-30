<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Лимиты карточек товаров
 */
class CardsLimitsDto
{
    /**
     * Количество бесплатных лимитов
     * @var int
     */
    public int $freeLimits = 0;

    /**
     * Количество оплаченных лимитов
     * @var int
     */
    public int $paidLimits = 0;

    /**
     *
     * @param int $freeLimits
     * @param int $paidLimits
     */
    function __construct(int $freeLimits, int $paidLimits)
    {
        $this->freeLimits = $freeLimits;
        $this->paidLimits = $paidLimits;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['freeLimits'] ?? 0),
            (int)($data['paidLimits'] ?? 0)
        );
    }

    function getFreeLimits(): int
    {
        return $this->freeLimits;
    }

    function getPaidLimits(): int
    {
        return $this->paidLimits;
    }

}
