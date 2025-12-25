<?php

namespace Escorp\WbApiClient;

use Escorp\WbApiClient\Api\Common\PingApi;
use Escorp\WbApiClient\Api\Prices\PricesApi;

class WbApiClient
{
    public PingApi $ping;

    public PricesApi $prices;

    public function __construct(
            PingApi $ping,
            PricesApi $prices
    ) {
        $this->ping = $ping;
        $this->prices = $prices;
    }

    public function ping(): string
    {
        return 'WB API client works';
    }

    public function pingApi(): PingApi
    {
        return $this->ping;
    }

    /**
     * Возвращает объект для работы с ценами
     * @return PricesApi
     */
    public function pricesApi(): PricesApi
    {
        return $this->prices;
    }
}