<?php


namespace Escorp\WbApiClient\Dto\Content;

/**
 * Предмет
 *
 * @author parhomey
 */
class SubjectDto
{
    /**
     * ID предмета
     * @var int
     */
    public int $subjectID;

    /**
     * Название предмета
     * @var string
     */
    public string $subjectName;

    /**
     * ID родительской категории
     * @var int
     */
    public int $parentId;

    /**
     * Название родительской категории
     * @var string
     */
    public string $parentName;

    /**
     *
     * @param int $subjectID
     * @param string $subjectName
     * @param int $parentId
     * @param string $parentName
     */
    function __construct(int $subjectID, string $subjectName, int $parentId, string $parentName)
    {
        if ($subjectID <= 0) {
            throw new InvalidArgumentException('Subject ID must be positive');
        }

        $this->subjectID = $subjectID;
        $this->subjectName = $subjectName;
        $this->parentId = $parentId;
        $this->parentName = $parentName;
    }

    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int) ($data['subjectID'] ?? 0),
            (string) ($data['subjectName'] ?? ''),
            (int) ($data['parentID'] ?? 0),
            (string) ($data['parentName'] ?? '')
        );
    }
}
