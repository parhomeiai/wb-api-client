<?php


namespace Escorp\WbApiClient\Dto\Content;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Ответ на запрос Родительские категории товаров
 *
 * Используется в endpoint:
 * GET https://content-api.wildberries.ru/content/v2/object/parent/all
 */
class ParentCategoriesResponse extends WbApiResponseDto
{
    public array $categories;

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText, $wbApiResponseDto->additionalErrors);

        $items = $response['data'] ?? [];

        foreach ($items as $item) {
            $dto->categories[] = CategoryDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает родительские категории товаров
     * @return array
     */
    public function categories(): array
    {
        return $this->categories;
    }
}
