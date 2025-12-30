<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * ТНВЭД-код
 */
class TnvedDto
{
    /**
     * ТНВЭД-код
     * @var string
     */
    public string $tnved;

    /**
     * true - код маркировки требуется
     * false - код маркировки не требуется
     * @var bool
     */
    public bool $isKiz;

    /**
     *
     * @param string $tnved
     * @param bool $isKiz
     */
    function __construct(string $tnved, bool $isKiz)
    {
        $this->tnved = $tnved;
        $this->isKiz = $isKiz;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['tnved'] ?? ''),
            (bool)($data['isKiz'] ?? false)
        );
    }
}
