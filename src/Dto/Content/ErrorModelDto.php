<?php


namespace Escorp\WbApiClient\Dto\Content;

/**
 *
 *
 * @author parhomey
 */
class ErrorModelDto
{
    /**
     * ID
     * @var int
     */
    public int $id;

    /**
     * Название
     * @var string
     */
    public string $name;

    /**
     *
     * @param int $id
     * @param string $name
     */
    function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

        /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int) ($data['id'] ?? 0),
            (string) ($data['name'] ?? ''),
        );
    }
}
