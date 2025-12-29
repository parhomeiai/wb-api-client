<?php

namespace Escorp\WbApiClient\Api\Users;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Users\UsersResponseDto;
use InvalidArgumentException;

/**
 * Управление пользователями продавца
 *
 */
class UsersApi extends AbstractWbApi
{
    /**
     * Возвращает домен
     *
     * @return string
     */
    private function getBaseUri(): string
    {
        return $this->hosts->get('users');
    }

    /**
     * Получить список активных или приглашённых пользователей продавца
     *
     * @param int $limit
     * @param int $offset
     * @param bool $isInviteOnly
     * @return UsersResponseDto
     * @throws InvalidArgumentException
     */
    public function getUsers(int $limit = 100, int $offset = 0, bool $isInviteOnly = false): UsersResponseDto
    {
        if ($limit < 1 || $limit > 100) {
            throw new InvalidArgumentException('Limit must be between 1 and 100');
        }

        if ($offset < 0) {
            throw new InvalidArgumentException('Offset must be >= 0');
        }

        $url = $this->getBaseUri() . '/api/v1/users';

        $query = [
            'limit' => $limit,
            'offset' => $offset,
            'isInviteOnly' => $isInviteOnly
        ];

        $response = $this->request('GET', $url, [
            'query'   => $query,
        ]);

        return UsersResponseDto::fromArray($response);
    }

    public function changeAccess()
    {

    }

    public function deleteUser()
    {

    }
}
