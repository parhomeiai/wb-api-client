<?php

namespace Escorp\WbApiClient;

use Escorp\WbApiClient\Api\Common\PingApi;
use Escorp\WbApiClient\Api\Common\NewsApi;
use Escorp\WbApiClient\Api\Common\SellerApi;
use Escorp\WbApiClient\Api\Users\InviteApi;
use Escorp\WbApiClient\Api\Users\UsersApi;
use Escorp\WbApiClient\Api\Content\ContentApi;
use Escorp\WbApiClient\Api\Prices\PricesApi;
use Escorp\WbApiClient\Api\Content\StocksApi;
use Escorp\WbApiClient\Api\Orders\OrdersFbsApi;

class WbApiClient
{
    public PingApi $ping;

    public NewsApi $newsApi;

    public SellerApi $sellerApi;

    public InviteApi $inviteApi;

    public UsersApi $usersApi;

    public ContentApi $contentApi;

    public PricesApi $prices;

    public StocksApi $stocks;

    public OrdersFbsApi $ordersFbsApi;

    public function __construct(
            PingApi $ping,
            NewsApi $newsApi,
            SellerApi $sellerApi,
            InviteApi $inviteApi,
            UsersApi $usersApi,
            ContentApi $contentApi,
            PricesApi $prices,
            StocksApi $stocks,
            OrdersFbsApi $ordersFbsApi
    ) {
        $this->ping = $ping;
        $this->newsApi = $newsApi;
        $this->sellerApi = $sellerApi;
        $this->inviteApi = $inviteApi;
        $this->usersApi = $usersApi;
        $this->contentApi = $contentApi;
        $this->prices = $prices;
        $this->stocks = $stocks;
        $this->ordersFbsApi = $ordersFbsApi;
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

    /**
     * Возвращает объект для работы с остатками
     * @return PricesApi
     */
    public function stocksApi(): StocksApi
    {
        return $this->stocks;
    }

    /**
     * Возвращает объект для работы с карточками товаров
     * @return ContentApi
     */
    public function contentApi(): ContentApi
    {
        return $this->contentApi;
    }

    /**
     * Возвращает объект для управлениями пользователями
     * @return UsersApi
     */
    public function usersApi(): UsersApi
    {
        return $this->usersApi;
    }

    /**
     * Возвращает объект для работы с заказами FBS
     * @return OrdersFbsApi
     */
    public function ordersFbsApi(): OrdersFbsApi
    {
        return $this->ordersFbsApi;
    }
}