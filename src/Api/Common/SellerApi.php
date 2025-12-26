<?php

namespace Escorp\WbApiClient\Api\Common;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Common\SellerInfoResponseDto;

/**
 * Информация о продавце
 *
 * @author parhomey
 */
class SellerApi extends AbstractWbApi
{

    /**
     * Метод позволяет получать наименование продавца и ID его профиля.
     * @return SellerInfoResponseDto
     */
    public function getSellerInfo(): SellerInfoResponseDto
    {
        $url = $this->hosts->get('common') . '/api/v1/seller-info';

        $response = $this->request('GET', $url);

        return SellerInfoResponseDto::fromArray($response);
    }
}
