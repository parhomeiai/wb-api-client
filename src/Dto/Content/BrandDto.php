<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Бренд
 */
class BrandDto
{
    /**
     * ID бренда
     * @var int
     */
    public int $id;

    /**
     * Название категории
     * @var string
     */
    public string $name;

    /**
     * URL логотипа бренда
     * @var string
     */
    public string $logoUrl;

    /**
     *
     * @param int $id
     * @param string $name
     * @param string $logoUrl
     */
    function __construct(int $id, string $name, string $logoUrl)
    {
        $this->id = $id;
        $this->name = $name;
        $this->logoUrl = $logoUrl;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['id'] ?? 0),
            (string)($data['name'] ?? ''),
            (string)($data['logoUrl'] ?? '')
        );
    }
}
