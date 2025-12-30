<?php

namespace Escorp\WbApiClient\Api\Content;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Content\ParentCategoriesResponse;
use Escorp\WbApiClient\Dto\Content\SubjectsResponse;
use Escorp\WbApiClient\Dto\Content\SubjectCharcsResponse;
use Escorp\WbApiClient\Dto\Content\ColorsResponse;
use Escorp\WbApiClient\Dto\Content\KindsResponse;
use Escorp\WbApiClient\Dto\Content\CountriesResponse;
use Escorp\WbApiClient\Dto\Content\SeasonsResponse;
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
     * Метод возвращает названия и ID всех родительских категорий для создания карточек товаров: например, Электроника, Бытовая химия, Рукоделие.
     *
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
     * Метод возвращает список названий родительских категорий предметов и их предметов с ID. Например, у категории Игрушки будут предметы Калейдоскопы, Куклы, Мячики.
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

    /**
     * Метод возвращает параметры характеристик предмета: названия, типы данных, единицы измерения и так далее. В запросе необходимо указать ID предмета.
     *
     * @param int $subjectId ID предмета
     * @param string $locale Язык полей ответа: ru|en|zh
     * @return SubjectCharcsResponse
     */
    public function getSubjectCharcs(int $subjectId, string $locale = 'ru'): SubjectCharcsResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/content/v2/object/charcs/' . $subjectId,
            [
                'query' => ['locale' => $locale]
            ]
        );

        return SubjectCharcsResponse::fromArray($response);
    }

    /**
     * Метод возвращает возможные значения характеристики предмета Цвет
     * @param string $locale Язык полей ответа: ru|en|zh
     * @return ColorsResponse
     */
    public function getColors(string $locale = 'ru'): ColorsResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/content/v2/directory/colors',
            [
                'query' => ['locale' => $locale]
            ]
        );

        return ColorsResponse::fromArray($response);
    }

    /**
     * Метод возвращает возможные значения характеристики предмета Пол
     * @param string $locale Язык полей ответа: ru|en|zh
     * @return KindsResponse
     */
    public function getKinds(string $locale = 'ru'): KindsResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/content/v2/directory/kinds',
            [
                'query' => ['locale' => $locale]
            ]
        );

        return KindsResponse::fromArray($response);
    }

    /**
     * Метод возвращает возможные значения характеристики предмета Страна производства
     * @param string $locale Язык полей ответа: ru|en|zh
     * @return CountriesResponse
     */
    public function getCountries(string $locale = 'ru'): CountriesResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/content/v2/directory/countries',
            [
                'query' => ['locale' => $locale]
            ]
        );

        return CountriesResponse::fromArray($response);
    }

    /**
     * Метод возвращает возможные значения характеристики предмета Сезон.
     * @param string $locale Язык полей ответа: ru|en|zh
     * @return SeasonsResponse
     */
    public function getSeasons(string $locale = 'ru'): SeasonsResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/content/v2/directory/seasons',
            [
                'query' => ['locale' => $locale]
            ]
        );

        return SeasonsResponse::fromArray($response);
    }
}
