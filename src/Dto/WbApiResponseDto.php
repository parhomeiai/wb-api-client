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
    public $additionalErrors;

    /**
     *
     * @param mixed $data
     * @param bool $error
     * @param string $errorText
     */
    public function __construct($data, bool $error, string $errorText, $additionalErrors = null)
    {
        $this->data = $data;
        $this->error = $error;
        $this->errorText = $errorText;
        $this->additionalErrors = $additionalErrors;
    }

    /**
     *
     * @param array $response
     * @return self
     */
    public static function fromArray(array $response): self
    {
        return new self(
            $response['data'] ?? $response,
            (bool) ($response['error'] ?? false),
            (string) ($response['errorText'] ?? ''),
            $response['additionalErrors'] ?? null,
        );
    }

    /**
     * Возвращает true если есть ошибка
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->error === true;
    }

    /**
     * Возвращает сырые данные
     * @return mixed
     */
    function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Возвращает поле error
     * @return bool
     */
    function getError(): bool
    {
        return $this->error;
    }

    /**
     * Возвращает поле errorText
     * @return string
     */
    function getErrorText(): string
    {
        return $this->errorText;
    }
}

