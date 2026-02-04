<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

/**
 * Точный адрес покупателя для доставки, если применимо
 *
 */
class OrderAddressDto
{
    public array $data;

    /**
     * Адрес доставки
     * @var string
     */
    private ?string $fullAddress;

    /**
     * Долгота
     * @var float
     */
    private ?float $longitude;

    /**
     * Широта
     * @var float
     */
    private ?float $latitude;

    /**
     *
     * @param string|null $fullAddress
     * @param float|null $longitude
     * @param float|null $latitude
     */
    function __construct(?string $fullAddress, ?float $longitude, ?float $latitude, array $data = []) {
        $this->fullAddress = $fullAddress;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->data = $data;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            ($data['fullAddress'] ?? null),
            ($data['longitude'] ?? null),
            ($data['latitude'] ?? null),
            $data
        );
    }
}
