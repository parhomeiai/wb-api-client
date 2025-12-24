<?php


namespace Escorp\WbApiClient\Tests;

use PHPUnit\Framework\TestCase;
use Mockery;
use Escorp\WbApiClient\Api\Prices\PricesApi;
use Escorp\WbApiClient\Tests\Fake\FakeHttpClient;
use Escorp\WbApiClient\Exceptions\DtoMappingException;
use Escorp\WbApiClient\Auth\StaticTokenProvider;
use Escorp\WbApiClient\Contracts\HttpClientInterface;

class PricesApiTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_it_maps_prices_response(): void
    {
        $client = new FakeHttpClient();

        $client->push([
            'data' => [
                'listGoods' => [
                    [
                        'nmID' => 173901872,
                        'vendorCode' => 'a044960',
                        'sizes' => [
                            [
                                'sizeID' => 1,
                                'price' => 1000,
                                'discountedPrice' => 900,
                                'clubDiscountedPrice' => 850,
                                'techSizeName' => '0'
                            ]
                        ],
                        'currencyIsoCode4217' => 'RUB',
                        'discount' => 10,
                        'clubDiscount' => 5,
                        'editableSizePrice' => true,
                    ]
                ]
            ],
            'error' => false,
            'errorText' => '',
        ]);

        $api = new PricesApi($client, new StaticTokenProvider('fake-token'));

        $response = $api->getPricesBatch([173901872]);

        $this->assertFalse($response->hasError());
        $this->assertCount(1, $response->prices);

        $price = $response->prices[0];
        $this->assertSame(173901872, $price->nmId);
        $this->assertSame('a044960', $price->vendorCode);

        $this->assertCount(1, $price->sizes);
        $this->assertSame((float)900, $price->sizes[0]->discountedPrice);
    }

    public function test_it_returns_error_response(): void
    {
        $client = new FakeHttpClient();

        $client->push([
            'data' => null,
            'error' => true,
            'errorText' => 'Invalid token'
        ]);

        $api = new PricesApi($client, new StaticTokenProvider('bade-token'));

        $response = $api->getPricesBatch([1]);

        $this->assertTrue($response->hasError());
        $this->assertSame('Invalid token', $response->getErrorText());
    }

    public function test_it_throws_exception_on_invalid_dto(): void
    {
        $this->expectException(DtoMappingException::class);

        $client = new FakeHttpClient();

        $client->push([
            'data' => [
                'listGoods' => [
                    [
                        'nmID' => 1,
                        // vendorCode отсутствует
                        'sizes' => [],
                        'currencyIsoCode4217' => 'RUB',
                        'discount' => 0,
                        'clubDiscount' => 0,
                        'editableSizePrice' => true,
                    ]
                ]
            ],
            'error' => false,
            'errorText' => '',
        ]);

        $api = new PricesApi($client, new StaticTokenProvider('fake-token'));
        $api->getPricesBatch([1]);
    }

/*
    public function test_get_prices_returns_price_dto_objects(): void
    {
        // 1. Мокаем HTTP клиент
        $httpClient = Mockery::mock(HttpClientInterface::class);

        // 2. Описываем ожидаемый ответ WB API
        $httpClient
            ->shouldReceive('request')
            ->once()
            ->with(
                'POST',
                Mockery::type('string'),
                Mockery::type('array')
            )
            ->andReturn([
                'data' => [
                    'listGoods' => [
                        [
                            'nmId' => 123,
                            'price' => 1000,
                            'discount' => 10,
                        ],
                        [
                            'nmId' => 456,
                            'price' => 2000,
                            'discount' => 0,
                        ],
                    ],
                ],
            ]);

        // 3. Создаём API с подставным клиентом
        $api = new PricesApi(
            $httpClient,
            new StaticTokenProvider('fake-token')
        );

        // 4. Вызываем метод
        $result = $api->getPrices([123, 456]);

        // 5. Проверяем результат
        $this->assertCount(2, $result);

        $this->assertInstanceOf(PriceDto::class, $result[0]);
        $this->assertEquals(123, $result[0]->nmId);
        $this->assertEquals(1000, $result[0]->price);
        $this->assertEquals(10, $result[0]->discount);

        $this->assertEquals(456, $result[1]->nmId);
        $this->assertEquals(2000, $result[1]->price);
    }
*/
}