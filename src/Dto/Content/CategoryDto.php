<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Категория
 */
class CategoryDto
{
    /**
     * ID категории
     * @var int
     */
    public int $id;

    /**
     * Название категории
     * @var string
     */
    public string $name;

    /**
     * Виден на сайте
     * @var bool
     */
    public bool $isVisible;

    public function __construct(int $id, string $name, bool $isVisible)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isVisible = $isVisible;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['id'] ?? 0),
            (string)($data['name'] ?? ''),
            (bool)($data['isVisible'] ?? false)
        );
    }
}
