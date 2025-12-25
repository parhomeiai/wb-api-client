<?php

namespace Escorp\WbApiClient\Dto\Common;

use Escorp\WbApiClient\Dto\Common\NewsTypesDto;

/**
 * Description of NewsItemDto
 *
 * @author parhomey
 */
class NewsItemDto
{
    /**
     * Текст новости
     * @var string|null
     */
    public ?string $content;

    /**
     * Дата и время публикации новости
     * @var string|null
     */
    public ?string $date;

    /**
     * Заголовок новости
     * @var string|null
     */
    public ?string $header;

    /**
     * ID новости
     * @var int|null
     */
    public ?int $id;

    /**
     * Теги новости
     * @var array
     */
    public array $types;


    /**
     *
     * @param string|null $content
     * @param string|null $date
     * @param string|null $header
     * @param int|null $id
     * @param array $types
     */
    public function __construct(?string $content, ?string $date, ?string $header, ?int $id, array $types = [])
    {
        $this->content = $content;
        $this->date = $date;
        $this->header = $header;
        $this->id = $id;
        $this->types = $types;
    }

    /**
     *
     * @param array $data
     * @return self
     * @throws DtoMappingException
     */
    public static function fromArray(array $data): self
    {
        $types = [];
        foreach ($data['types'] ?? [] as $type) {
            $types[] = NewsTypesDto::fromArray($type);
        }

        return new self(
            isset($data['content']) ? (string)$data['content'] : null,
            isset($data['date']) ? (string)$data['date'] : null,
            isset($data['header']) ? (string)$data['header'] : null,
            isset($data['id']) ? (int)$data['id'] : null,
            $types
        );
    }
}
