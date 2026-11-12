<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

use InvalidArgumentException;

/**
 * Маркировка заказа
 */
class MetaOrderDto
{
    public array $data;

    /**
     * ID сборочного задания
     * @var int
     */
    public int $id;

    /**
     * Детали маркировки
     * @var MetaDetailDto[]
     */
    public array $metaDetails = [];

    function __construct(int $id, array $metaDetails, array $data)
    {
        foreach ($metaDetails as $m) {
            if (!$m instanceof MetaDetailDto) {
                throw new InvalidArgumentException('metaDetails must contain MetaDetailDto');
            }
        }

        $this->data = $data;
        $this->id = $id;
        $this->metaDetails = $metaDetails;
    }

        /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $metaDetails = [];
        foreach($data['metaDetails'] ?? [] as $metaDetail){
            $metaDetails[] = MetaDetailDto::fromArray($metaDetail);
        }

        return new self(
            (string)($data['id'] ?? ''),
            $metaDetails,
            $data
        );
    }
}
