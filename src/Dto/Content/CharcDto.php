<?php


namespace Escorp\WbApiClient\Dto\Content;

/**
 * Характеристика предмета
 *
 * @author parhomey
 */
class CharcDto
{
    /**
     * ID характеристики
     * @var int
     */
    public int $charcID;

    /**
     * Название предмета
     * @var string
     */
    public string $subjectName;

    /**
     * ID предмета
     * @var int
     */
    public int $subjectID;

    /**
     * Название характеристики
     * @var string
     */
    public string $name;

    /**
     * true - характеристику необходимо обязательно указать в карточке товара
     * false - характеристику необязательно указывать
     * @var bool
     */
    public bool $required;

    /**
     * Единица измерения
     * @var string
     */
    public string $unitName;

    /**
     * Максимальное количество значений, которое можно присвоить характеристике при создании или редактировании карточек товаров.
     * Используется только для характеристик с "charcType":1— массив строк.
     * Характеристикам с "charcType":4— число, можно присвоить только одно значение.
     * Если "maxCount":0, количество значений не ограничено
     * @var int
     */
    public int $maxCount;

    /**
     * Характеристика популярна у пользователей (true - да, false - нет)
     * @var bool
     */
    public bool $popular;

    /**
     * Тип данных характеристики, который необходимо использовать при создании или редактировании карточек товаров:
     * 1 — массив строк
     * 4 — число
     * 0 — характеристика не используется
     * @var int
     */
    public int $charcType;

    /**
     *
     * @param int $charcID
     * @param string $subjectName
     * @param int $subjectID
     * @param string $name
     * @param bool $required
     * @param string $unitName
     * @param int $maxCount
     * @param bool $popular
     * @param int $charcType
     */
    function __construct(int $charcID, string $subjectName, int $subjectID, string $name, bool $required, string $unitName, int $maxCount, bool $popular, int $charcType)
    {
        $this->charcID = $charcID;
        $this->subjectName = $subjectName;
        $this->subjectID = $subjectID;
        $this->name = $name;
        $this->required = $required;
        $this->unitName = $unitName;
        $this->maxCount = $maxCount;
        $this->popular = $popular;
        $this->charcType = $charcType;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['charcID'] ?? 0),
            (string)($data['subjectName'] ?? ''),
            (int)($data['subjectID'] ?? 0),
            (string)($data['name'] ?? ''),
            (bool)($data['required'] ?? 0),
            (string)($data['unitName'] ?? 0),
            (int)($data['maxCount'] ?? 0),
            (bool)($data['popular'] ?? 0),
            (int)($data['charcType'] ?? 0)
        );
    }
}
