<?php

namespace Escorp\WbApiClient;

use Escorp\WbApiClient\Api\Common\PingApi;
use Escorp\WbApiClient\Api\Common\NewsApi;
use Escorp\WbApiClient\Api\Prices\PricesApi;

class WbApiClient
{
    public PingApi $ping;

    public NewsApi $newsApi;

    public PricesApi $prices;

    public function __construct(
            PingApi $ping,
            NewsApi $newsApi,
            PricesApi $prices
    ) {
        $this->ping = $ping;
        $this->newsApi = $newsApi;
        $this->prices = $prices;
    }

    public function ping(): string
    {
        return 'WB API client works';
    }

    /**
     * Возвращает объект для проверки подключения
     * @return PingApi
     */
    public function pingApi(): PingApi
    {
        return $this->ping;
    }

    /**
     * Возвращает объект для получения новостей портала продавцов
     * @return NewsApi
     */
    public function newsApi(): NewsApi
    {
        return $this->newsApi;
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