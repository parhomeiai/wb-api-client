<?php

namespace Escorp\WbApiClient\Dto\Users;

/**
 * Настройки доступа к разделам профиля продавца
 *
 * @author parhomey
 */
final class AccessDto
{
    /**
     * Код раздела профиля продавца, к которому пользователь получит доступ
     * @var string
     */
    public string $code;

    /**
     * true — доступ к разделу запрещён
     * false — доступ к разделу разрешён
     * @var bool
     */
    public bool $disabled;

    private const ALLOWED_CODES = [
        'balance','brands','changeJam','discountPrice','finance','showcase',
        'suppliersDocuments','supply','feedbacksQuestions','questions',
        'pinFeedbacks','pointsForReviews','feedbacks','wbPoint'
    ];

    /**
     *
     * @param string $code
     * @param bool $disabled
     * @throws \InvalidArgumentException
     */
    public function __construct(string $code, bool $disabled)
    {
        if (!in_array($code, self::ALLOWED_CODES, true)) {
            throw new \InvalidArgumentException("Invalid access code: $code");
        }

        $this->code = $code;
        $this->disabled = $disabled;
    }

    /**
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'disabled' => $this->disabled
        ];
    }
}
