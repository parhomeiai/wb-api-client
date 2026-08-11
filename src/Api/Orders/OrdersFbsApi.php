<?php

namespace Escorp\WbApiClient\Api\Orders;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Orders\FBS\OrdersResponse;
use Escorp\WbApiClient\Dto\Orders\FBS\OrdersStatusResponse;
use Escorp\WbApiClient\Dto\Orders\FBS\OrdersReshipmentResponse;

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

    /**
     * Получить информацию о сборочных заданиях
     * Можно получить данные за заданный период, максимум 30 календарных дней одним запросом.
     *
     * @param int $limit
     * @param int $next
     * @param int|null $dateForm - Дата начала периода в формате Unix timestamp. По умолчанию — дата за 30 дней до запроса
     * @param int|null $dateTo - Дата конца периода в формате Unix timestamp
     * @return OrdersResponse
     */
    public function getOrders(int $limit = 1000, int $next = 0, ?int $dateForm = null, ?int $dateTo = null): OrdersResponse
    {
        $query = [
            'limit' => $limit,
            'next' => $next
        ];

        if($dateForm){
            $query['dateFrom'] = $dateForm;
        }

        if($dateTo){
            $query['dateTo'] = $dateTo;
        }

        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v3/orders',
            [
                'query' => $query
            ]
        );

        return OrdersResponse::fromArray($response);
    }

    /**
     * Получить информацию о сборочных заданиях
     * Можно получить данные за заданный период, максимум 30 календарных дней одним запросом.
     *
     * @param int|null $dateForm - Дата начала периода в формате Unix timestamp. По умолчанию — дата за 30 дней до запроса
     * @param int|null $dateTo - Дата конца периода в формате Unix timestamp
     * @return OrderDto[]
     */
    public function getOrdersBatch(?int $dateForm = null, ?int $dateTo = null): array
    {
        $next = 0;
        $result = [];

        do {
            $response = $this->getOrders(1000, $next, $dateForm, $dateTo);

            $result = array_merge($result, $response->orders());

            if ($response->next) {
                usleep(200_000);
            }

            $next = $response->next;

        } while ($response->next);

        return $result;
    }

    /**
     * Получить статусы сборочных заданий
     *
     * @param array $ordersIds
     * @return OrdersStatusResponse
     */
    public function getOrdersStatus(array $ordersIds): OrdersStatusResponse
    {
        if(count($ordersIds) > 1000){
            throw new InvalidArgumentException('ordersIds must be an array of no more than 1000 elements');
        }

        foreach ($ordersIds as $id) {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException('ordersId must be integer, got: ' . gettype($id));
            }
        }

        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/api/v3/orders/status',
            [
                'json' => ['orders' => array_map('intval', $ordersIds)]
            ]
        );

        return OrdersStatusResponse::fromArray($response);
    }

    /**
     * Получить все сборочные задания для повторной отгрузки
     * @return OrdersReshipmentResponse
     */
    public function getOrdersReshipment(): OrdersReshipmentResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v3/supplies/orders/reshipment'
        );

        return OrdersReshipmentResponse::fromArray($response);
    }

    /**
     * Отменить сборочное задание
     * @param int $orderId
     * @return type
     */
    public function orderCancel(int $orderId)
    {
        $response = $this->request(
            'PATCH',
            $this->getBaseUri(). '/api/v3/orders/' . $orderId . '/cancel'
        );

        return $response;
    }

    /**
     * Получить стикеры сборочных заданий
     *
     * @param array $ordersIds
     * @param string $type
     * @param int $width
     * @param int $height
     */
    public function getOrdersStickers(array $ordersIds, string $type = 'svg', int $width = 58, int $height = 40)
    {

    }
}
