<?php

namespace Escorp\WbApiClient\Api\Content;

use Escorp\WbApiClient\Api\AbstractWbApi;
use Escorp\WbApiClient\Dto\WbApiResponseDto;

/**
 * Медиафайлы
 *
 * @author parhomey
 */
class MediaFilesApi extends AbstractWbApi
{
    /**
     * Возвращает домен
     *
     * @return string
     */
    private function getBaseUri(): string
    {
        return $this->hosts->get('content');
    }

    /**
     * Загрузить медиафайл
     *
     * @param string $XNmId - Артикул WB
     * @param int $XPhotoNumber - Номер медиафайла на загрузку, начинается с 1. При загрузке видео всегда указывайте 1. Чтобы добавить изображение к уже загруженным, номер медиафайла должен быть больше количества уже загруженных медиафайлов.
     * @param string $file - содержимое файла
     * @return WbApiResponseDto
     */
    public function mediaFile(string $XNmId, int $XPhotoNumber, string $file): WbApiResponseDto
    {
        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/content/v3/media/file',
            [
                'headers' => [
                    'X-Nm-Id' => $XNmId,
                    'X-Photo-Number' => $XPhotoNumber,
                ],
                'multipart' => [
                    [
                        'name' => 'uploadfile',
                        'contents' => $file,
                    ]
                ]
            ]
        );

        return WbApiResponseDto::fromArray($response);
    }

    /**
     * Загрузить медиафайлы по ссылкам
     *
     * @param int $nmId - Артикул WB
     * @param array string[] $data - Ссылки на изображения в том порядке, в котором они будут в карточке товара, и на видео, на любой позиции массива
     * @return WbApiResponseDto
     */
    public function mediaSave(int $nmId, array $data): WbApiResponseDto
    {
        $response = $this->request(
            'POST',
            $this->getBaseUri(). '/content/v3/media/save',
            [
                'json' => [
                    'nmId' => $nmId,
                    'data' => $data
                ],
            ]
        );

        return WbApiResponseDto::fromArray($response);
    }
}
