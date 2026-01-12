<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Параметры фильтрации для запроса Список карточек товаров
 *
 * @author parhomey
 */
class CardsListFilter {

    /**
     * Фильтр по фото:
     * 0 — только карточки без фото
     * 1 — только карточки с фото
     * -1 — все карточки товара
     * @var int
     */
    public int $withPhoto = 0;

    /**
     * Поиск по артикулу продавца, артикулу WB, баркоду
     * @var string|null
     */
    public ?string $textSearch = null;

    /**
     * Поиск по ID ярлыков
     * @var array int[]|null
     */
    public ?array $tagIDs = null;

    /**
     * Фильтр по категории. true - только разрешённые, false - все.
     * @var bool
     */
    public bool $allowedCategoriesOnly = false;

    /**
     * Поиск по id предметов
     * @var array int[]|null
     */
    public ?array $objectIDs = null;

    /**
     * Поиск по брендам
     * @var array string[]|null
     */
    public ?array $brands = null;

    /**
     * Поиск по ID объединённой карточки товара
     * @var int|null
     */
    public ?int $imtID = null;

    /**
     *
     * @param int $withPhoto
     * @param string|null $textSearch
     * @param array|null $tagIDs
     * @param bool $allowedCategoriesOnly
     * @param array|null $objectIDs
     * @param array|null $brands
     * @param int|null $imtID
     */
    function __construct(int $withPhoto = -1, ?string $textSearch = null, ?array $tagIDs = null, bool $allowedCategoriesOnly = false, ?array $objectIDs = null, ?array $brands = null, ?int $imtID = null)
    {
        $this->withPhoto = $withPhoto;
        $this->textSearch = $textSearch;
        $this->tagIDs = $tagIDs;
        $this->allowedCategoriesOnly = $allowedCategoriesOnly;
        $this->objectIDs = $objectIDs;
        $this->brands = $brands;
        $this->imtID = $imtID;
    }

    /**
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'withPhoto' => $this->withPhoto,
            'textSearch' => $this->textSearch,
            'tagIDs' => $this->tagIDs,
            'allowedCategoriesOnly' => $this->allowedCategoriesOnly,
            'objectIDs' => $this->objectIDs,
            'brands' => $this->brands,
            'imtID' => $this->imtID,
        ], fn($v) => $v !== null);
    }
}
