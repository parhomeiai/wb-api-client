<?php

namespace Escorp\WbApiClient\Api\Orders;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Orders\FBS\SupplyResponse;
use Escorp\WbApiClient\Dto\Orders\FBS\SupplyOrdersIdsResponse;

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

    /**
     * Получить информацию о поставке
     *
     * @param string $spplyId
     * @return SupplyResponse
     */
    public function supply(string $spplyId): SupplyResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v3/supplies/' . $spplyId
        );

        return SupplyResponse::fromArray($response);
    }

    /**
     * Получить ID сборочных заданий поставки
     * 
     * @param string $spplyId
     * @return SupplyOrdersIdsResponse
     */
    public function orderIds(string $spplyId): SupplyOrdersIdsResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/marketplace/v3/supplies/' . $spplyId . '/order-ids'
        );

        return SupplyOrdersIdsResponse::fromArray($response);
    }
}
