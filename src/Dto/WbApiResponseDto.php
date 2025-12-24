<?php

declare(strict_types=1);

namespace Escorp\WbApiClient\Dto;

/**
 * Ответ WB
 */
class WbApiResponseDto
{
    /** @var mixed */
    public $data;

    public bool $error;
    public string $errorText;

    /**
     *
     * @param mixed $data
     * @param bool $error
     * @param string $errorText
     */
    public function __construct($data, bool $error, string $errorText)
    {
        $this->data = $data;
        $this->error = $error;
        $this->errorText = $errorText;
    }

    /**
     *
     * @param array $response
     * @return self
     */
    public static function fromArray(array $response): self
    {
        return new self(
            $response['data'] ?? null,
            (bool) ($response['error'] ?? false),
            (string) ($response['errorText'] ?? '')
        );
    }

    /**
     *
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->error === true;
    }
}

