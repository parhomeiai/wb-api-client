<?php

namespace Escorp\WbApiClient\Dto\Prices;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Description of HistoryTaskResponseDto
 *
 * @author parhomey
 */
class HistoryTaskResponseDto extends WbApiResponseDto
{
    /**
     * Загрузка
     * @var UploadDto
     */
    public UploadDto $upload;

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText);

        $dto->upload = UploadDto::fromArray($wbApiResponseDto->data);

        return $dto;
    }

    /**
     * информация о загрузке
     * @return UploadDto
     */
    public function upload(): UploadDto
    {
        return $this->upload;
    }
}
