<?php

namespace Escorp\WbApiClient;

use Escorp\WbApiClient\Api\Prices\PricesApi;

class WbApiClient
{
    public PricesApi $prices;

    public function __construct(PricesApi $prices)
    {
        $this->prices = $prices;
    }

    public function ping(): string
    {
        return 'WB API client works';
    }
}