<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Ярлык товара
 *
 * @author parhomey
 */
class ProductTagDto
{
    /**
     * ID ярлыка
     * @var int
     */
    public int $id;

    /**
     * Название ярлыка
     * @var string
     */
    public string $name;

    /**
     * Цвет ярлыка. Доступные цвета:
     * D1CFD7 — серый
     * FEE0E0 — красный
     * ECDAFF — фиолетовый
     * E4EAFF — синий
     * DEF1DD — зеленый
     * FFECC7 — желтый
     * @var string
     */
    public string $color;

    /**
     *
     * @param int $id
     * @param string $name
     * @param string $color
     */
    function __construct(int $id, string $name, string $color)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
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
            (string)($data['color'] ?? '')
        );
    }

}
