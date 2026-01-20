<?php

namespace Escorp\WbApiClient\Api\Content;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\WbApiResponseDto;
use Escorp\WbApiClient\Dto\Content\TagsResponse;

/**
 * Ярлыки
 *
 * @author parhomey
 */
class TagsApi extends AbstractWbApi
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
     * Метод возвращает список и характеристики всех ярлыков продавца для группировки и фильтрации товаров.
     * @return TagsResponse
     */
    public function tags(): TagsResponse
    {
        $response = $this->request(
            'GET',
            $this->getBaseUri(). '/content/v2/tags'
        );

        return TagsResponse::fromArray($response);
    }

    /**
     * Создание ярлыка
     * @param string $name
     * @param string $color - Цвет ярлыка. Доступные цвета: D1CFD7 — серый, FEE0E0 — красный, ECDAFF — фиолетовый, E4EAFF — синий, DEF1DD — зеленый, FFECC7 — желтый
     * @return WbApiResponseDto
     */
    public function tagCreate(string $name, string $color): WbApiResponseDto
    {
        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/content/v2/tag',
            [
                'json' => [
                    'name' => $name,
                    'color' => $color
                ]
            ]
        );

        return WbApiResponseDto::fromArray($response);
    }

    /**
     * Изменение ярляка
     * @param int $id - Числовой ID ярлыка
     * @param string $name - Имя ярлыка
     * @param string $color  - Цвет ярлыка. Доступные цвета: D1CFD7 — серый, FEE0E0 — красный, ECDAFF — фиолетовый, E4EAFF — синий, DEF1DD — зеленый, FFECC7 — желтый
     * @return WbApiResponseDto
     */
    public function tagUpdate(int $id, string $name, string $color): WbApiResponseDto
    {
        $response = $this->request(
            'PATCH',
            $this->getBaseUri(). '/content/v2/tag/' . $id,
            [
                'json' => [
                    'name' => $name,
                    'color' => $color
                ]
            ]
        );

        return WbApiResponseDto::fromArray($response);
    }

    /**
     * Удаление ярлыка
     * @param int $id - Числовой ID ярлыка
     * @return WbApiResponseDto
     */
    public function tagDelete(int $id): WbApiResponseDto
    {
        $response = $this->request(
            'DELETE',
            $this->getBaseUri(). '/content/v2/tag/' . $id
        );

        return WbApiResponseDto::fromArray($response);
    }

    /**
     * Управление ярлыками в карточке товара
     * Что бы снять ярлыки с карточки товара, необходимо передать пустой массив $tagsIDs. Чтобы добавить ярлыки к уже имеющимся в карточке товара, необходимо в запросе передать новые ярлыки и ярлыки, которые уже есть в карточке товара.
     * @param int $nmID - Артикул WB
     * @param array int[] $tagsIDs - Массив числовых ID ярлыков.
     * @return WbApiResponseDto
     */
    public function tagNomenclatureLink(int $nmID, array $tagsIDs): WbApiResponseDto
    {
        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/content/v2/tag/nomenclature/link',
            [
                'json' => [
                    'nmID' => $nmID,
                    'tagsIDs' => $tagsIDs
                ]
            ]
        );

        return WbApiResponseDto::fromArray($response);
    }
}
