<?php

namespace Escorp\WbApiClient\Dto\Prices;

/**
 * Информация о загрузке
 */
final class LoadDataDto
{
    /**
     * ID загрузки
     * @var int|null
     */
    public ?int $id;

    /**
     * Флаг дублирования загрузки: true — такая загрузка уже есть
     * @var bool|null
     */
    public ?bool $alreadyExists;

    /**
     *
     * @param int|null $id
     * @param bool|null $alreadyExists
     */
    function __construct(?int $id, ?bool $alreadyExists)
    {
        $this->id = $id;
        $this->alreadyExists = $alreadyExists;
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
            isset($data['alreadyExists']) ? (bool)$data['alreadyExists'] : null,
        );
    }
}

