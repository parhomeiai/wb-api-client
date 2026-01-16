<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Характеристика товара
 *
 * @author parhomey
 */
class ProductCharacteristicDto
{
    /**
     * ID характеристики
     * @var int
     */
    public int $id;

    /**
     * Название характеристики
     * @var string
     */
    public string $name;

    /**
     * Значение характеристики. Тип значения зависит от типа характеристики
     * @var mixed
     */
    public $value;


    /**
     *
     * @param int $id
     * @param string $name
     * @param mixed $value
     */
    function __construct(int $id, string $name, $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
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
            ($data['value'] ?? null)
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'value' => $this->value,
        ], fn($v) => $v !== null);
    }
}
