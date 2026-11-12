<?php

namespace Escorp\WbApiClient\Api\Orders;

use Escorp\WbApiClient\Api\AbstractWbApi;

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


    public function ordersMeta(array $ordersIds)
    {
        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/api/marketplace/v3/orders/meta',
            [
                'json' => ['orders' => $ordersIds]
            ]
        );

        return $response;
    }

}
