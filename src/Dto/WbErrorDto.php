<?php

namespace Escorp\WbApiClient\Dto;

/**
 * Данные об ошибке
 *
 */
class WbErrorDto
{

    /**
     * Данные
     * @var mixed
     */
    public $data;


    /**
     * Заголовок ошибки
     * @var string|null
     */
    public ?string $title;

    /**
     * Детали ошибки
     * @var string|null
     */
    public ?string $detail;

    /**
     * Внутренний код ошибки
     * @var string|null
     */
    public ?string $code;

    /**
     * Уникальный ID запроса
     * @var string|null
     */
    public ?string $requestId;

    /**
     * ID внутреннего сервиса WB
     * @var string|null
     */
    public ?string $origin;

    /**
     * HTTP статус-код
     * @var int|null
     */
    public ?int $status;

    /**
     * Расшифровка HTTP статус-кода
     * @var string|null
     */
    public ?string $statusText;

    /**
     * Дата и время запроса
     * @var string|null
     */
    public ?string $timestamp;

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $dto = new self();

        $dto->data = $data;

        $dto->title      = isset($data['title']) ? (string)$data['title'] : null;
        $dto->detail     = isset($data['detail']) ? (string)$data['detail'] : null;
        $dto->code       = isset($data['code']) ? (string)$data['code'] : null;
        $dto->requestId  = isset($data['requestId']) ? (string)$data['requestId'] : null;
        $dto->origin     = isset($data['origin']) ? (string)$data['origin'] : null;
        $dto->status     = isset($data['status']) ? (string)$data['status'] : null;
        $dto->statusText = isset($data['statusText']) ? (string)$data['statusText'] : null;
        $dto->timestamp  = isset($data['timestamp']) ? (string)$data['timestamp'] : null;

        return $dto;
    }
}
