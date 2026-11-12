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

    /**
     * Закрепить код маркировки Честного знака за сборочным заданием
     *
     * @param int $orderId
     * @param array $sgtins
     * @return type
     */
    public function metaSgtin(int $orderId, array $sgtins)
    {
        if(count($sgtins) > 100){
            throw new InvalidArgumentException('sgtins must be an array of no more than 100 elements');
        }

        $response = $this->request(
            'PUT',
            $this->getBaseUri(). '/api/v3/orders/' . $orderId . '/meta/sgtin',
            [
                'json' => ['sgtins' => $sgtins]
            ]
        );

        return $response;
    }

    /**
     * Закрепить УИН за сборочным заданием
     *
     * @param int $orderId
     * @param string $uin
     * @return type
     */
    public function metaUin(int $orderId, string $uin)
    {
        $response = $this->request(
            'PUT',
            $this->getBaseUri(). '/api/v3/orders/' . $orderId . '/meta/uin',
            [
                'json' => ['uin' => $uin]
            ]
        );

        return $response;
    }

    /**
     * Закрепить IMEI за сборочным заданием
     *
     * @param int $orderId
     * @param string $imei
     * @return type
     */
    public function metaImei(int $orderId, string $imei)
    {
        $response = $this->request(
            'PUT',
            $this->getBaseUri(). '/api/v3/orders/' . $orderId . '/meta/imei',
            [
                'json' => ['imei' => $imei]
            ]
        );

        return $response;
    }

    /**
     * Закрепить GTIN за сборочным заданием
     * @param int $orderId
     * @param string $gtin
     * @return type
     */
    public function metaGtin(int $orderId, string $gtin)
    {
        $response = $this->request(
            'PUT',
            $this->getBaseUri(). '/api/v3/orders/' . $orderId . '/meta/gtin',
            [
                'json' => ['gtin' => $gtin]
            ]
        );

        return $response;
    }

    /**
     * Закрепить за сборочным заданием срок годности товара
     * @param int $orderId
     * @param string $expiration
     * @return type
     */
    public function metaExpiration(int $orderId, string $expiration)
    {
        $response = $this->request(
            'PUT',
            $this->getBaseUri(). '/api/v3/orders/' . $orderId . '/meta/expiration',
            [
                'json' => ['expiration' => $expiration]
            ]
        );

        return $response;
    }

    /**
     * Закрепить номер ДТ за сборочным заданием
     * @param int $orderId
     * @param string $customsDeclaration
     * @return type
     */
    public function metaCustomsDeclaration(int $orderId, string $customsDeclaration)
    {
        $response = $this->request(
            'PUT',
            $this->getBaseUri(). '/api/marketplace/v3/orders/' . $orderId . '/meta/customs-declaration',
            [
                'json' => ['customsDeclaration' => $customsDeclaration]
            ]
        );

        return $response;
    }
}
