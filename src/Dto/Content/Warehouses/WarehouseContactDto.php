<?php

namespace Escorp\WbApiClient\Dto\Content\Warehouses;

/**
 * Контакт склада продавца
 *
 */
class WarehouseContactDto
{
    /**
     * Комментарий
     * @var string
     */
    private string $comment;

    /**
     * Номер телефона
     * @var string
     */
    private string $phone;

    /**
     *
     * @param string $comment
     * @param string $phone
     */
    function __construct(string $comment, string $phone)
    {
        $this->comment = $comment;
        $this->phone = $phone;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['comment'] ?? ''),
            (string)($data['phone'] ?? '')
        );
    }

    function getComment(): string
    {
        return $this->comment;
    }

    function getPhone(): string
    {
        return $this->phone;
    }

    function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function toArray(): array
    {
        return [
            'comment' => $this->comment,
            'phone' => $this->phone,
        ];
    }
}
