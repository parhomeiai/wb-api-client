<?php

namespace Escorp\WbApiClient\Dto\Content\Warehouses;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Получить список складов WB
 *
 * Используется в endpoint:
 * GET https://marketplace-api.wildberries.ru/api/v3/offices
 */
class OfficesResponse extends WbApiResponseDto
{
    /**
     *
     * @var OfficeDto[]
     */
    public array $offices = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        if(is_array($response))
        {
            foreach($response as $office){
                $dto->offices[] = OfficeDto::fromArray($office);
            }
        }

        return $dto;
    }

    /**
     * Возвращает склады WB
     * @return OfficeDto[]
     */
    public function offices(): array
    {
        return $this->offices;
    }
}
