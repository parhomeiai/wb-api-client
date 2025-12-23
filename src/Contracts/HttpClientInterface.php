<?php

namespace Escorp\WbApiClient\Contracts;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function request(string $method, string $url, array $options = []): array;
    public function requestRaw(string $method, string $url, array $options = []): ResponseInterface;
}