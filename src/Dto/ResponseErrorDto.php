<?php

namespace Escorp\WbApiClient\Dto;

/**
 * Description of ResponseErrorDto
 *
 * @author parhomey
 */
final class ResponseErrorDto
{

    /**
     *
     * @var mixed
     */
    public $data;

    public array $nmIds;
    public string $message;

    public function __construct(array $nmIds, string $message, $data)
    {
        $this->nmIds = $nmIds;
        $this->message = $message;
        $this->data = $data;
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
     * Возвращает артикулы WB товаров на которых возникла ошибка
     * @return array
     */
    function getNmIds(): array
    {
        return $this->nmIds;
    }

    /**
     * Возвращает сообщение об ошибке
     * @return string
     */
    function getMessage(): string
    {
        return $this->message;
    }


}
