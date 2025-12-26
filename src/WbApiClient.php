<?php

namespace Escorp\WbApiClient;

use Escorp\WbApiClient\Api\Common\PingApi;
use Escorp\WbApiClient\Api\Common\NewsApi;
use Escorp\WbApiClient\Api\Common\SellerApi;
use Escorp\WbApiClient\Api\Users\InviteApi;
use Escorp\WbApiClient\Api\Prices\PricesApi;

class WbApiClient
{
    public PingApi $ping;

    public NewsApi $newsApi;

    public SellerApi $sellerApi;

    public InviteApi $inviteApi;

    public PricesApi $prices;

    public function __construct(
            PingApi $ping,
            NewsApi $newsApi,
            SellerApi $sellerApi,
            InviteApi $inviteApi,
            PricesApi $prices
    ) {
        $this->ping = $ping;
        $this->newsApi = $newsApi;
        $this->sellerApi = $sellerApi;
        $this->inviteApi = $inviteApi;
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
     * Возвращает объект для получения информации о продавце
     * @return SellerApi
     */
    public function sellerApi(): SellerApi
    {
        return $this->sellerApi;
    }

    /**
     * Возвращает объект для создания приглашения для нового пользователя
     * @return InviteApi
     */
    public function inviteApi(): InviteApi
    {
        return $this->inviteApi;
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