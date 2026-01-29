<?php

namespace Escorp\WbApiClient\Dto\Content\Stocks;

class StocksBatchResponse
{

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
