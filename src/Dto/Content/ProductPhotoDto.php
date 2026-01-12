<?php

namespace Escorp\WbApiClient\Dto\Content;

/**
 * Фото товара
 *
 * @author parhomey
 */
class ProductPhotoDto
{

    /**
     * URL фото 900x1200
     * @var string|null
     */
    public ?string $big;

    /**
     * URL фото 248x328
     * @var string|null
     */
    public ?string $c246x328;

    /**
     * URL фото 516x688
     * @var string|null
     */
    public ?string $c516x688;

    /**
     * URL фото 600x600
     * @var string|null
     */
    public ?string $square;

    /**
     * URL фото 75x100
     * @var string|null
     */
    public ?string $tm;

    /**
     *
     * @param string|null $big
     * @param string|null $c246x328
     * @param string|null $c516x688
     * @param string|null $square
     * @param string|null $tm
     */
    function __construct(?string $big, ?string $c246x328, ?string $c516x688, ?string $square, ?string $tm)
    {
        $this->big = $big;
        $this->c246x328 = $c246x328;
        $this->c516x688 = $c516x688;
        $this->square = $square;
        $this->tm = $tm;
    }


    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            ($data['big'] ?? null),
            ($data['c246x328'] ?? null),
            ($data['c516x688'] ?? null),
            ($data['square'] ?? null),
            ($data['tm'] ?? null),
        );
    }

}
