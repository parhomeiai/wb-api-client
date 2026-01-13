<?php

namespace Escorp\WbApiClient\Dto\Requests;

use Escorp\WbApiClient\Dto\Content\CardsCursor;
use Escorp\WbApiClient\Dto\Content\CardsListFilter;

/**
 * Данные для запроса Список карточек товаров
 *
 * @author parhomey
 */
class CardsListRequest
{
    /**
     * Курсор
     * @var CardsCursor
     */
    private CardsCursor $cursor;

    /**
     * Параметры фильтрации
     * @var CardsListFilter
     */
    private CardsListFilter $filter;

    /**
     * Сортировать по полю updatedAt (false - по убыванию, true - по возрастанию)
     * @var bool
     */
    private bool $ascending = false;

    /**
     *
     * @param CardsCursor $cursor
     * @param CardsListFilter $filter
     * @param bool $ascending
     */
    function __construct(CardsCursor $cursor, CardsListFilter $filter, bool $ascending = false) {
        $this->cursor = $cursor;
        $this->filter = $filter;
        $this->ascending = $ascending;
    }

    /**
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'settings' => [
                'sort' => [
                    'ascending' => $this->ascending,
                ],
                'filter' => $this->filter->toArray(),
                'cursor' => $this->cursor->toArray(),
            ]
        ];
    }

}
