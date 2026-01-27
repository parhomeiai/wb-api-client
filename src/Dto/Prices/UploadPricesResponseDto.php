<?php

namespace Escorp\WbApiClient\Dto\Prices;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Description of UploadPricesResponseDto
 *
 * @author parhomey
 */
class UploadPricesResponseDto extends WbApiResponseDto
{
    /**
     * Загрузка
     * @var LoadDataDto
     */
    public LoadDataDto $load;

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText);

        $dto->load = LoadDataDto::fromArray($wbApiResponseDto->data);

        return $dto;
    }

    /**
     * информация о загрузке
     * @return LoadDataDto
     */
    public function load(): LoadDataDto
    {
        return $this->load;
    }
}
