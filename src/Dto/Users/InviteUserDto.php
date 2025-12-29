<?php

namespace Escorp\WbApiClient\Dto\Users;

use InvalidArgumentException;

/**
 * DTO для создания приглашения для нового пользователя
 *
 * Используется в endpoint:
 * POST https://user-management-api.wildberries.ru/api/v1/invite
 */
final class InviteUserDto
{
    /**
     * Номер телефона пользователя для приглашения.
     *
     * Пример: +79161234567
     *
     * @var string
     */
    public string $phone;

    /**
     * Должность пользователя
     *
     * Max length: 150 characters.
     *
     * @var string|null
     */
    public ?string $position;

    /**
     * Настройки доступа к разделам профиля продавца
     * @var AccessDto[]
     */
    public array $access;

    /**
     *
     * @param string $phone Номер телефона (+79161234567)
     * @param string|null $position Должность пользователя (max 150 chars)
     * @param array $access Список правил доступа
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $phone, ?string $position = null, array $access = [])
    {
        if (!preg_match('/^\+\d{10,15}$/', $phone)) {
            throw new InvalidArgumentException('Phone number must be in international format');
        }

        if ($position !== null && mb_strlen($position) > 150) {
            throw new InvalidArgumentException('Position must not exceed 150 characters');
        }

        $this->phone = $phone;
        $this->position = $position;
        $this->access = $this->validateAccess($access);
    }

    /**
     * Валидация правил доступа в соответствии с WB API.
     *
     * @param AccessDto[] $access
     * @return AccessDto[]
     *
     * @throws InvalidArgumentException
     */
    private function validateAccess(array $access): array
    {
        foreach ($access as $item) {
            if (!$item instanceof AccessDto) {
                throw new InvalidArgumentException('Access must be instance of AccessDto');
            }
        }

        return $access;
    }

    /**
     * Преобразует DTO в формат для WB API.
     *
     * @return array{
     *      invite: array{
     *          phoneNumber: string,
     *          position: string|null
     *      },
     *      access: array{
     *          code: string,
     *          disabled: bool
     *      }
     *  }
     */
    public function toRequestArray(): array
    {
        return [
            'invite' => [
                'phoneNumber' => $this->phone,
                'position' => $this->position,
            ],
            'access' => array_map(static fn (AccessDto $a) => $a->toArray(), $this->access),
        ];
    }
}
