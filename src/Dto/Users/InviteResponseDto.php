<?php

declare(strict_types=1);

namespace Escorp\WbApiClient\Dto\Users;

use Escorp\WbApiClient\Dto\WbApiResponseDto;
use Escorp\WbApiClient\Exceptions\DtoMappingException;

/**
 * DTO для ответа на запрос создания приглашения для нового пользователя
 *
 * Используется в endpoint:
 * POST https://user-management-api.wildberries.ru/api/v1/invite
 */
final class InviteResponseDto extends WbApiResponseDto
{
    /**
     * ID приглашения
     *
     * @var string
     */
    public string $inviteID;

    /**
     * Дата и время окончания срока действия приглашения
     *
     * @var string
     */
    public string $expiredAt;

    /**
     * Заголовок новости
     *
     * true — приглашение создано успешно
     * false — повторите запрос
     *
     * @var boolean
     */
    public bool $isSuccess;

    /**
     * URL приглашения, по которому должен перейти пользователь
     *
     * @var string
     */
    public string $inviteUrl;


    /**
     * Валидирует данный и преобразует в DTO
     *
     * @param array $response
     * @return self
     * @throws DtoMappingException
     */
    public static function fromArray(array $response): self
    {
        foreach (['inviteID', 'expiredAt', 'isSuccess', 'inviteUrl'] as $key) {
            if (!array_key_exists($key, $response)) {
                throw new DtoMappingException("InviteResponseDto: missing field '{$key}'");
            }
        }

        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText);

        $dto->inviteID = (string)$response['inviteID'];
        $dto->expiredAt = (string)$response['expiredAt'];
        $dto->isSuccess = (bool)$response['isSuccess'];
        $dto->inviteUrl = (string)$response['inviteUrl'];

        return $dto;
    }

    /**
     * Возвращает ID приглашения
     *
     * @return string
     */
    function getInviteID(): string
    {
        return $this->inviteID;
    }

    /**
     * Возвращает Дата и время окончания срока действия приглашения
     *
     * @return string
     */
    function getExpiredAt(): string
    {
        return $this->expiredAt;
    }

    /**
     * Возвращает статус создания приглашения
     *
     * @return bool
     */
    function getIsSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * Возвращает URL приглашения, по которому должен перейти пользователь
     *
     * @return string
     */
    function getInviteUrl(): string
    {
        return $this->inviteUrl;
    }


}

