<?php

namespace Escorp\WbApiClient\Api\Content;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Content\ParentCategoriesResponse;
use Escorp\WbApiClient\Dto\Content\SubjectsResponse;
use Escorp\WbApiClient\Exceptions\WbApiClientException;

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

    /**
     * Получить предметы
     *
     * @param array{
     *   locale?: string Язык полей ответа: ru|en|zh,
     *   name?: string Поиск по названию предмета (Носки), поиск работает по подстроке, искать можно на любом из поддерживаемых языков,
     *   limit?: int Количество предметов, максимум 1000,
     *   offset?: int колько элементов пропустить. Например, для значения 10 ответ начнется с 11 элемента,
     *   parentID?: int ID родительской категории предмета
     * } $filters
     * @return SubjectsResponse
     */
    public function getSubjects(array $filters = []): SubjectsResponse
    {
        $query = array_filter([
            'locale'   => $filters['locale'] ?? null,
            'name'     => $filters['name'] ?? null,
            'limit'    => isset($filters['limit']) ? min((int)$filters['limit'], 1000) : null,
            'offset'   => $filters['offset'] ?? null,
            'parentID' => $filters['parentID'] ?? null,
        ], static fn($v) => $v !== null);

        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/content/v2/object/all',
            [
                'query' => $query,
            ]
        );

        return SubjectsResponse::fromArray($response);
    }

    /**
     * Получить ВСЕ предметы с фильтрами
     *
     * @param array{
     *   locale?: string Язык полей ответа: ru|en|zh,
     *   name?: string Поиск по названию предмета (Носки), поиск работает по подстроке, искать можно на любом из поддерживаемых языков,
     *   parentID?: int ID родительской категории предмета
     * } $filters
     * @return array
     * @throws WbApiClientException
     */
    public function getAllSubjects(array $filters = []): array
    {
        $offset = 0;
        $limit = 1000;
        $result = [];

        do {
            $response = $this->getSubjects(array_merge($filters, [
                'limit' => $limit,
                'offset' => $offset,
            ]));

            if ($response->error) {
                throw new WbApiClientException(
                    'WB error while loading subjects (limit: ' . $limit . ', offset: ' . $offset . '): ' . $response->errorText . '. ' . $response->additionalErrors
                );
            }

            $count = count($response->subjects);
            $result = array_merge($result, $response->subjects);
            $offset += $limit;

            if ($count === $limit) {
                usleep(600_000);
            }

        } while ($count === $limit);

        return $result;
    }
}
