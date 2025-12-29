<?php

namespace Escorp\WbApiClient\Dto\Users;

use InvalidArgumentException;

/**
 * Настройки доступа для пользователя
 *
 * Используется в endpoint:
 * PUT https://user-management-api.wildberries.ru/api/v1/users/access
 */
class UserAccessDto {

    /**
     * ID пользователя
     * @var int
     */
    public int $userId;

    /**
     * Настройки доступа к разделам профиля продавца
     * @var AccessDto[]
     */
    public array $access;

    /**
     *
     * @param int $userId
     * @param array $access
     * @throws InvalidArgumentException
     */
    public function __construct(int $userId, array $access)
    {
        if ($userId <= 0) {
            throw new InvalidArgumentException('UserId must be positive integer');
        }

        foreach ($access as $a) {
            if (!$a instanceof AccessDto) {
                throw new InvalidArgumentException('Access must be instance of AccessDto');
            }
        }

        $this->userId = $userId;
        $this->access = $access;
    }

    /**
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'access' => array_map(fn($a) => $a->toArray(), $this->access),
        ];
    }
}
