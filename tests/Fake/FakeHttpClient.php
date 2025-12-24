<?php

namespace Escorp\WbApiClient\Tests\Fake;

use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Description of FakeHttpClient
 *
 * @author parhomey
 */
final class FakeHttpClient implements HttpClientInterface
{
    private array $queue = [];

    public function push(array $response): void
    {
        $this->queue[] = $response;
    }

    public function request(string $method, string $url, array $options = array()): array {
        return array_shift($this->queue);
    }

    public function requestRaw(string $method, string $url, array $options = array()): ResponseInterface
    {
        throw new \LogicException('Not implemented in Fake');
    }

}
