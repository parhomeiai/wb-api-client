<?php

namespace Escorp\WbApiClient\Dto\Prices;

/**
 * Информация о загрузке
 */
final class UploadDto
{
    /**
     * ID загрузки
     * @var int|null
     */
    public ?int $uploadID;

    /**
     * Статус загрузки:
     * 3 — обработана, в товарах нет ошибок, цены и скидки обновились
     * 4 — отменена
     * 5 — обработана, но в товарах есть ошибки. Для товаров без ошибок цены и скидки обновились, а ошибки в остальных товарах можно получить с помощью метода Детализация обработанной загрузки
     * 6 — обработана, но во всех товарах есть ошибки
     * @var int|null
     */
    public ?int $status;

    /**
     * Дата и время, когда загрузка создана
     * @var string|null
     */
    public ?string  $uploadDate;

    /**
     * Дата и время, когда загрузка отправляется в обработку
     * @var string|null
     */
    public ?string  $activationDate;

    /**
     * Всего товаров
     * @var int|null
     */
    public ?int $overAllGoodsNumber;

    /**
     * Товаров без ошибок
     * @var int|null
     */
    public ?int $successGoodsNumber;

    public array $goodsHistory = [];

    /**
     *
     * @param int|null $uploadID
     * @param int|null $status
     * @param string|null $uploadDate
     * @param string|null $activationDate
     * @param int|null $overAllGoodsNumber
     * @param int|null $successGoodsNumber
     * @param GoodsHistoryDto[] $goodsHistory
     */
    function __construct(?int $uploadID, ?int $status, ?string $uploadDate, ?string $activationDate, ?int $overAllGoodsNumber, ?int $successGoodsNumber, array $goodsHistory = []) {
        $this->uploadID = $uploadID;
        $this->status = $status;
        $this->uploadDate = $uploadDate;
        $this->activationDate = $activationDate;
        $this->overAllGoodsNumber = $overAllGoodsNumber;
        $this->successGoodsNumber = $successGoodsNumber;
        $this->goodsHistory = $goodsHistory;
    }

            /**
     *
     * @param array $data
     * @return self
     * @throws DtoMappingException
     */
    public static function fromArray(array $data): self
    {
        $historyGoods = [];
        if(isset($data['historyGoods']) && is_array($data['historyGoods'])){
            foreach($data['historyGoods'] as $item){
                $historyGoods[] = GoodsHistoryDto::fromArray($item);
            }
        }
        if(isset($data['bufferGoods']) && is_array($data['bufferGoods'])){
            foreach($data['bufferGoods'] as $item){
                $historyGoods[] = GoodsHistoryDto::fromArray($item);
            }
        }

        return new self(
            isset($data['uploadID']) ? (int)$data['uploadID'] : null,
            isset($data['status']) ? (int)$data['status'] : null,
            isset($data['uploadDate']) ? (string)$data['uploadDate'] : null,
            isset($data['activationDate']) ? (string)$data['activationDate'] : null,
            isset($data['overAllGoodsNumber']) ? (int)$data['overAllGoodsNumber'] : null,
            isset($data['successGoodsNumber']) ? (int)$data['successGoodsNumber'] : null,
            $historyGoods
        );
    }
}

