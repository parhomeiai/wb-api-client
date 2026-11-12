<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

/**
 * Детали маркировки
 */
class MetaDetailDto
{
    public array $data;

    /**
     * Идентификатор маркировки
     * @var string
     */
    public string $key;

    /**
     * Значение идентификатора маркировки
     * @var string|null
     */
    public ?string $value;

    /**
     * Статусы проверки идентификаторов маркировки.
     * @var string
     */
    public string $decision;

    /**
     *
     * @param string $key
     * @param string|null $value
     * @param string $decision
     * @param array $data
     */
    function __construct(string $key, ?string $value, string $decision, array $data = []) {
        $this->data = $data;
        $this->key = $key;
        $this->value = $value;
        $this->decision = $decision;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['key'] ?? ''),
            $data['value'] ?? null,
            (string)($data['decision'] ?? ''),
            $data
        );
    }
}
