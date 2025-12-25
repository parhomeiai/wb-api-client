<?php

namespace Escorp\WbApiClient\Dto\Common;

/**
 * Теги новости
 *
 * @author parhomey
 */
class NewsTypesDto
{
    /**
     * ID тега
     * @var int|null
     */
    public ?int $id;

    /**
     * Название тега
     * @var string
     */
    public string $name;


    /**
     *
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(?int $id, ?string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     *
     * @param array $data
     * @return self
     * @throws DtoMappingException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['id']) ? (int)$data['id'] : null,
            isset($data['name']) ? (string)$data['name'] : null,
        );
    }
}
