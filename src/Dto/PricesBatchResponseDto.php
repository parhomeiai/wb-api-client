<?php

namespace Escorp\WbApiClient\Dto;

/**
 * Description of PricesBatchResponseDto
 *
 * @author parhomey
 */
class PricesBatchResponseDto
{
    /** @var array<int, PriceDto[]> */
    public array $items = [];

    /** @var array<int, PriceDto[]> */
    public array $prices = [];

    /** @var BatchErrorDto[] */
    public array $errors = [];

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Возвращает товары
     * @return array
     */
    function getItems(): array
    {
        return $this->items;
    }

    /**
     * Возвращает цены
     * @return array
     */
    function getPrices(): array
    {
        return $this->prices;
    }

    /**
     * Возвращает ответы с ошибками
     * @return array
     */
    function getErrors(): array
    {
        return $this->errors;
    }


}
