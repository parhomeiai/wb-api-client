<?php

declare(strict_types=1);

namespace Escorp\WbApiClient\Dto\Common;

/**
 * Успешный пинг
 */
class PingResponseDto
{
    /** @var mixed */
    public $data;

    /**
     * Timestamp запроса
     * @var string
     */
    public string $ts;

    /**
     * Статус
     * @var string
     */
    public string $status;

    /**
     *
     * @param type $data
     * @param string $ts
     * @param string $status
     */
    public function __construct($data, string $ts, string $status)
    {
        $this->data = $data;
        $this->ts = $ts;
        $this->status = $status;
    }

    /**
     *
     * @param array $response
     * @return self
     */
    public static function fromArray(array $response): self
    {
        return new self(
            $response,
            (string) ($response['TS'] ?? ''),
            (string) ($response['Status'] ?? '')
        );
    }

    /**
     * Возвращает данные ответа
     * @return mixed
     */
    function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Возвращает Timestamp запроса
     * @return string
     */
    function getTs(): string
    {
        return $this->ts;
    }

    /**
     * Возвращает статус
     * @return string
     */
    function getStatus(): string
    {
        return $this->status;
    }
}

