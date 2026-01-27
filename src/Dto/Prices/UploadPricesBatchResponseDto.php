<?php

namespace Escorp\WbApiClient\Dto\Prices;

/**
 * Description of UploadPricesBatchResponseDto
 *
 * @author parhomey
 */
class UploadPricesBatchResponseDto
{
    /** @var array<int, LoadDataDto[]> */
    public array $items = [];

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
     * Возвращает ответы с ошибками
     * @return array
     */
    function getErrors(): array
    {
        return $this->errors;
    }


}
