<?php

namespace Escorp\WbApiClient\Api;

use Escorp\WbApiClient\Contracts\ApiHostRegistryInterface;
/**
 * Description of ApiHostRegistry
 *
 * @author parhomey
 */
class ApiHostRegistry implements ApiHostRegistryInterface
{
    private array $hosts = [
        'common'  => 'https://common-api.wildberries.ru',
        'prices'  => 'https://discounts-prices-api.wildberries.ru',
        'users'  => 'https://user-management-api.wildberries.ru',
        'content'  => 'https://content-api.wildberries.ru',
        'marketplace'  => 'https://marketplace-api.wildberries.ru',
    ];

    /**
     * Возвращает хост раздела (common, prices, users, content)
     *
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     */
    public function get(string $key): string
    {
        if (!isset($this->hosts[$key])) {
            throw new InvalidArgumentException("Unknown API host: {$key}");
        }
        return $this->hosts[$key];
    }
}
