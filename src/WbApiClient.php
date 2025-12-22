<?php

namespace Escorp\WbApiClient;

class WbApiClient
{
    protected string $apiKey;

    public function __construct(?string $apiKey)
    {
        $this->apiKey = $apiKey ?? '';
    }

    public function ping(): string
    {
        return 'WB API client works';
    }
}