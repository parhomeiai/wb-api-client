<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Курсор для запроса Список карточек товаров
 *
 * @author parhomey
 */
class CardsCursor
{

    /**
     * Сколько карточек товаров выдать в ответе
     * @var int
     */
    public int $limit = 100;

    /**
     * Дата и время изменения
     * @var string|null
     */
    public ?string $updatedAt = null;

    /**
     * Дата и время помещения в корзину
     * @var string|null
     */
    public ?string $trashedAt = null;

    /**
     * Артикул WB, с которого надо запрашивать следующий список карточек товаров
     * @var int|null
     */
    public ?int $nmID = null;

    /**
     * Количество возвращённых карточек товаров
     * @var int|null
     */
    public ?int $total = null;

    /**
     *
     * @param int $limit
     * @param string|null $updatedAt
     * @param int|null $nmID
     * @param int|null $total
     */
    function __construct(int $limit = 100, ?string $updatedAt = null, ?int $nmID = null, ?int $total = null, ?string $trashedAt = null)
    {
        $this->limit = $limit;
        $this->updatedAt = $updatedAt;
        $this->trashedAt = $trashedAt;
        $this->nmID = $nmID;
        $this->total = $total;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['limit'] ?? 100),
            ($data['updatedAt'] ?? null),
            (int)($data['nmID'] ?? 0),
            (int)($data['total'] ?? 0),
            ($data['trashedAt'] ?? null),
        );
    }

    /**
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'limit' => $this->limit,
            'updatedAt' => $this->updatedAt,
            'trashedAt' => $this->trashedAt,
            'nmID' => $this->nmID,
        ], fn($v) => $v !== null);
    }
}
