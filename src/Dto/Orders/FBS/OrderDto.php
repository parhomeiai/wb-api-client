<?php

namespace Escorp\WbApiClient\Dto\Orders\FBS;

/**
 * Заказ FBS
 *
 */
class OrderDto
{
    public array $data;

    /**
     * ID сборочного задания
     * @var int
     */
    public int $id;

    /**
     * Артикул WB
     * @var int
     */
    public int $nmId;

    /**
     * ID размера товара в системе WB
     * @var int
     */
    public int $chrtId;

    /**
     * ID транзакции для группировки сборочных заданий. Сборочные задания в одной корзине покупателя будут иметь одинаковый orderUid
     * @var string
     */
    public string $orderUid;

    /**
     * Уникальный ID заказа
     * @var string
     */
    public string $rid;

    /**
     * ID склада продавца, на который поступило сборочное задание
     * @var int
     */
    public int $warehouseId;

    /**
     * ID склада WB, к которому привязан склад продавца
     * @var int
     */
    public int $officeId;

    /**
     * Цена в валюте продажи с учётом всех скидок, кроме скидки по WB Кошельку, умноженная на 100
     * @var int
     */
    public int $price;

    /**
     * Сумма к оплате покупателем в валюте продажи с учетом всех скидок, умноженная на 100
     * @var int
     */
    public int $finalPrice;

    /**
     * Цена в валюте страны продавца с учетом всех скидок, кроме скидки по WB Кошельку, умноженная на 100
     * @var int
     */
    public int $convertedPrice;

    /**
     * Сумма к оплате покупателем в валюте страны продавца с учетом всех скидок, умноженная на 100
     * @var int
     */
    public int $convertedFinalPrice;

    /**
     * Код валюты продажи
     * @var int
     */
    public int $currencyCode;

    /**
     * Код валюты страны продавца
     * @var int
     */
    public int $convertedCurrencyCode;

    /**
     * Артикул продавца
     * @var string
     */
    public string $article;

    /**
     * Дата создания сборочного задания (RFC3339)
     * @var string
     */
    public string $createdAt;

    /**
     * Код цвета (только для колеруемых товаров)
     * @var string
     */
    public string $colorCode;

    /**
     * Точный адрес покупателя для доставки, если применимо
     * @var OrderAddressDto|null
     */
    public ?OrderAddressDto $address;

    /**
     * Планируемая дата доставки
     * @var string
     */
    public string $ddate;

    /**
     * Тип товара:
     * 1 — малогабаритный товар (МГТ)
     * 2 — сверхгабаритный товар (СГТ)
     * 3 — крупногабаритный товар (КГТ+)
     * @var int
     */
    public int $cargoType;

    /**
     * Тип сборочного задания:
     * 0 — не кроссбордер
     * 1 — кроссбордер
     * @var int
     */
    public int $crossBorderType;

    /**
     * Признак заказа товара с нулевым остатком:
     * false — заказ сделан на товар с ненулевым остатком
     * true — заказ сделан на товар с нулевым остатком. Такой заказ можно отменить без штрафа за отмену
     * @var bool
     */
    public bool $isZeroOrder;

    /**
     * Рекомендуемая дата доставки СГТ в сортировочный центр или на склад
     * @var string|null
     */
    public ?string $sellerDate;

    /**
     * Цена продавца в валюте продажи с учётом скидки продавца, без учёта скидки WB Клуба, умноженная на 100.
     * @var int|null
     */
    public ?int $salePrice;

    /**
     * Тип доставки. fbs — доставка на склад Wildberries (FBS)
     * @var string
     */
    public string $deliveryType;

    /**
     * Комментарий покупателя
     * @var string
     */
    public string $comment;

    /**
     * Цена приёмки в копейках
     * @var int|null
     */
    public ?int $scanPrice;

    /**
     * Опции заказа
     * @var OrderOptionsDto
     */
    public OrderOptionsDto $options;

    /**
     * Список метаданных, которые необходимо добавить в сборочное задание, чтобы поставку с этим сборочным заданием можно было перевести в доставку
     * @var array
     */
    public array $requiredMeta = [];

    /**
     * Список метаданных, которые можно добавить в сборочное задание.
     * @var array
     */
    public array $optionalMeta = [];

    /**
     * Список офисов, куда следует привезти товар
     * @var array
     */
    public array $offices = [];

    /**
     * Список баркодов
     * @var array
     */
    public array $skus = [];

    /**
     *
     * @param int $id
     * @param int $nmId
     * @param int $chrtId
     * @param string $orderUid
     * @param string $rid
     * @param int $warehouseId
     * @param int $officeId
     * @param int $price
     * @param int $finalPrice
     * @param int $convertedPrice
     * @param int $convertedFinalPrice
     * @param int $currencyCode
     * @param int $convertedCurrencyCode
     * @param string $article
     * @param string $createdAt
     * @param string $colorCode
     * @param OrderAddressDto|null $address
     * @param string $ddate
     * @param int $cargoType
     * @param int $crossBorderType
     * @param bool $isZeroOrder
     * @param string|null $sellerDate
     * @param int|null $salePrice
     * @param string $deliveryType
     * @param string $comment
     * @param int|null $scanPrice
     * @param OrderOptionsDto $options
     * @param array $requiredMeta
     * @param array $optionalMeta
     * @param array $offices
     * @param array $skus
     * @param array $data
     */
    function __construct(int $id, int $nmId, int $chrtId, string $orderUid, string $rid, int $warehouseId, int $officeId, int $price, int $finalPrice, int $convertedPrice, int $convertedFinalPrice, int $currencyCode, int $convertedCurrencyCode, string $article, string $createdAt, string $colorCode, ?OrderAddressDto $address, string $ddate, int $cargoType, int $crossBorderType, bool $isZeroOrder, ?string $sellerDate, ?int $salePrice, string $deliveryType, string $comment, ?int $scanPrice, OrderOptionsDto $options, array $requiredMeta, array $optionalMeta, array $offices, array $skus, array $data) {
        $this->data = $data;
        $this->id = $id;
        $this->nmId = $nmId;
        $this->chrtId = $chrtId;
        $this->orderUid = $orderUid;
        $this->rid = $rid;
        $this->warehouseId = $warehouseId;
        $this->officeId = $officeId;
        $this->price = $price;
        $this->finalPrice = $finalPrice;
        $this->convertedPrice = $convertedPrice;
        $this->convertedFinalPrice = $convertedFinalPrice;
        $this->currencyCode = $currencyCode;
        $this->convertedCurrencyCode = $convertedCurrencyCode;
        $this->article = $article;
        $this->createdAt = $createdAt;
        $this->colorCode = $colorCode;
        $this->address = $address;
        $this->ddate = $ddate;
        $this->cargoType = $cargoType;
        $this->crossBorderType = $crossBorderType;
        $this->isZeroOrder = $isZeroOrder;
        $this->sellerDate = $sellerDate;
        $this->salePrice = $salePrice;
        $this->deliveryType = $deliveryType;
        $this->comment = $comment;
        $this->scanPrice = $scanPrice;
        $this->options = $options;
        $this->requiredMeta = $requiredMeta;
        $this->optionalMeta = $optionalMeta;
        $this->offices = $offices;
        $this->skus = $skus;
    }



    /**
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['id'] ?? 0),
            (int)($data['nmId'] ?? 0),
            (int)($data['chrtId'] ?? 0),
            (string)($data['orderUid'] ?? ''),
            (string)($data['rid'] ?? ''),
            (int)($data['warehouseId'] ?? ''),
            (int)($data['officeId'] ?? 0),
            (int)($data['price'] ?? 0),
            (int)($data['finalPrice'] ?? 0),
            (int)($data['convertedPrice'] ?? 0),
            (int)($data['convertedFinalPrice'] ?? 0),
            (int)($data['currencyCode'] ?? 0),
            (int)($data['convertedCurrencyCode'] ?? 0),
            (string)($data['article'] ?? ''),
            (string)($data['createdAt'] ?? ''),
            (string)($data['colorCode'] ?? ''),
            (isset($data['address']) ? (OrderAddressDto::fromArray($data['address'])) : (null)),
            (string)($data['ddate'] ?? ''),
            (int)($data['cargoType'] ?? 0),
            (int)($data['crossBorderType'] ?? 0),
            (bool)($data['isZeroOrder'] ?? false),
            ($data['sellerDate'] ?? null),
            ($data['salePrice'] ?? null),
            (string)($data['deliveryType'] ?? ''),
            (string)($data['comment'] ?? ''),
            ($data['scanPrice'] ?? 0),
            (isset($data['options']) ? (OrderOptionsDto::fromArray($data['options'])) : (null)),
            ($data['requiredMeta'] ?? []),
            ($data['optionalMeta'] ?? []),
            ($data['offices'] ?? []),
            ($data['skus'] ?? []),
            $data
        );
    }
}
