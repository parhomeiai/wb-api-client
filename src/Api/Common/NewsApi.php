<?php

namespace Escorp\WbApiClient\Api\Common;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\Common\NewsResponseDto;
use InvalidArgumentException;

/**
 * Новости портала продавцов
 *
 * @author parhomey
 */
class NewsApi extends AbstractWbApi
{
    /**
     * Получение новостей портала продавцов
     * Example: from=2025-02-06
     * Example: fromID=7369
     *
     * @param string|null $from
     * @param int|null $fromId
     * @return NewsResponseDto
     * @throws InvalidArgumentException
     */
    public function getNews(?string $from = null, ?int $fromId = null): NewsResponseDto
    {
        if (!$from && !$fromId) {
            throw new InvalidArgumentException('Either $from or $fromId must be provided');
        }

        $query = [];
        if ($from)   { $query['from']   = $from; }
        if ($fromId) { $query['fromID'] = $fromId; }

        $url = $this->hosts->get('common') . '/api/communications/v2/news';

        $response = $this->request('GET', $url, [
            'query'   => $query,
        ]);

        return NewsResponseDto::fromArray($response);
    }
}
