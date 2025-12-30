<?php

namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Страна производства
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/directory/countries
 */
class CountriesResponse extends WbApiResponseDto
{
    public array $countries = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['data'] ?? [];

        foreach ($items as $item) {
            $dto->countries[] = CountryDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает страны
     * @return array
     */
    public function countries(): array
    {
        return $this->countries;
    }
}
