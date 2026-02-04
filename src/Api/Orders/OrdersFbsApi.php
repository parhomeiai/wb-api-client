<?php

namespace Escorp\WbApiClient\Api\Orders;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Orders\FBS\OrdersResponse;

use InvalidArgumentException;
use Escorp\WbApiClient\Exceptions\WbApiClientException;

/**
 * Заказы FBS(Fulfillment by Seller)
 *
 */
class OrdersFbsApi extends AbstractWbApi
{
    /**
     * Возвращает домен
     *
     * @return string
     */
    private function getBaseUri(): string
    {
        return $this->hosts->get('marketplace');
    }

    /**
     * Метод возвращает список всех новых сборочных заданий, которые есть у продавца на момент запроса.
     * @return OrdersResponse
     */
    public function getNewOrders(): OrdersResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v3/orders/new'
        );

        return OrdersResponse::fromArray($response);
    }
}
