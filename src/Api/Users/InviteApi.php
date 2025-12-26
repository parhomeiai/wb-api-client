<?php

namespace Escorp\WbApiClient\Api\Users;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Users\InviteUserDto;
use Escorp\WbApiClient\Dto\Users\InviteResponseDto;

/**
 * Создать приглашение для нового пользователя
 *
 * endpoint:
 * POST https://user-management-api.wildberries.ru/api/v1/invite
 */
class InviteApi  extends AbstractWbApi
{
    /**
     * Создать приглашение для нового пользователя
     *
     * @param InviteUserDto $dto
     * @return InviteResponseDto
     */
    public function createInvite(InviteUserDto $dto): InviteResponseDto
    {
        $url = $this->hosts->get('users') . '/api/v1/invite';

        $response = $this->request('POST', $url, ['json' => $dto->toRequestArray()]);

        return InviteResponseDto::fromArray($response);
    }
}
