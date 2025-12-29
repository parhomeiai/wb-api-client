<?php

namespace Escorp\WbApiClient\Dto\Users;

/**
 * Информация о приглашении
 *
 * @author parhomey
 */
class InviteInfoDto {

    /**
     * Номер телефона приглашённого пользователя
     *
     * @var string|null
     */
    public ?string $phoneNumber;


    /**
     * Должность приглашённого пользователя
     *
     * @var string|null
     */
    public ?string $position;


    /**
     * ID приглашения
     *
     * @var string|null
     */
    public ?string $inviteUuid;

    /**
     * Дата и время окончания срока действия приглашения
     *
     * @var string|null
     */
    public ?string $expiredAt;

    /**
     * Статус приглашения: true — приглашение активно, false — приглашение неактивно
     *
     * @var bool|null
     */
    public ?bool $isActive;

    /**
     *
     * @param string $phoneNumber
     * @param string $position
     * @param string $inviteUuid
     * @param string $expiredAt
     * @param bool $isActive
     */
    function __construct(?string $phoneNumber, ?string $position, ?string $inviteUuid, ?string $expiredAt, ?bool $isActive) {
        $this->phoneNumber = $phoneNumber;
        $this->position = $position;
        $this->inviteUuid = $inviteUuid;
        $this->expiredAt = $expiredAt;
        $this->isActive = $isActive;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['phoneNumber']) ? (string)$data['phoneNumber'] : null,
            isset($data['position']) ? (string)$data['position'] : null,
            isset($data['inviteUuid']) ? (string)$data['inviteUuid'] : null,
            isset($data['expiredAt']) ? (string)$data['expiredAt'] : null,
            isset($data['isActive']) ? (bool)$data['isActive'] : null,
        );
    }

}
