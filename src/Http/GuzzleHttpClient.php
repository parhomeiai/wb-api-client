<?php

namespace Escorp\WbApiClient\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Escorp\WbApiClient\Exceptions\WbApiClientException;

final class GuzzleHttpClient implements HttpClientInterface
{
    private HttpClientInterface $client;
    private int $retryTimes;
    private int $retrySleepMs;

    public function __construct(HttpClientInterface $client, int $retryTimes, int $retrySleepMs)
    {
        $this->client = $client;
        $this->retryTimes = $retryTimes;
        $this->retrySleepMs = $retrySleepMs;
    }

    public function request(string $method, string $url, array $options = []): array
    {
        $response = $this->requestRaw($method, $url, $options);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function requestRaw(string $method, string $url, array $options = []): ResponseInterface
    {
        $attempt = 0;

        start:
        try {
            return $this->client->requestRaw($method, $url, $options);
        } catch (RequestException $e) {
            $status = $e->getResponse() ? $e->getResponse()->getStatusCode() : 0;

            if (in_array($status, [429, 500, 502, 503], true) && $attempt < $this->retryTimes) {
                $attempt++;
                usleep($this->retrySleepMs * 1000);
                goto start;
            }

            throw WbApiClientException::fromException($e);
        }
    }
}

