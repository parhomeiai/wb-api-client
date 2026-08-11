<?php

namespace Escorp\WbApiClient\Api\Orders;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Orders\FBS\OrdersResponse;
use Escorp\WbApiClient\Dto\Orders\FBS\OrdersStatusResponse;
use Escorp\WbApiClient\Dto\Orders\FBS\OrdersReshipmentResponse;

use InvalidArgumentException;
use Escorp\WbApiClient\Exceptions\WbApiClientException;

/**
 * Поставки FBS(Fulfillment by Seller)
 *
 */
class SuppliesFbsApi extends AbstractWbApi
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
     * Создание новой поставки
     *
     * @param string|null $name
     * @return string
     */
    public function createSupply(?string $name = null): string
    {
        $json = [];
        if($name){
            $json['name'] = $name;
        }

        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/api/v3/supplies',
            [
                'json' => $json
            ]
        );

        return $response;
    }

    public function supply(string $spplyId)
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v3/supplies/' . $spplyId
        );

        return $response;
    }

    public function orderIds(string $spplyId)
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/marketplace/v3/supplies/' . $spplyId . '/order-ids'
        );

        return $response;
    }
}
