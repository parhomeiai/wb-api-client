<?php

namespace Escorp\WbApiClient\Dto\Content\Warehouses;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Список контактов
 *
 * Используется в endpoint:
 * GET https://marketplace-api.wildberries.ru/api/v3/dbw/warehouses/{warehouseId}/contacts
 */
class WarehouseContactsResponse extends WbApiResponseDto
{
    /**
     *
     * @var WarehouseContactDto[]
     */
    public array $contacts = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['contacts'] ?? [];

        foreach($items as $item){
            $dto->contacts[] = WarehouseContactDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает склады WB
     * @return WarehouseContactDto[]
     */
    public function contacts(): array
    {
        return $this->contacts;
    }
}
