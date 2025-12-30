<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Страна
 */
class CountryDto
{
    /**
     * Значение характеристики Страны
     * @var string
     */
    public string $name;

    /**
     * Полное название страны
     * @var string
     */
    public string $fullName;


    function __construct(string $name, string $fullName) {
        $this->name = $name;
        $this->fullName = $fullName;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['name'] ?? ''),
            (string)($data['fullName'] ?? '')
        );
    }
}
