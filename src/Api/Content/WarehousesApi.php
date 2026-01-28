<?php

namespace Escorp\WbApiClient\Api\Content;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Content\Warehouses\OfficesResponse;
use Escorp\WbApiClient\Dto\Content\Warehouses\WarehousesResponse;
use Escorp\WbApiClient\Dto\Content\Warehouses\WarehouseContactsResponse;
use Escorp\WbApiClient\Dto\Content\Warehouses\WarehouseContactDto;

use InvalidArgumentException;

/**
 * Склады продавца
 *
 */
class WarehousesApi extends AbstractWbApi
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
     * Возвращает список всех складов WB для привязки к складам продавца
     * @return OfficesResponse
     */
    public function getOffices(): OfficesResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v3/offices'
        );

        return OfficesResponse::fromArray($response);
    }

    /**
     * Возвращает список всех складов продавца
     * @return WarehousesResponse
     */
    public function getWarehouses(): WarehousesResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v3/warehouses'
        );

        return WarehousesResponse::fromArray($response);
    }

    /**
     * Создать склад продавца. Возвращает id созданного склада продавца
     *
     * @param string $name
     * @param int $officeId
     * @return int
     * @throws InvalidArgumentException
     */
    public function createWarehouse(string $name, int $officeId): int
    {
        if(mb_strlen($name) > 200){
            throw new InvalidArgumentException('name must be string a string of no more than 200 characters');
        }

        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/api/v3/warehouses',
            [
                'json' => [
                    'name' => $name,
                    'officeId' => $officeId
                ],
            ]
        );

        return (int)($response['id'] ?? 0);
    }

    /**
     * Обновить склад продавца
     * @param int $warehouseId
     * @param string $name
     * @param int $officeId
     * @return bool
     * @throws InvalidArgumentException
     */
    public function updateWarehouse(int $warehouseId, string $name, int $officeId): bool
    {
        if(mb_strlen($name) > 200){
            throw new InvalidArgumentException('name must be string a string of no more than 200 characters');
        }

        $response = $this->request(
            'PUT',
            $this->getBaseUri(). '/api/v3/warehouses/' . $warehouseId,
            [
                'json' => [
                    'name' => $name,
                    'officeId' => $officeId
                ],
            ]
        );

        return true;
    }

    /**
     * Удалить склад продавца
     * @param int $warehouseId
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteWarehouse(int $warehouseId): bool
    {
        $response = $this->request(
            'DELETE',
            $this->getBaseUri(). '/api/v3/warehouses/' . $warehouseId
        );

        return true;
    }

    /**
     * Возвращает список контактов, привязанных к складу продавца. Только для складов с типом доставки 3 — доставка курьером WB (DBW).
     * @param int $warehouseId
     * @return WarehouseContactsResponse
     */
    public function getWarehouseContacts(int $warehouseId): WarehouseContactsResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/api/v3/dbw/warehouses/' . $warehouseId . '/contacts'
        );

        return WarehouseContactsResponse::fromArray($response);
    }

    /**
     * Обновить список контактов склада продавца
     * @param int $warehouseId
     * @param WarehouseContactDto[] $warehouseContacts
     * @return bool
     * @throws InvalidArgumentException
     */
    public function updateWarehouseContacts(int $warehouseId, array $warehouseContacts): bool
    {
        if(count($warehouseContacts) > 5){
            throw new InvalidArgumentException('warehouseContacts must be array a array of no more than 5 items');
        }

        foreach ($warehouseContacts as $c) {
            if (!$c instanceof WarehouseContactDto) {
                throw new InvalidArgumentException('warehouseContacts must contain WarehouseContactDto');
            }
        }

        $response = $this->request(
            'PUT',
            $this->getBaseUri(). '/api/v3/dbw/warehouses/' . $warehouseId . '/contacts',
            [
                'json' => [
                    'contacts' => array_map(function(WarehouseContactDto $warehouseContact){return $warehouseContact->toArray();}, $warehouseContacts),
                ],
            ]
        );

        return true;
    }
}
