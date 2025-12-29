<?php

namespace Escorp\WbApiClient\Dto\Users;

use InvalidArgumentException;

/**
 * Изменить права доступа пользователей
 *
 * Используется в endpoint:
 * PUT https://user-management-api.wildberries.ru/api/v1/users/access
 */
class UpdateUsersAccessRequest {

    /**
     * Настройки доступа пользоваиелей
     * @var UserAccessDto[]
     */
    private array $users;

    /**
     *
     * @param array UserAccessDto[] $users
     * @throws InvalidArgumentException
     */
    public function __construct(array $users)
    {
        if (empty($users)) {
            throw new InvalidArgumentException('usersAccesses must not be empty');
        }

        foreach ($users as $u) {
            if (!$u instanceof UserAccessDto) {
                throw new InvalidArgumentException('usersAccesses must contain UserAccessDto');
            }
        }

        $this->users = $users;
    }

    /**
     * Возвращает подготовленные данные для запроса
     * @return array
     */
    public function toRequestArray(): array
    {
        return [
            'usersAccesses' => array_map(fn($u) => $u->toArray(), $this->users)
        ];
    }
}
