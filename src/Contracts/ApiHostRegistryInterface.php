<?php

namespace Escorp\WbApiClient\Contracts;

/**
 *
 * @author parhomey
 */
interface ApiHostRegistryInterface
{
    public function get(string $api): string;
}
