<?php

namespace Escorp\WbApiClient\Dto\Content\Warehouses;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Получить список складов продавца
 *
 * Используется в endpoint:
 * GET https://marketplace-api.wildberries.ru/api/v3/warehouses
 */
class WarehousesResponse extends WbApiResponseDto
{
    /**
     *
     * @var WarehouseDto[]
     */
    public array $warehouses = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        if(is_array($response))
        {
            foreach($response as $office){
                $dto->warehouses[] = WarehouseDto::fromArray($office);
            }
        }

        return $dto;
    }

    /**
     * Возвращает склады WB
     * @return WarehouseDto[]
     */
    public function warehouses(): array
    {
        return $this->warehouses;
    }
}
