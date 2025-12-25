<?php

declare(strict_types=1);

namespace Escorp\WbApiClient\Dto\Common;

use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 *
 */
final class NewsResponseDto extends WbApiResponseDto
{
    /** @var NewsItemDto[] */
    public array $news = [];

    public static function fromArray(array $response): self
    {
        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText);

        $items = $response['data'] ?? [];

        foreach ($items as $item) {
            $dto->news[] = NewsItemDto::fromArray($item);
        }

        return $dto;
    }

    /**
     * Возвращает новости
     * @return array
     */
    public function news(): array
    {
        return $this->news;
    }
}

