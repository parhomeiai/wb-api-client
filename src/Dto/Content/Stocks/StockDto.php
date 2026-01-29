<?php

namespace Escorp\WbApiClient\Dto\Content\Stocks;

/**
 * Склад WB
 *
 */
class StockDto
{
    /**
     * ID размера товара
     * @var int
     */
    private int $chrtId;

    /**
     * Баркод.
     * @var string
     * @deprecated since 2026-02-09
     */
    private string $sku;

    /**
     * Остаток
     * @var int
     */
    private int $amount;

    /**
     *
     * @param int $chrtId
     * @param int $amount
     * @param string $sku
     */
    function __construct(int $chrtId, int $amount, string $sku = '')
    {
        $this->chrtId = $chrtId;
        $this->sku = $sku;
        $this->amount = $amount;
    }

        /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['chrtId'] ?? 0),
            (int)($data['amount'] ?? 0),
            (string)($data['sku'] ?? '')
        );
    }

    function getChrtId(): int
    {
        return $this->chrtId;
    }

    function getSku(): string
    {
        return $this->sku;
    }

    function getAmount(): int
    {
        return $this->amount;
    }

    function setChrtId(int $chrtId): void
    {
        $this->chrtId = $chrtId;
    }

    function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    function toArray(): array
    {
        return array_filter([
            'chrtId' => $this->chrtId,
            'sku' => $this->sku,
            'amount' => $this->amount,
        ], fn($v) => $v !== '');
    }
}
