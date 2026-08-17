<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Получить информацию о поставке
 *
 * Используется в endpoint:
 * GET https://marketplace-api.wildberries.ru/api/v3/supplies/{supplyId}
 */
class SupplyResponse extends WbApiResponseDto
{
    /**
     *
     * @var SupplyDto
     */
    public SupplyDto $supplyDto;

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $dto->supplyDto = SupplyDto::fromArray($wbApiResponseDto->data);

        return $dto;
    }

    /**
     * Возвращает поставку
     * @return SupplyDto
     */
    public function supplyDto(): SupplyDto
    {
        return $this->supplyDto;
    }
}
