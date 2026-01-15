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
use Escorp\WbApiClient\Dto\Content\VatResponse;
use Escorp\WbApiClient\Dto\Content\TnvedResponse;
use Escorp\WbApiClient\Dto\Content\BrandsResponse;
use Escorp\WbApiClient\Dto\Content\CardsLimitsResponse;
use Escorp\WbApiClient\Dto\Content\BarcodesResponse;
use Escorp\WbApiClient\Dto\Requests\CardsListRequest;
use Escorp\WbApiClient\Dto\Content\CardsListFilter;
use Escorp\WbApiClient\Dto\Content\CardsCursor;
use Escorp\WbApiClient\Dto\Content\CardsListResponse;
use Escorp\WbApiClient\Dto\Content\CardsErrorListResponse;
use Escorp\WbApiClient\Dto\Requests\CardsErrorListRequest;
use Escorp\WbApiClient\Dto\Content\CardsErrorCursor;
use Escorp\WbApiClient\Dto\WbApiResponseDto;
use Escorp\WbApiClient\Exceptions\WbApiClientException;
use InvalidArgumentException;

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

    /**
     * Метод возвращает возможные значения характеристики предмета Ставка НДС.
     * @param string $locale Язык полей ответа: ru|en|zh
     * @return VatResponse
     */
    public function getVat(string $locale = 'ru'): VatResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/content/v2/directory/vat',
            [
                'query' => ['locale' => $locale]
            ]
        );

        return VatResponse::fromArray($response);
    }

    /**
     * Метод возвращает список ТНВЭД-кодов по ID предмета и фрагменту ТНВЭД-кода.
     * @param int $subjectID ID предмета
     * @param int|null $search Поиск по ТНВЭД-коду. Работает только в паре с subjectID
     * @param string $locale Язык полей ответа: ru|en|zh
     * @return TnvedResponse
     */
    public function getTnved(int $subjectID, ?int $search = null, string $locale = 'ru'): TnvedResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/content/v2/directory/tnved',
            [
                'query' => [
                    'subjectID' => $subjectID,
                    'search' => $search,
                    'locale' => $locale
                ]
            ]
        );

        return TnvedResponse::fromArray($response);
    }

    /**
     * Метод возвращает список брендов по ID предмета.
     * @param int $subjectID ID предмета
     * @param int|null $next Параметр пагинации. Используйте значение next из ответа, чтобы получить следующий пакет данных
     * @return BrandsResponse
     */
    public function getBrands(int $subjectID, ?int $next = null): BrandsResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/api/content/v1/brands',
            [
                'query' => [
                    'subjectId' => $subjectID,
                    'next' => $next
                ]
            ]
        );

        return BrandsResponse::fromArray($response);
    }


    /**
     * Метод возвращает список всех брендов по ID предмета.
     * @param int $subjectID
     * @return array
     * @throws WbApiClientException
     */
    public function getAllBrands(int $subjectID): array
    {
        $next = 0;
        $result = [];

        do {
            $response = $this->getBrands($subjectID, $next);

            if ($response->error) {
                throw new WbApiClientException(
                    'WB error while loading Brands (next: ' . $response->errorText . '. ' . $response->additionalErrors
                );
            }

            $result = array_merge($result, $response->brands());

            if ($response->next) {
                sleep(1);
            }

            $next = $response->next;

        } while ($response->next);

        return $result;
    }

    /**
     * Возвращает бесплатные и платные лимиты продавца на создание карточек товаров
     * @return CardsLimitsResponse
     */
    public function getCardsLimits(): CardsLimitsResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri() . '/content/v2/cards/limits'
        );

        $dto = CardsLimitsResponse::fromArray($response);

        if ($dto->error) {
            throw new WbApiClientException(
                'WB error while get cards limits: ' . $dto->errorText . '. ' . $dto->additionalErrors
            );
        }

        return $dto;
    }

    /**
     * Метод генерирует массив уникальных баркодов для создания размера в карточке товара. Можно использовать, если у вас нет собственных баркодов.
     * @param int $count Кол-во баркодов которые надо сгенерировать, максимальное доступное количество баркодов для генерации - 5 000
     * @return BarcodesResponse
     * @throws InvalidArgumentException
     * @throws WbApiClientException
     */
    public function generateBarcodes(int $count): BarcodesResponse
    {
        if ($count < 1 || $count > 5000) {
            throw new InvalidArgumentException('Count must be between 1 and 5000');
        }

        $response = $this->request(
            'POST',
            $this->getBaseUri() . '/content/v2/barcodes',
            [
                'json' => ['count' => $count]
            ]
        );

        $dto = BarcodesResponse::fromArray($response);

        if ($dto->error) {
            throw new WbApiClientException(
                'WB error while generating barcodes: ' . $dto->errorText . '. ' . $dto->additionalErrors
            );
        }

        return $dto;
    }

    /**
     * Метод возвращает список созданных карточек товаров.
     * @param CardsListRequest $cardsListRequest
     * @param string $locale
     * @return CardsListResponse
     */
    public function getCardsList(CardsListRequest $cardsListRequest, string $locale = 'ru'): CardsListResponse
    {
        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/content/v2/get/cards/list',
            [
                'json' => $cardsListRequest->toArray(),
                'query' => [
                    'locale' => $locale
                ]
            ]
        );

        return CardsListResponse::fromArray($response);
    }

    /**
     * Метод возвращает список всех созданных карточек товаров.
     * @param CardsListFilter|null $cardsListFilter
     * @return array|ProductCardDto[]
     */
    public function getAllCards(?CardsListFilter $cardsListFilter = null, string $locale = 'ru'): array
    {
        $cardsCursor = new CardsCursor(100);
        $cardsListFilter ??= new CardsListFilter();

        $result = [];

        do{
            $cardsListRequest = new CardsListRequest($cardsCursor, $cardsListFilter);
            $cardsListResponse = $this->getCardsList($cardsListRequest, $locale);

            foreach ($cardsListResponse->cards as $card) {
                $result[] = $card;
            }

            if ($cardsListResponse->cursor->total < $cardsCursor->limit) {
                break;
            }

            $cardsCursor->updatedAt = $cardsListResponse->cursor->updatedAt;
            $cardsCursor->nmID = $cardsListResponse->cursor->nmID;

            usleep(600_000);
        }while(true);

        return $result;
    }

    /**
     * Возвращает Список несозданных карточек товаров с ошибками
     * @param CardsErrorListRequest $cardsErrorListRequest
     * @param string $locale
     * @return CardsErrorListResponse
     */
    public function getCardsErrorList(CardsErrorListRequest $cardsErrorListRequest, string $locale = 'ru'): CardsErrorListResponse
    {
        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/content/v2/cards/error/list',
            [
                'json' => $cardsErrorListRequest->toArray(),
                'query' => [
                    'locale' => $locale
                ]
            ]
        );

        return CardsErrorListResponse::fromArray($response);
    }

    /**
     * Возвращает весь Список несозданных карточек товаров с ошибками
     * @param string $locale
     * @return array|ErrorItemDto[]
     */
    public function getAllCardsError(string $locale = 'ru'): array
    {
        $cardsCursor = new CardsErrorCursor(100);

        $result = [];

        do{
            $cardsErrorListRequest = new CardsErrorListRequest($cardsCursor);
            $cardsErrorListResponse = $this->getCardsErrorList($cardsErrorListRequest, $locale);

            foreach ($cardsErrorListResponse->items as $item) {
                $result[] = $item;
            }

            if (!$cardsErrorListResponse->cursor->next) {
                break;
            }

            $cardsCursor->updatedAt = $cardsErrorListResponse->cursor->updatedAt;
            $cardsCursor->batchUUID = $cardsErrorListResponse->cursor->batchUUID;

            sleep(1);
        }while(true);

        return $result;
    }

    /**
     * возвращает Список карточек товаров в корзине
     * @param CardsListRequest $cardsListRequest
     * @param string $locale
     * @return CardsListResponse
     */
    public function getCardsTrash(CardsListRequest $cardsListRequest, string $locale = 'ru'): CardsListResponse
    {
        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/content/v2/get/cards/trash',
            [
                'json' => $cardsListRequest->toArray(),
                'query' => [
                    'locale' => $locale
                ]
            ]
        );

        return CardsListResponse::fromArray($response);

    }

    /**
     * Возвращает весь Список карточек товаров в корзине
     * @param CardsListFilter|null $cardsListFilter
     * @param string $locale
     * @return array|ProductCardDto[]
     */
    public function getAllCardsTrash(?CardsListFilter $cardsListFilter = null, string $locale = 'ru'): array
    {
        $cardsCursor = new CardsCursor(100);
        $cardsListFilter ??= new CardsListFilter();

        $result = [];

        do{
            $cardsListRequest = new CardsListRequest($cardsCursor, $cardsListFilter);
            $cardsListResponse = $this->getCardsTrash($cardsListRequest, $locale);

            foreach ($cardsListResponse->cards as $card) {
                $result[] = $card;
            }

            if ($cardsListResponse->cursor->total < $cardsCursor->limit) {
                break;
            }

            $cardsCursor->trashedAt = $cardsListResponse->cursor->trashedAt;
            $cardsCursor->nmID = $cardsListResponse->cursor->nmID;

            usleep(600_000);
        }while(true);

        return $result;
    }

    /**
     * Перенос карточек товаров в корзину
     * @param array $nmIDs
     * @return WbApiResponseDto
     * @throws InvalidArgumentException
     */
    public function cardsDeleteTrash(array $nmIDs): WbApiResponseDto
    {
        if (count($nmIDs) > 1000) {
            throw new InvalidArgumentException('nmIDs must be an array of no more than 1000 elements');
        }

        foreach ($nmIDs as &$value) {
            $value = (int) $value;
        }
        unset($value);

        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/content/v2/cards/delete/trash',
            [
                'json' => ['nmIDs' => $nmIDs],
            ]
        );

        return WbApiResponseDto::fromArray($response);
    }

    /**
     * Восстановление карточек товаров из корзины
     * @param array $nmIDs
     * @return WbApiResponseDto
     * @throws InvalidArgumentException
     */
    public function cardsRecover(array $nmIDs): WbApiResponseDto
    {
        if (count($nmIDs) > 1000) {
            throw new InvalidArgumentException('nmIDs must be an array of no more than 1000 elements');
        }

        foreach ($nmIDs as &$value) {
            $value = (int) $value;
        }
        unset($value);

        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/content/v2/cards/recover',
            [
                'json' => ['nmIDs' => $nmIDs],
            ]
        );

        return WbApiResponseDto::fromArray($response);
    }
}
