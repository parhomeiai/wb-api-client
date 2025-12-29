<?php

declare(strict_types=1);

namespace Escorp\WbApiClient\Tests;

use Http\Mock\Client as MockClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Escorp\WbApiClient\Exceptions\WbApiClientException;
use Escorp\WbApiClient\Exceptions\WbHttpException;
use Escorp\WbApiClient\Http\Psr18HttpClient;
use Escorp\WbApiClient\Dto\WbErrorDto;

/**
 *
 */
final class Psr18HttpClientTest extends TestCase
{
    private MockClient $mock;
    private Psr18HttpClient $client;

    protected function setUp(): void
    {
        $psr17 = new Psr17Factory();
        $this->mock = new MockClient();
        $this->client = new Psr18HttpClient($this->mock, $psr17, $psr17);
    }

    /** @test */
    public function it_returns_decoded_json_on_success(): void
    {
        $this->mock->addResponse(new Response(200, [], json_encode(['ok' => true])));

        $result = $this->client->request('GET', 'https://test');

        $this->assertSame(['ok' => true], $result);
    }

    /** @test */
    public function it_returns_empty_array_for_empty_body(): void
    {
        $this->mock->addResponse(new Response(200));

        $result = $this->client->request('GET', 'https://test');

        $this->assertSame([], $result);
    }

    /** @test */
    public function it_throws_exception_on_invalid_json(): void
    {
        $this->mock->addResponse(new Response(200, [], '{broken'));

        $this->expectException(WbApiClientException::class);

        $this->client->request('GET', 'https://test');
    }

    /** @test */
    public function it_throws_wb_http_exception_on_json_error_response(): void
    {
        $error = [
            'title' => 'Access denied',
            'detail' => 'Invalid key',
            'status' => 401
        ];

        $this->mock->addResponse(new Response(401, [], json_encode($error)));

        try {
            $this->client->request('GET', 'https://test');
            $this->fail('Exception not thrown');
        } catch (WbHttpException $e) {
            $this->assertInstanceOf(WbErrorDto::class, $e->getError());
            $this->assertSame(401, $e->getError()->status);
        }
    }

    /** @test */
    public function it_throws_api_exception_on_non_json_error_response(): void
    {
        $this->mock->addResponse(new Response(500, [], 'Internal error'));

        $this->expectException(WbApiClientException::class);

        $this->client->request('GET', 'https://test');
    }

    /** @test */
    public function it_throws_exception_on_conflicting_body_sources(): void
    {
        $this->expectException(\LogicException::class);

        $this->client->request('POST', 'https://test', [
            'json' => ['a' => 1],
            'body' => 'raw'
        ]);
    }

    /** @test */
    public function it_builds_query_string_correctly(): void
    {
        $this->mock->addResponse(new Response(200, [], json_encode(['ok'=>1])));

        $this->client->request('GET', 'https://test', [
            'query' => ['from' => '2025-02-01']
        ]);

        $request = $this->mock->getLastRequest();

        $this->assertStringContainsString('from=2025-02-01', (string)$request->getUri());
    }

    /** @test */
    public function it_wraps_psr18_client_exception(): void
    {
        $this->mock->addException(new \RuntimeException('Transport error'));

        $this->expectException(WbApiClientException::class);

        $this->client->request('GET', 'https://test');
    }
}
