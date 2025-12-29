<?php


namespace Escorp\WbApiClient\Exceptions;

use Escorp\WbApiClient\Dto\WbErrorDto;

/**
 * Расширенный Exception для ошибок Http
 *
 */
class WbHttpException extends WbApiClientException
{
    /**
     * DTO ошибки WB
     * @var WbErrorDto
     */
    private WbErrorDto $error;

    /**
     *
     * @param WbErrorDto $error
     */
    public function __construct(WbErrorDto $error)
    {
        parent::__construct($error->title . ': ' . $error->detail, $error->status);
        $this->error = $error;
    }

    /**
     * Возвращает DTO ошибки WB
     * @return WbErrorDto
     */
    public function getError(): WbErrorDto
    {
        return $this->error;
    }
}
