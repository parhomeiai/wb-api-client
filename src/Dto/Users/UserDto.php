<?php

namespace Escorp\WbApiClient\Dto\Users;

use Escorp\WbApiClient\Exceptions\DtoMappingException;
use InvalidArgumentException;

/**
 * Информация о пользователе
 */
final class UserDto
{

    /**
     * ID пользователя
     */
    public int $id;

    /**
     * Роль пользователя:
     * user — пользователь, который активировал доступ
     * (пустая строка) — пользователь, который не активировал доступ
     *
     * @var string
     */
    public string $role;

    /**
     * Должность пользователя
     *
     * @var string
     */
    public string $position;

    /**
     * Номер телефона пользователя
     *
     * @var string
     */
    public string $phone;

    /**
     * Email пользователя
     *
     * @var string
     */
    public string $email;

    /**
     * Является ли пользователь владельцем профиля продавца
     *
     * @var bool
     */
    public bool $isOwner;

    /**
     * Имя пользователя
     *
     * @var string
     */
    public string $firstName;

    /**
     * Фамилия пользователя
     *
     * @var string
     */
    public string $secondName;

    /**
     * Отчество пользователя
     *
     * @var string
     */
    public string $patronymic;

    /**
     * Может ли пользователь одобрять возвраты товаров
     *
     * @var bool
     */
    public bool $goodsReturn;

    /**
     * Приглашён ли пользователь
     *
     * @var bool
     */
    public bool $isInvitee;

    /**
     * Информация о приглашении, если пользователь приглашён
     *
     * @var InviteUserDto|null
     */
    public ?InviteInfoDto $inviteeInfo;

    /**
     * Настройки доступа к разделам профиля продавца
     *
     * @var array AccessDto[]
     */
    public array $access;


    function __construct(int $id, string $role, string $position, string $phone, string $email, bool $isOwner, string $firstName, string $secondName, string $patronymic, bool $goodsReturn, bool $isInvitee, ?InviteInfoDto $inviteeInfo, array $access) {
        $this->id = $id;
        $this->role = $role;
        $this->position = $position;
        $this->phone = $phone;
        $this->email = $email;
        $this->isOwner = $isOwner;
        $this->firstName = $firstName;
        $this->secondName = $secondName;
        $this->patronymic = $patronymic;
        $this->goodsReturn = $goodsReturn;
        $this->isInvitee = $isInvitee;
        $this->inviteeInfo = $inviteeInfo;
        $this->access = $this->validateAccess($access);
    }

        /**
     *
     * @param array $data
     * @return self
     * @throws DtoMappingException
     */
    public static function fromArray(array $data): self
    {
        foreach (['id','role', 'position', 'phone', 'email', 'isOwner', 'firstName', 'secondName', 'patronymic', 'goodsReturn', 'isInvitee', 'inviteeInfo', 'access'] as $key) {
            if (!array_key_exists($key, $data)) {
                throw new DtoMappingException("UserDto: missing field '{$key}'");
            }
        }

        $inviteInfoDto = ($data['inviteeInfo']) ? InviteInfoDto::fromArray($data['inviteeInfo']) : null;

        $access = [];
        foreach ($data['access'] ?? [] as $access) {
            $access[] = AccessDto::fromArray($access);
        }

        return new self(
            (int) $data['id'],
            (string) $data['role'],
            (string) $data['position'],
            (string) $data['phone'],
            (string) $data['email'],
            (bool) $data['isOwner'],
            (string) $data['firstName'],
            (string) $data['secondName'],
            (string) $data['patronymic'],
            (bool) $data['goodsReturn'],
            (bool) $data['isInvitee'],
            $inviteInfoDto,
            $access
        );
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
}

