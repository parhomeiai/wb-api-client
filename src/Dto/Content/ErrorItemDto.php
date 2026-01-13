<?php

namespace Escorp\WbApiClient\Dto\Content;

use InvalidArgumentException;

/**
 * Пакет данных
 *
 * @author parhomey
 */
class ErrorItemDto
{
    public array $data;

    /**
     * ID пакета
     * @var string
     */
    public string $batchUUID;

    /**
     * Предметы. Разбивка по vendorCodes
     * @var array|ErrorModelDto[]
     */
    public array $subjects = [];

    /**
     * Бренды. Разбивка по vendorCodes
     * @var array|ErrorModelDto[]
     */
    public array $brands = [];

    /**
     * Артикулы продавца
     * @var array|string[]
     */
    public array $vendorCodes = [];

    /**
     * Ошибки. Разбивка по vendorCodes
     * @var array|string[]
     */
    public array $errors = [];

    /**
     *
     * @param string $batchUUID
     * @param array $subjects
     * @param array $brands
     * @param array $vendorCodes
     * @param array $errors
     * @throws InvalidArgumentException
     */
    function __construct(string $batchUUID, array $subjects, array $brands, array $vendorCodes, array $errors)
    {
        foreach ($subjects as $s) {
            if (!$s instanceof ErrorModelDto) {
                throw new InvalidArgumentException('subjects must contain ErrorModelDto');
            }
        }
        foreach ($brands as $b) {
            if (!$b instanceof ErrorModelDto) {
                throw new InvalidArgumentException('brands must contain ErrorModelDto');
            }
        }
        foreach ($errors as $e) {
            if (!is_array($e)) {
                throw new InvalidArgumentException('errors must contain array');
            }
        }

        $this->batchUUID = $batchUUID;
        $this->subjects = $subjects;
        $this->brands = $brands;
        $this->vendorCodes = $vendorCodes;
        $this->errors = $errors;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $subjects = [];
        foreach($data['subjects'] ?? [] as $vendorCode => $subject){
            $subjects[$vendorCode] = ErrorModelDto::fromArray($subject);
        }

        $brands = [];
        foreach($data['brands'] ?? [] as $vendorCode => $brand){
            $brands[$vendorCode] = ErrorModelDto::fromArray($brand);
        }

        $item = new self(
            (string)($data['batchUUID'] ?? ''),
            $subjects,
            $brands,
            ($data['vendorCodes'] ?? []),
            ($data['errors'] ?? [])
        );

        $item->data = $data;

        return $item;
    }
}
