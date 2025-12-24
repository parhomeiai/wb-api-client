## Installation

composer require escorp/wb-api-client

## Usage

```php
app(WbApiClient::class)->ping();

## None-Laravel Usage

```php
$wb = WbApiClientFactory::make(
    'WB_API_TOKEN',
    [
        'timeout' => 15,
        'retry_times' => 5,
        'retry_sleep_ms' => 500,
    ]
);

$prices = $wb->prices->getPricesBatch([111, 222, 333]);