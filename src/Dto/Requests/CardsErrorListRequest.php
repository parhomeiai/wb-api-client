<?php

namespace Escorp\WbApiClient\Dto\Requests;

use Escorp\WbApiClient\Dto\Content\CardsErrorCursor;

/**
 * Данные для запроса Список несозданных карточек товаров с ошибками
 *
 * @author parhomey
 */
class CardsErrorListRequest
{
    /**
     * Курсор
     * @var CardsErrorCursor
     */
    private CardsErrorCursor $cursor;

    /**
     * Сортировать по полю updatedAt (false - по убыванию, true - по возрастанию)
     * @var bool
     */
    private bool $ascending = true;

    /**
     *
     * @param CardsCursor $cursor
     * @param bool $ascending
     */
    function __construct(CardsErrorCursor $cursor, bool $ascending = true) {
        $this->cursor = $cursor;
        $this->ascending = $ascending;
    }

    /**
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'cursor' => $this->cursor->toArray(),
            'order' => [
                'ascending' => $this->ascending,
            ],
        ];
    }

}
