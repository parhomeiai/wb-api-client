<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Габариты и вес товара c упаковкой, см и кг
 *
 * @author parhomey
 */
class ProductDimensionsDto
{
    /**
     * Длина, см
     * @var int
     */
    public int $length = 0;

    /**
     * Ширина, см
     * @var int
     */
    public int $width = 0;

    /**
     * Высота, см
     * @var int
     */
    public int $height = 0;

    /**
     * Вес, кг
     * Количество знаков после запятой <=3
     * @var float
     */
    public float $weightBrutto = 0;

    /**
     * Потенциальная некорректность габаритов товара:
     * true — не выявлена. "isValid":true не гарантирует, что размеры указаны корректно. В отдельных случаях (например, при создании новой категории товаров) "isValid":true будет возвращаться при любых значениях, кроме нулевых.
     * false — указанные габариты значительно отличаются от средних по категории (предмету). Рекомендуется перепроверить, правильно ли указаны размеры товара в упаковке в сантиметрах. Функциональность карточки товара, в том числе начисление логистики и хранения, при этом ограничена не будет. Логистика и хранение продолжают начисляться — по текущим габаритам. Также "isValid":false возвращается при отсутствии значений или нулевом значении любой стороны.
     * @var bool
     */
    public bool $isValid = true;


    /**
     *
     * @param int $length
     * @param int $width
     * @param int $height
     * @param float $weightBrutto
     * @param bool $isValid
     */
    function __construct(int $length = 0, int $width = 0, int $height = 0, float $weightBrutto = 0, bool $isValid = true)
    {
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->weightBrutto = $weightBrutto;
        $this->isValid = $isValid;
    }


    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['length'] ?? 0),
            (int)($data['width'] ?? 0),
            (int)($data['height'] ?? 0),
            (float)($data['weightBrutto'] ?? 0),
            (bool)($data['isValid'] ?? true),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'weightBrutto' => $this->weightBrutto,
        ], fn($v) => $v !== null);
    }
}
