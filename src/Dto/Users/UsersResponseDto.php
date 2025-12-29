<?php

declare(strict_types=1);

namespace Escorp\WbApiClient\Dto\Users;

use Escorp\WbApiClient\Dto\WbApiResponseDto;
use Escorp\WbApiClient\Exceptions\DtoMappingException;
use InvalidArgumentException;

/**
 * DTO для ответа на запрос списка пользователей
 *
 * Используется в endpoint:
 * GET https://user-management-api.wildberries.ru/api/v1/users
 */
final class UsersResponseDto extends WbApiResponseDto
{
    /**
     * Общее количество активных или приглашённых пользователей
     *
     * @var int
     */
    public int $total;

    /**
     * Количество активных или приглашённых пользователей на текущей странице
     *
     * @var int
     */
    public int $countInResponse;

    /**
     * Информация о пользователях
     *
     * @var UserDto[]
     */
    public array $users;


    /**
     * Валидирует данный и преобразует в DTO
     *
     * @param array $response
     * @return self
     * @throws DtoMappingException
     */
    public static function fromArray(array $response): self
    {
        foreach (['total', 'countInResponse', 'users'] as $key) {
            if (!array_key_exists($key, $response)) {
                throw new DtoMappingException("UsersResponseDto: missing field '{$key}'");
            }
        }

        if(!is_array($response['users'])){
            throw new InvalidArgumentException("users must be instance of array");
        }

        $wbApiResponseDto = parent::fromArray($response);

        $dto = new self($wbApiResponseDto->data, $wbApiResponseDto->error, $wbApiResponseDto->errorText);

        $dto->total = (int)$response['total'];
        $dto->countInResponse = (int)$response['countInResponse'];

        foreach($response['users'] as $user){
            $this->users[] = UserDto::fromArray($user);
        }

        return $dto;
    }

    /**
     * Возвращает общее количество активных или приглашённых пользователей
     * @return int
     */
    function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Возвращает количество активных или приглашённых пользователей на текущей странице
     * @return int
     */
    function getCountInResponse(): int
    {
        return $this->countInResponse;
    }

    /**
     * Возвращает информацию о пользователях
     * @return array UserDto[]
     */
    function getUsers(): array
    {
        return $this->users;
    }




}

