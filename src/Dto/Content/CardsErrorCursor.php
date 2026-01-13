<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Курсор для запроса Список несозданных карточек товаров с ошибками
 *
 * @author parhomey
 */
class CardsErrorCursor
{

    /**
     * Количество пакетов в ответе
     * @var int
     */
    public int $limit = 100;

    /**
     * Дата и время формирования последнего пакета в ответе на предыдущий запрос
     * @var string|null
     */
    public ?string $updatedAt = null;

    /**
     * ID последнего пакета в ответе на предыдущий запрос
     * @var string|null
     */
    public ?string $batchUUID = null;

    /**
     * Количество возвращённых карточек товаров
     * @var int|null
     */
    public ?bool $next = null;


    function __construct(int $limit, ?string $updatedAt = null, ?string $batchUUID = null, ?bool $next = null) {
        $this->limit = $limit;
        $this->updatedAt = $updatedAt;
        $this->batchUUID = $batchUUID;
        $this->next = $next;
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
            (string)($data['updatedAt'] ?? ''),
            (string)($data['batchUUID'] ?? ''),
            (bool)($data['next'] ?? false),
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
            'batchUUID' => $this->batchUUID,
        ], fn($v) => $v !== null);
    }
}
