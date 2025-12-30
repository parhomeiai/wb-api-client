<?php

namespace Escorp\WbApiClient\Api\Content;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Content\ParentCategoriesResponse;

/**
 * Работа с товарами
 *
 * @author parhomey
 */
class ContentApi extends AbstractWbApi
{
    /**
     * Возвращает домен
     *
     * @return string
     */
    private function getBaseUri(): string
    {
        return $this->hosts->get('content');
    }

    /**
     * Получить все родительские категории товаров
     * @param string $locale Язык поля ответа name: ru|en|zh
     * @return ParentCategoriesResponse
     */
    public function getParentCategories(string $locale = 'ru'): ParentCategoriesResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/content/v2/object/parent/all',
            [
                'query' => ['locale' => $locale]
            ]
        );

        return ParentCategoriesResponse::fromArray($response);
    }
}
