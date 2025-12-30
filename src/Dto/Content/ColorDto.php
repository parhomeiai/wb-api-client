<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Цвет
 */
class ColorDto
{
    /**
     * Наименование цвета
     * @var string
     */
    public string $name;

    /**
     * Наименование родительского цвета
     * @var string
     */
    public string $parentName;


    /**
     *
     * @param string $name
     * @param string $parentName
     */
    function __construct(string $name, string $parentName)
    {
        $this->name = $name;
        $this->parentName = $parentName;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['name'] ?? ''),
            (string)($data['parentName'] ?? '')
        );
    }
}
