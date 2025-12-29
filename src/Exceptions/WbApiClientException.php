<?php

namespace Escorp\WbApiClient\Exceptions;

use RuntimeException;
use Throwable;

class WbApiClientException extends RuntimeException
{
    public static function fromException(Throwable $e): self
    {
        return new self($e->getMessage(), (int) $e->getCode(), $e);
    }
}

