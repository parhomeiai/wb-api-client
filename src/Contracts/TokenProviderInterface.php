<?php

namespace Escorp\WbApiClient\Contracts;

interface TokenProviderInterface
{
    public function getToken(): string;
}