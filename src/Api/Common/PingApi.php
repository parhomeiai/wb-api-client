<?php

namespace Escorp\WbApiClient\Api\Common;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Common\PingResponseDto;

/**
 * Проверка подключения
 *
 * @author parhomey
 */
class PingApi extends AbstractWbApi
{
    /**
     * Проверка подключения
     * @return PingResponseDto
     */
    public function ping(): PingResponseDto
    {
        $url = $this->hosts->get('common') . '/ping';

        $response = $this->request('GET', $url);

        return PingResponseDto::fromArray($response);
    }
}
