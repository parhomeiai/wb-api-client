<?php

namespace Escorp\WbApiClient\Dto\Content\Stocks;

class StocksBatchResponse
{

    public array $stocks = [];

    /** @var ResponseErrorDto[] */
    public array $errors = [];

    public function hasErrors(): bool
    {
        return !empty($this->errors);
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
