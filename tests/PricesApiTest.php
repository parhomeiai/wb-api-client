<?php


namespace Escorp\WbApiClient\Tests;

use PHPUnit\Framework\TestCase;
use Mockery;
use Escorp\WbApiClient\Api\Prices\PricesApi;
use Escorp\WbApiClient\Auth\StaticTokenProvider;
use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Escorp\WbApiClient\Dto\PriceDto;

class PricesApiTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

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
}