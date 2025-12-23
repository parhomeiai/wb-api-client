<?php

namespace Escorp\WbApiClient\Contracts;

interface HttpClientInterface
{
    public function request(string $method, string $url, array $options = []): array;
}