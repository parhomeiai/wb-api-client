<?php


namespace Escorp\WbApiClient\Tests;

use PHPUnit\Framework\TestCase;
use Http\Mock\Client;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Escorp\WbApiClient\Api\Orders\OrdersFbsApi;
use Escorp\WbApiClient\Api\ApiHostRegistry;
use Escorp\WbApiClient\Auth\StaticTokenProvider;
use Escorp\WbApiClient\Http\Psr18HttpClient;

class OrdersApiTest extends TestCase
{
    public function testGetNewOrdersSuccess(): void
    {
        $psr17 = new Psr17Factory();
        $mock = new Client();

        $mock->addResponse(new Response(200, [], json_encode([
            'orders' => [
                    [
                        'id' => 1,
                        'rid' => 'RID123',
                        'article' => 'A-1',
                        'nmId' => 100,
                        'chrtId' => 200,
                        'warehouseId' => 10,
                        'officeId' => 20,
                        'skus' => ['SKU1'],
                        'price' => 10000,
                        'finalPrice' => 9500,
                        'currencyCode' => 643,
                        'createdAt' => '2024-01-01T10:00:00Z',
                    ]
                ]
        ])));

        $http = new Psr18HttpClient($mock, $psr17, $psr17);
        $api = new OrdersFbsApi($http, new StaticTokenProvider('TOKEN'), new ApiHostRegistry());

        $result = $api->getNewOrders();

        $this->assertCount(1, $result->orders);
        $this->assertSame(100, $result->orders[0]->nmId);
        $this->assertSame(1, $result->orders[0]->id);
    }

}