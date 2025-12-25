<?php

declare(strict_types=1);

namespace Escorp\WbApiClient\Dto\Common;

/**
 *
 */
final class SellerInfoResponseDto
{
    public $data;

    /**
     * Наименование продавца
     * @var string|null
     */
    public ?string $name;

    /**
     * Уникальный ID продавца на Wildberries
     * @var string|null
     */
    public ?string $sid;

    /**
     * Торговое наименование продавца
     * @var string|null
     */
    public ?string $tradeMark;

    /**
     *
     * @param type $data
     * @param string|null $name
     * @param string|null $sid
     * @param string|null $tradeMark
     */
    public function __construct($data, ?string $name, ?string $sid, ?string $tradeMark)
    {
        $this->data = $data;
        $this->name = $name;
        $this->sid = $sid;
        $this->tradeMark = $tradeMark;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data,
            isset($data['name']) ? (string)$data['name'] : null,
            isset($data['sid']) ? (string)$data['sid'] : null,
            isset($data['tradeMark']) ? (string)$data['tradeMark'] : null
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
     * Возвращает Наименование продавца
     * @return string|null
     */
    function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Возвращает Уникальный ID продавца на Wildberries
     * @return string|null
     */
    function getSid(): ?string
    {
        return $this->sid;
    }

    /**
     * Возвращает Торговое наименование продавца
     * @return string|null
     */
    function getTradeMark(): ?string
    {
        return $this->tradeMark;
    }


}

