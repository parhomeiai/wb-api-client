<?php

namespace Escorp\WbApiClient\Api\Orders;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Orders\FBS\MetaResponse;

use InvalidArgumentException;

/**
 * Идентификаторы маркировки FBS
 */
class MetaFbsApi extends AbstractWbApi
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
     * Получить идентификаторы маркировки сборочных заданий
     *
     * @param array $ordersIds
     * @return MetaResponse
     * @throws InvalidArgumentException
     */
    public function ordersMeta(array $ordersIds): MetaResponse
    {
        if(count($ordersIds) > 100){
            throw new InvalidArgumentException('ordersIds must be an array of no more than 100 elements');
        }

        foreach ($ordersIds as $id) {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException('ordersId must be integer, got: ' . gettype($id));
            }
        }

        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/api/marketplace/v3/orders/meta',
            [
                'json' => ['orders' => array_map('intval', $ordersIds)]
            ]
        );

        return MetaResponse::fromArray($response);
    }

    /**
     * Удалить идентификаторы маркировки сборочного задания
     *
     * @param int $orderId
     * @param string $key
     * @return type
     */
    public function deleteMeta(int $orderId, string $key)
    {
        $response = $this->request(
            'DELETE',
            $this->getBaseUri(). '/api/v3/orders/' . $orderId . '/meta',
            [
                'query'   => ['key' => $key],
            ]
        );
        
        return $response;
    }

}
