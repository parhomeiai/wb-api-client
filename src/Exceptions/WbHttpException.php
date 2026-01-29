<?php


namespace Escorp\WbApiClient\Exceptions;

use Escorp\WbApiClient\Dto\WbErrorDto;

/**
 * Расширенный Exception для ошибок Http
 *
 */
class WbHttpException extends WbApiClientException
{
    private $httpStatus;

    /**
     * DTO ошибки WB
     * @var WbErrorDto
     */
    private WbErrorDto $error;

    /**
     *
     * @param WbErrorDto $error
     */
    public function __construct(WbErrorDto $error, $httpStatus = null)
    {
        parent::__construct($error->title . ': ' . $error->detail, $error->status);
        $this->error = $error;
        $this->httpStatus = $httpStatus;
    }

    /**
     * Возвращает DTO ошибки WB
     * @return WbErrorDto
     */
    public function getError(): WbErrorDto
    {
        return $this->error;
    }

    public function getStatus()
    {
        return $this->getStatus();
    }
}
